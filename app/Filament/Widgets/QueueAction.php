<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\InvoiceResource;
use App\Filament\Resources\TestResultResource;
use App\Filament\Resources\TransactionResource;
use App\Models\PatientInformation;
use App\Models\QueueCall;
use App\Models\QueueChecklist;
use App\Models\QueueTimestamp;
use App\Models\TestResult;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class QueueAction extends Widget
{
    use HasWidgetShield;

    protected int | string | array $columnSpan = 'full';


    protected $listeners = [
        'recall_queue' => 'handleRecallQueue',
    ];


    protected static string $view = 'filament.widgets.queue-action';

    public $patients = null;
    public $patient = null;

    public $status;
    public $checklists;
    public $column;
    public $condition;
    public $station;
    public $current;
    public $nextInLine;
    public $callAnother;
    public $is_completed;

    public function mount() : void
    {
        $this->is_completed = false;
        $this->refresh();
    }

    public static function canView(): bool
    {
        // Hide only when on the dashboard
        if(!auth()->user()->can(static::getPermissionName())){
            return false;
        }
        if (request()->routeIs('filament.admin.pages.dashboard')) {
            return false;
        }

        return true;
    }

    public function handleRecallQueue($id){
        if($this->current){
            $this->setStatus(2);
        }
        $this->setActive($id);
        $this->setStatus(1);

    }



    public function setActive($id)
    {
        $this->callAnother = $id;
        $this->refresh();
        $this->getTimestamp($id,1);
        $this->call($id);
        return;
    }


    public function complete(){

        if($this->is_completed){
            $to_complete = clone $this->current;
            $this->setStatus(4);
            $to_complete->is_current = false;
            $to_complete->update();
            $nextStation = $to_complete->queue->checklists()->pending()->where('id', '!=', $to_complete->id)->orderBy('id','asc')->first();
            if($nextStation){
                $nextStation->is_current = true;
                $nextStation->update();
            }
            return;
        }

        if($this->station == 8 && $this->column == 'step_name' && $this->condition == 'patient_info'){
            //process patient verification
            $this->patientverification();
        }

        if($this->station == 8 && $this->column == 'step_name' && $this->condition == 'transaction'){
            return redirect(TransactionResource::getUrl('create', ['checklist_details' => $this->current]));
        }

        if($this->station == 10 && $this->column == 'step_name' && $this->condition == 'billing'){
            return redirect(InvoiceResource::getUrl('create', ['checklist_details' => $this->current]));
        }


        if($this->column == 'service_id'){
            return redirect(TestResultResource::getUrl('create', ['checklist_details' => $this->current]));
        }



    }

    public function patientverification(){

        $this->patient  = $this->current->queue?->patient?->id ?? null;
        $this->patients = PatientInformation::orderBy('pat_id', 'asc')->get();
        return $this->dispatch('open-modal', id: 'patient-verify-modal');

    }

    public function verifypatient(){

        $this->patient  = $this->current->queue?->patient?->id ?? null;
        $this->dispatch('close-modal', id: 'patient-verify-modal');

        if(!$this->patient){
            $this->is_completed = false;
            $this->complete();
            return;
        }
        if(!($this->current->queue?->patient?->id ?? false)){
            $this->current->queue->patient_id = $this->patient;
            $this->current->queue->update();
        }
        $this->is_completed = true;
        $this->complete();
        return;
    }


    public function getTimestamp($checklistID, $status){
        $timestamp = QueueTimestamp::where('queue_checklists',$checklistID)
            ->where('queue_statuses',$status)
            ->first();
        if(!$timestamp){
            $timestamp = QueueTimestamp::insert([
                'queue_checklists' => $checklistID,
                'queue_statuses' => $status,
                'first_called_at' => now(),
            ]);
        }
        return $timestamp;

    }

    public function setStatus($status)
    {
        $current = $this->current;
        $current->latest_status = $status;
        $current->update();
        $this->getTimestamp($current->id, $status);
        $this->refresh();

        if($status == 3){
            $this->current = null;
        }
        return;
    }

    public function call($checklistID){
        $call_details = QueueCall::where('queue_checklist',$checklistID)->first();
        if($call_details){
            $call_details->is_called = false;
            $call_details->update();
            return;
        }
        QueueCall::insert([
            'queue_checklist' => $checklistID,
            'is_called' => false,
            'should_remove' => false,
        ]);

        return;

    }
    public function recall($checklistID){
        $this->call($checklistID);
        $timestamp = $this->getTimestamp($checklistID, 1);
        $timestamp->recalled_last_at = now();
        $timestamp->update();
    }


    public function refresh(){
        $checklist = QueueChecklist::where('station_id', $this->station)
            ->where($this->column,$this->condition)
            ->applySorting()
            ->today()
            ->current();
        $current = (clone $checklist)->processing();
        // dd($current);
        $this->nextInLine = (clone $checklist)->pending()->first();
        if($current->first()){
            $this->current = $current->first();
        }else if($this->callAnother){
            $this->current = (clone $checklist)->where('queue_checklists.id',$this->callAnother)->first();
            $this->nextInLine = (clone $checklist)->pending()->where('queue_checklists.id','!=',$this->callAnother)->first();
        }else{
            $this->current = null;
        }
    }

}
