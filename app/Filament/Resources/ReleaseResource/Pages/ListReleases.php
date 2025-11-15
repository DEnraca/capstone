<?php

namespace App\Filament\Resources\ReleaseResource\Pages;

use App\Filament\Resources\ReleaseResource;
use App\Filament\Widgets\CompletedQueue;
use App\Filament\Widgets\QueueAction;
use App\Models\Release;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListReleases extends ListRecords
{
    protected static string $resource = ReleaseResource::class;


    protected function getTableQuery(): Builder
    {
        return Release::query()
            ->with('transaction')
            ->with([
                'transaction.patient',
            ]);
    }


    protected function getHeaderWidgets(): array
    {
        return [
            QueueAction::make(['station' => 9, 'column' => 'step_name', 'condition' => 'releasing']),
            CompletedQueue::make(['station' => 9, 'status' => 1, 'column' => 'step_name', 'condition' => 'releasing']),
            CompletedQueue::make(['station' => 9, 'status' => 4, 'column' => 'step_name', 'condition' => 'releasing']),
            CompletedQueue::make(['station' => 9, 'status' => 3, 'column' => 'step_name', 'condition' => 'releasing']),
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
