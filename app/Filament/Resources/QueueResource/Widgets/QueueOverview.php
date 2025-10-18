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
        $currStation = $this->record->currentStation();
        $service = null;
        if($currStation){
            if($currStation->is_default_step){
                $service = str_replace('_', ' ', $currStation->step_name);
            }else{
                $service = $currStation->service->name;
            }
        }
        $service = ucwords($service);
        return [
            Stat::make('Queue Number', $this->record->queue_number)
                ->color('success'),

            Stat::make('Current Status', $this->record->currentStation()?->status->name ?? 'Pending')
                ->color('danger'),

            Stat::make('Current Station', $this->record->currentStation()?->station->name ?? 'N/A')
                ->description($service)
                ->color('success')
        ];
    }
}
