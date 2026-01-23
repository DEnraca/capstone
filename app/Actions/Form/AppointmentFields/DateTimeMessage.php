<?php

namespace App\Actions\Form\AppointmentFields;

use Carbon\Carbon;
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
                ->minDate(now()->startOfDay())
                ->columnSpan(1)
                ->reactive()
                ->label('Date'),

            Select::make('appointment_time')
                ->label('Time')
                ->placeholder('Select Time')
                ->prefixIcon('heroicon-o-clock')
                ->prefixIconColor('primary')
                ->required()
                ->reactive() // IMPORTANT
                ->disableOptionWhen(function (string $value, callable $get): bool {
                    $selectedDate = $get('appointment_date');

                    if (! $selectedDate) {
                        return false; // no date selected yet
                    }

                    $selectedDate = Carbon::parse($selectedDate)->startOfDay();
                    $today = now()->startOfDay();

                    // If selected date is today
                    if ($selectedDate->equalTo($today)) {
                        $slotTime = Carbon::createFromFormat('H:i', $value);
                        $currentTime = now();

                        return $slotTime->lessThanOrEqualTo($currentTime);
                    }

                    return false; // future dates → no disabled slots
                })
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
