<?php

namespace App\Filament\Widgets;

use App\Models\Transaction;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class PatientOverview extends BaseWidget
{

    protected static ?int $sort = 2;
    protected int | string | array $columnSpan = 'full';


    protected function getColumns(): int
    {
        return 4;
    }

    //   protected function getColumns(): int|array
    // {
    //     return 1; // force stats to stack in 1 column inside the widget
    // }

    protected function getStats(): array
    {
        return [
            Stat::make('', '12')
                ->color('success')
                ->description("Today's Patient")
                ->icon('heroicon-s-user-group'),

            Stat::make("", '23')
                ->color('warning')
                ->description("On Queue")
                ->icon('heroicon-s-clock'),

            Stat::make("", '14')
                ->color('success')
                ->description("Completed")
                ->icon('heroicon-s-check-circle'),

            Stat::make("", '15/24')
                ->color('text-blue-500')
                ->description("Has appointment today")
                ->icon('heroicon-s-calendar-date-range'),

            //
        ];
    }
}
