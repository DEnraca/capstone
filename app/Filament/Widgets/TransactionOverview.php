<?php

namespace App\Filament\Widgets;

use App\Models\PatientTest;
use App\Models\Queue;
use App\Models\Transaction;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class TransactionOverview extends BaseWidget
{

    public $patient_id;

    protected static ?int $sort = 2;

    public function mount(): void {

        $this->patient_id = auth()->user()->patient->id ?? null;
    }


    public static function canView(): bool
    {
        // Check if the authenticated user has the 'isAdmin' permission or role
        if(auth()->user()?->patient?->id){
            return true;
        }
        return auth()->user()->hasRole('patient');
    }

    protected function getStats(): array
    {
        $trans = Transaction::where('patient_id', $this->patient_id);
        $tests = PatientTest::whereIn('transaction_id', $trans->pluck('id')->toArray())?->count() ?? 0;
        $queues = Queue::where('patient_id', $this->patient_id)?->count() ?? 0;


        return [

            Stat::make('', $trans?->count() ?? 0)
                ->color('success')
                ->description("Transactions")
                ->icon('heroicon-s-user-group'),

            Stat::make("", $queues)
                ->color('warning')
                ->description("Queues")
                ->icon('heroicon-s-clock'),

            Stat::make("", $tests)
                ->color('success')
                ->description("Tests")
                ->icon('heroicon-s-check-circle'),

            Stat::make("", $trans->orderBy('created_at', 'desc')->first()?->created_at?->format('M d, Y') ?? 'N/A')
                ->color('text-blue-500')
                ->description("Last Transaction Date")
                ->icon('heroicon-s-calendar-date-range')

        ];
    }
}
