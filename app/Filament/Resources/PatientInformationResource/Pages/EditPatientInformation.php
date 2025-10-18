<?php

namespace App\Filament\Resources\PatientInformationResource\Pages;

use App\Filament\Resources\PatientInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPatientInformation extends EditRecord
{
    protected static string $resource = PatientInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
