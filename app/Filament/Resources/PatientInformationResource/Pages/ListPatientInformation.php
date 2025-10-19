<?php

namespace App\Filament\Resources\PatientInformationResource\Pages;

use App\Filament\Resources\PatientInformationResource;
use App\Filament\Widgets\CompletedQueue;
use App\Filament\Widgets\QueueAction;
use App\Models\QueueChecklist;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPatientInformation extends ListRecords
{
    protected static string $resource = PatientInformationResource::class;


    protected function getHeaderWidgets(): array
    {

        return [
            QueueAction::make(['station' => 8, 'column' => 'step_name', 'condition' => 'patient_info']),
            CompletedQueue::make(['station' => 8, 'status' => 1, 'column' => 'step_name', 'condition' => 'patient_info']),
            CompletedQueue::make(['station' => 8, 'status' => 4, 'column' => 'step_name', 'condition' => 'patient_info']),
            CompletedQueue::make(['station' => 8, 'status' => 3, 'column' => 'step_name', 'condition' => 'patient_info']),
        ];
    }

    public function getHeaderWidgetsColumns(): int | string | array
    {
        return 3;
    }



    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
