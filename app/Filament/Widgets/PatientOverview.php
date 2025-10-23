<?php

namespace App\Filament\Widgets;

use App\Models\Appointment;
use App\Models\Queue;
use App\Models\QueueChecklist;
use App\Models\Transaction;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Psy\Readline\Transient;

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
        $patient_today = Transaction::whereDate('created_at', now())->count();
        $on_queue = QueueChecklist::pending()->count();
        $completed = QueueChecklist::completedToday()->count();
        $totalAppointments = Appointment::whereDate('appointment_date', now()->format('Y-m-d'))->get();
        $queued_appointment_today = Queue::whereDate('queue_start', today())
            ->whereIn('appointment_id', $totalAppointments->pluck('id')->toArray())
            ->count();


        return [
            Stat::make('', $patient_today)
                ->color('success')
                ->description("Today's Patient")
                ->icon('heroicon-s-user-group'),

            Stat::make("", $on_queue)
                ->color('warning')
                ->description("On Queue")
                ->icon('heroicon-s-clock'),

            Stat::make("", $completed)
                ->color('success')
                ->description("Completed")
                ->icon('heroicon-s-check-circle'),

            Stat::make("", "{$queued_appointment_today} / {$totalAppointments->count()}")
                ->color('text-blue-500')
                ->description("Has appointment today")
                ->icon('heroicon-s-calendar-date-range'),

            //
        ];
    }
}
