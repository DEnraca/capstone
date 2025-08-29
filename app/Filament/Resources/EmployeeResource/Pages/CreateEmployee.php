<?php

namespace App\Filament\Resources\EmployeeResource\Pages;

use App\Filament\Resources\EmployeeResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateEmployee extends CreateRecord
{
    protected static string $resource = EmployeeResource::class;


    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['emp_id'] = generateEmpId();

        return $data;
    }

    protected function handleRecordCreation(array $data): Model
    {
        // Create the model
        $model = static::getModel()::create($data);
        $this->form->model($model)->saveRelationships();
        // Sync roles if roles data exists in $data
        if (isset($data['roles'])) {
            $model->user->roles()->sync($data['roles']);
        }

        // Return the created model instance
        return $model;
    }


}
