<?php

namespace App\Filament\Resources\PatientInformationResource\Pages;

use App\Filament\Resources\PatientInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewPatientInformation extends ViewRecord
{
    protected static string $resource = PatientInformationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
