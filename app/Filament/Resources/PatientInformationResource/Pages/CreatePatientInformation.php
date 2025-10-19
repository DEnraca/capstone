<?php

namespace App\Filament\Resources\PatientInformationResource\Pages;

use App\Filament\Resources\PatientInformationResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class CreatePatientInformation extends CreateRecord
{
    protected static string $resource = PatientInformationResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $record = static::getModel()::create($data);

        return $record;
    }

    protected function afterCreate(): void
    {
        DB::table('model_has_roles')->insert([
            'role_id' => 3,
            'model_type' => 'App\Models\User',
            'model_id' => $this->record->user_id,
        ]);
    }

}
