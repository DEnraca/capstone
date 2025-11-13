<?php

namespace App\Actions\Form\AppointmentFields;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Lorisleiva\Actions\Concerns\AsAction;

class DateTimeMessage
{
    use AsAction;

    public function handle()
    {
        $schema = [
            DatePicker::make('appointment_date')
                ->required()
                ->native(false)
                ->prefixIcon('heroicon-o-calendar-days')
                ->prefixIconColor('primary')
                ->closeOnDateSelection()
                ->minDate(now()->addDays(1)->startOfDay())
                ->columnSpan(1)
                ->label('Date'),

            Select::make('appointment_time')
                ->label('Time')
                ->placeholder('Select Time')
                ->prefixIcon('heroicon-o-clock')
                ->prefixIconColor('primary')
                ->required()
                ->disableOptionWhen(fn (string $value): bool => ($value) === '08:30')
                ->options(fn () => get_appointment_timeslots())
                ->columnSpan(1)
                ->searchable(),


            Textarea::make('message')
                ->placeholder('I want to book an appointment')
                ->rows(3)
                ->columnSpanFull()
                ->autosize(),
        ];
        return $schema;
        // ...
    }
}
