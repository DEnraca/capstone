<?php

namespace App\Filament\Resources\SignatoryResource\Pages;

use App\Filament\Resources\SignatoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateSignatory extends CreateRecord
{
    protected static string $resource = SignatoryResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
{
    $data['employee_id'] = auth()->user()->id;
 
    return $data;
}
}
