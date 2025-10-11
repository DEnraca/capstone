<?php

namespace App\Filament\Resources\QueueResource\Pages;

use App\Filament\Resources\QueueResource;
use App\Models\Appointment;
use App\Models\QueueChecklist;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateQueue extends CreateRecord
{
    protected static string $resource = QueueResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        if($data['appointment_id']){
            $appointment = Appointment::find($data['appointment_id']);
            if($appointment){
                $data['patient_id']  = $appointment->patient_id ?? null;
            }
        }
        $data['queue_number'] = generateQueueNumber();
        $data['queue_start'] = now();
        $data['created_by'] = auth()->user()->employee ? auth()->user()->employee->id : null;
        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {

        $record = static::getModel()::create($data);

        QueueChecklist::insert([
            [
                'queue_id' =>  $record->id,
                'station_id' => 8,
                'is_default_step' => true,
                'step_name' => 'patient_info',
                'sort_order' => 0,
            ],
            [
                'queue_id' =>  $record->id,
                'station_id' => 8,
                'is_default_step' => true,
                'step_name' => 'transaction',
                'sort_order' => 1,
            ],

            [
                'queue_id' =>  $record->id,
                'station_id' => 10,
                'is_default_step' => true,
                'step_name' => 'billing',
                'sort_order' => 2,
            ],

        ]);

        return $record; // Filament expects the Model to be returned

    }


    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('view_queueboard')
                ->color('primary')
                ->label('View Queue Board')
                ->url('/admin/queue-board', shouldOpenInNewTab: true),
        ];
    }

}
