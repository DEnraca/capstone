<?php

namespace App\Filament\Resources\PositionDepartmentResource\Pages;

use App\Filament\Resources\PositionDepartmentResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManagePositionDepartments extends ManageRecords
{
    protected static string $resource = PositionDepartmentResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
