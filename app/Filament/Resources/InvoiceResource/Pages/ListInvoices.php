<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use App\Filament\Widgets\CompletedQueue;
use App\Filament\Widgets\QueueAction;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListInvoices extends ListRecords
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            QueueAction::make(['station' => 10, 'column' => 'step_name', 'condition' => 'billing']),
            CompletedQueue::make(['station' => 10, 'status' => 1, 'column' => 'step_name', 'condition' => 'billing']),
            CompletedQueue::make(['station' => 10, 'status' => 4, 'column' => 'step_name', 'condition' => 'billing']),
            CompletedQueue::make(['station' => 10, 'status' => 3, 'column' => 'step_name', 'condition' => 'billing']),
        ];
    }

    public function getHeaderWidgetsColumns(): int | string | array
    {
        return 3;
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
