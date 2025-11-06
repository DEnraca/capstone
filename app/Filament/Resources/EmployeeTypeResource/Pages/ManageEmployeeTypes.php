<?php

namespace App\Filament\Resources\EmployeeTypeResource\Pages;

use App\Filament\Resources\EmployeeTypeResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEmployeeTypes extends ManageRecords
{
    protected static string $resource = EmployeeTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
