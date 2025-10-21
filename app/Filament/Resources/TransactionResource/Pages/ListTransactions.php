<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use App\Filament\Widgets\CompletedQueue;
use App\Filament\Widgets\QueueAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListTransactions extends ListRecords
{
    protected static string $resource = TransactionResource::class;


    protected function getHeaderWidgets(): array
    {

        return [
            QueueAction::make(['station' => 8, 'column' => 'step_name', 'condition' => 'transaction']),
            CompletedQueue::make(['station' => 8, 'status' => 1, 'column' => 'step_name', 'condition' => 'transaction']),
            CompletedQueue::make(['station' => 8, 'status' => 4, 'column' => 'step_name', 'condition' => 'transaction']),
            CompletedQueue::make(['station' => 8, 'status' => 3, 'column' => 'step_name', 'condition' => 'transaction']),
        ];
    }

    public function getHeaderWidgetsColumns(): int | string | array
    {
        return 3;
    }

    protected function getHeaderActions(): array
    {
        return [
        ];
    }
}
