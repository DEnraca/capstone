<?php

namespace App\Filament\Resources\TestResultResource\Pages;

use App\Filament\Resources\TestResultResource;
use App\Filament\Widgets\QueueAction;
use App\Models\QueueChecklist;
use App\Models\Service;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Contracts\Support\Htmlable;

class CreateTestResult extends CreateRecord
{
    protected static string $resource = TestResultResource::class;
    protected static bool $canCreateAnother = false;


    public $checklist_details;
    public $patient_tests;


    public function getTitle(): string | Htmlable
    {

        $service = Service::find($this->service_id);

        return  $service->code.' - '. $service->name.' Results';
    }





    public function mount(?QueueChecklist $checklist_details = null): void
    {
        // dd($checklist_details);

        parent::mount(); // important: always call this first

        if(!$checklist_details){
            Notification::make('Test Result Failed')
                ->title('No checklist details found.')
                ->danger()
                ->send();
            redirect()->back();
        }
        else{
            $this->check($checklist_details);
        }

    }

    public function check($checklist_details){

        $patient_tests = $checklist_details?->queue?->transaction?->tests->where('service_id', $checklist_details->service_id)->first() ?? false;
        if(!$patient_tests){
            Notification::make('Test Result Failed')
                ->title('The selected services not found on transaction checklists.')
                ->danger()
                ->send();
            return redirect()->back();
        }
        $this->patient_tests = $patient_tests;

        $filled = [
            'service_name' => 'test',
        ];
        $this->form->fill($filled);

    }

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['patient_tests_id'] = $this->patient_tests->id;
        $data['status_id'] = 4;

        return $data;
    }


    protected function afterCreate(): void
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


        $action = new QueueAction();
        $action->getTimestamp($this->checklist_details->id, 4); // completed timestamp

        redirect()->route('filament.admin.resources.invoices.index');
    }





}
