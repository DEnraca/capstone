<?php

namespace App\Filament\Resources\InvoiceResource\Pages;

use App\Filament\Resources\InvoiceResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewInvoice extends ViewRecord
{
    protected static string $resource = InvoiceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('print')
            ->label('Download Invoice')
            ->icon('fas-file-pdf')
            ->color('success')
            ->openUrlInNewTab(true)
            ->url(fn ($record) => route('pdf.invoice',['id' => $record->id]))
            ->requiresConfirmation(),
            Actions\EditAction::make(),
        ];
    }
}
