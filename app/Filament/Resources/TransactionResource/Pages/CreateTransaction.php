<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Widgets\QueueAction;
use App\Models\QueueChecklist;
use App\Models\Transaction;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;

class CreateTransaction extends CreateRecord
{

    protected static string $resource = TransactionResource::class;

    protected static bool $canCreateAnother = false;
    public ?QueueChecklist $checklist_details = null;

    public $patientTests = [];
    public $code;

    public function mount(?QueueChecklist $checklist_details = null): void
    {

        parent::mount(); // important: always call this first
        if(!$checklist_details){
            Notification::make('Transaction Creation')
                ->title('No checklist details found.')
                ->danger()
                ->send();
            redirect()->route('filament.admin.resources.transactions.index');
        }
        else{
            $code  = generateTransCode();
            $this->code = $code;
            $filled = [
                'code' => $code,
                'queue' => $checklist_details->queue,
                'patient' => $checklist_details->queue->patient,
            ];

            $filled['patient']['address'] = $checklist_details->queue->patient->address;

            if($checklist_details->queue->appointment){
                $filled['tests'] = $checklist_details->queue->appointment->services->map(function($service){
                    return [
                        'service_id' => $service->id,
                        'status_id' => 1,
                    ];
                })->toArray();
            }
            $this->form->model(Transaction::make());

            $this->form->fill($filled);
        }

    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $to_complete = clone $this->checklist_details;
        $to_complete->is_current = false;
        $to_complete->latest_status = 4;
        $to_complete->update();
        $nextStation = $to_complete->queue->checklists()->pending()->where('id', '!=', $to_complete->id)->orderBy('id','asc')->first();
        if($nextStation){
            $nextStation->is_current = true;
            $nextStation->update();
        }
        $this->patientTests = $data['tests'] ?? [];
        $data['queue_id'] = $this->checklist_details->queue_id;
        $data['patient_id'] = $this->checklist_details->queue->patient_id;
        $data['code'] = $this->code;
        $data['created_by'] = auth()->user()->employee->id;
        unset($data['tests']); // prevent Filament trying to sync prematurely
        return $data;
    }

    protected function afterCreate(): void
    {
        $last_sort = $this->checklist_details->queue->checklists()->max('sort_order') ?? 0;
        foreach ($this->patientTests as $test) {
            $test = $this->record->tests()->create($test);
            $last_sort += 1;
            QueueChecklist::insert([
                'queue_id' => $this->checklist_details->queue_id,
                'station_id' => $test->service->station_id,
                'service_id' => $test->service->id,
                'sort_order' => $last_sort
            ]);
        }

        $action = new QueueAction();
        $action->getTimestamp($this->checklist_details->id, 4); // completed timestamp


        redirect()->route('filament.admin.resources.transactions.index');
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }


}
