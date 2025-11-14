<?php

namespace App\Filament\Resources\PatientInformationResource\Pages;

use App\Filament\Resources\PatientInformationResource;
use App\Models\QueueChecklist;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreatePatientInformation extends CreateRecord
{
    protected static string $resource = PatientInformationResource::class;
    protected static bool $canCreateAnother = false;
    public $queue;

    public function mount(): void{
        if(request()->query('checklistID')){
            $queueChecklist = QueueChecklist::find(request()->query('checklistID'));
            if($queueChecklist){
                $this->queue = $queueChecklist->queue;
            }
        }
        $this->form->fill();
    }
    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);

        return $record;
    }

    protected function afterCreate(): void
    {
        if($this->queue){
            $this->queue->patient_id = $this->record->id;
            $this->queue->update();
        }
        DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'App\Models\User',
            'model_id' => $this->record->user_id,
        ]);
    }

}
