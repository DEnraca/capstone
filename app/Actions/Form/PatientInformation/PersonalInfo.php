<?php

namespace App\Actions\Form\PatientInformation;

use Lorisleiva\Actions\Concerns\AsAction;
use App\Models\CivilStatus;
use App\Models\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;


class PersonalInfo
{
    use AsAction;

    public function handle()
    {
        $schema =
            [
                TextInput::make('last_name')
                    ->prefixIcon('heroicon-o-user')
                    ->prefixIconColor('primary')
                    ->helperText('Kindly include suffix after last name, e.g. II, III')
                    ->label('Last Name')
                    ->required(),

                TextInput::make('first_name')
                    ->prefixIcon('heroicon-o-user')
                    ->prefixIconColor('primary')
                    ->label('First Name')
                    ->required(),

                TextInput::make('middle_name')
                    ->prefixIcon('heroicon-o-user')
                    ->prefixIconColor('primary')
                    ->label('Middle Name'),

                TextInput::make('mobile')
                    ->tel() // or
                    ->prefixIcon('heroicon-o-phone')
                    ->prefixIconColor('primary')
                    ->minLength(10)
                    ->maxLength(10)
                    ->columnSpan(2)
                    ->prefix('+63')
                    ->label('Phone')
                    ->helperText('Mobile number must start with +63')
                    ->required(),

                DatePicker::make('dob')
                    ->required()
                    ->prefixIcon('heroicon-o-calendar-days')
                    ->prefixIconColor('primary')
                    ->maxDate(now()->subYear())
                    ->closeOnDateSelection()
                    ->label('Birthdate'),

                Select::make('gender')
                    ->label('Gender')
                    ->options( fn () => Gender::all()->pluck('name','id')->toArray() )
                    ->required(),

                Select::make('civil_status')
                    ->label('Civil Status')
                    ->options( fn () => CivilStatus::all()->pluck('name','id')->toArray() )
                    ->required(),

            ];

        return $schema;

    }
}
