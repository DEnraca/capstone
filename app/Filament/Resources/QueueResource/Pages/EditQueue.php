<?php

namespace App\Filament\Resources\QueueResource\Pages;

use App\Filament\Resources\QueueResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQueue extends EditRecord
{
    protected static string $resource = QueueResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make('view_queueboard')
                ->color('primary')
                ->label('View Queue Board')
                ->url('/admin/queue-board', shouldOpenInNewTab: true),
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
            Actions\ForceDeleteAction::make(),
            Actions\RestoreAction::make(),
        ];
    }
}
