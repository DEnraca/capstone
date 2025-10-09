<?php

namespace App\Filament\Resources\QueueResource\Pages;

use App\Filament\Resources\QueueResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListQueues extends ListRecords
{
    protected static string $resource = QueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('view_queueboard')
                ->color('primary')
                ->label('View Queue Board')
                ->url('/admin/queue-board', shouldOpenInNewTab: true),
            Actions\CreateAction::make(),
        ];
    }
}
