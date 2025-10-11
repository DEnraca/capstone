<?php

namespace App\Filament\Resources\QueueResource\Pages;

use App\Filament\Resources\QueueResource;
use App\Filament\Resources\QueueResource\Widgets\QueueOverview;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewQueue extends ViewRecord
{
    protected static string $resource = QueueResource::class;


    protected function getHeaderWidgets(): array
    {
        return [
            QueueOverview::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('view_queueboard')
                ->color('primary')
                ->label('View Queue Board')
                ->url('/admin/queue-board', shouldOpenInNewTab: true),
            Actions\EditAction::make(),
        ];
    }
}
