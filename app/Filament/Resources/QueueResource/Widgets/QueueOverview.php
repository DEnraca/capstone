<?php

namespace App\Filament\Resources\QueueResource\Widgets;

use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Illuminate\Database\Eloquent\Model;

class QueueOverview extends BaseWidget
{
    public ?Model $record = null;


    protected function getStats(): array
    {
        dd($this->record->currentStatus);
        return [
            Stat::make('Queue Number', $this->record->queue_number)
                ->color('success'),

            Stat::make('Current Status', $this->record->currentStatus() ?? 'Pending')
                ->color('danger'),
            Stat::make('Current Station', 'Admission')
                ->description('Patient Info')
                ->color('success')

            //
        ];
    }
}
