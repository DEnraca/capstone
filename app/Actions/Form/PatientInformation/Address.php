<?php

namespace App\Actions\Form\PatientInformation;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Lorisleiva\Actions\Concerns\AsAction;

class Address
{
    use AsAction;

    public function handle()
    {
        $schema = [
            Select::make('region_id')
                ->label('Region')
                ->options( fn (): array => getRegionsCustom())
                ->live()
                ->optionsLimit(75)
                ->afterStateUpdated(function (callable $set) {
                    $set('province_id', null);
                    $set('city_id', null);
                    $set('barangay_id', null);
                })
                ->required(),

            Select::make('province_id')
                ->label('Province')
                ->options( fn (callable $get): array => getProvincesCustom($get('region_id')) )
                ->disabled(fn (callable $get) => !$get('region_id'))
                ->afterStateUpdated(function (callable $set) {
                    $set('city_id', null);
                    $set('barangay_id', null);
                })
                ->searchable()
                ->live()
                ->optionsLimit(75)
                ->required(),

            Select::make('city_id')
                ->label('Municipality/City')
                ->options( fn (callable $get): array => getCitiesCustom($get('province_id')) )
                ->disabled(fn (callable $get) => !$get('province_id'))
                ->searchable()
                ->afterStateUpdated(function (callable $set) {
                    $set('barangay_id', null);
                })
                ->live()
                ->optionsLimit(75)
                ->required(),

            Select::make('barangay_id')
                ->label('Barangay')
                ->options( fn (callable $get): array => getBarangayCustom($get('city_id')) )
                ->disabled(fn (callable $get) => !$get('city_id'))
                ->searchable()
                ->live()
                ->optionsLimit(75)
                ->required(),

            TextInput::make('house_address')
                ->columnSpanFull()
                ->helperText('House no., Street, Subdivision, Village')
                ->label('House Address')
                ->required(),
        ];

        return $schema;
        // ...
    }
}
