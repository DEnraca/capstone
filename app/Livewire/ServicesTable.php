<?php

namespace App\Livewire;

use App\Models\Service;
use App\Settings\GeneralSettings;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\SpatieMediaLibraryImageColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Illuminate\Database\Eloquent\Builder;
use Filament\Widgets\Widget;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\QueryBuilder;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ServicesTable extends BaseWidget
{
    public $selectedService;

    public function mount(): void
    {
        $this->selectedService = session('selected_service', []);
    }

    protected $listeners = [
        'refreshServiceTable' => 'handleRefreshServiceTable',
    ];


    public function table(Table $table): Table
    {
        return $table
            ->query(
                Service::query()
            )
            ->filters([
                SelectFilter::make('station_id')
                    ->label('Station')
                    ->relationship('station', 'name'),
                SelectFilter::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'name'),
            ], layout: FiltersLayout::Modal)
            ->actions([
                Action::make('add')
                    ->label('Add to book')
                    ->button()
                    ->color('success')
                    ->size('xs')
                    ->visible(function (Service $record) {
                        return (in_array($record->id, $this->selectedService ?? [])) ? false : true;
                    })
                    ->action(function (Service $record) {
                        $this->add_item($record->id);
                    }),


                Action::make('view_more')
                    ->color('info')
                    ->button()
                    ->modalWidth('lg')
                    ->visible(function (Service $record) {
                        return (in_array($record->id, $this->selectedService ?? [])) ? false : true;
                    })
                    ->action(function (Service $record) {
                        $this->add_item($record->id);
                    })
                    ->modalContent(fn(Service $record): View => view(
                        'filament.pages.actions.custom-service-table',
                        ['record' => $record],
                    ))
                    ->modalHeading(fn(Service $record) => 'Service: ' . ucfirst($record->name))
                    ->modalCancelActionLabel('Cancel')
                    ->modalFooterActionsAlignment(Alignment::End)
                    ->modalSubmitActionLabel('Add to book'),



            ])
            ->columns([
                TextColumn::make('name')->searchable()->size('xs'),
                TextColumn::make('code')->searchable()->size('xs'),
                TextColumn::make('station.name')->searchable()->size('xs'),
                TextColumn::make('department.name')->searchable()->size('xs'),
                TextColumn::make('description')
                    ->searchable()->size('xs')
                    ->limit(50),
                TextColumn::make('price')->money('php')->sortable()->size('xs'),
                // Stack::make([

                // ])->extraAttributes([ 'class' => 'flex flex-col h-full',])
            ]);
    }

    public function handleRefreshServiceTable()
    {
        $this->selectedService = session('selected_service');
    }

    protected function getTableHeading(): string|Htmlable|null
    {
        return '';
    }

    public function add_item($id)
    {
        $this->selectedService = $this->selectedService ?? [];
        array_push($this->selectedService, $id);
        session(['selected_service' => $this->selectedService]);
        $this->dispatch('refreshChecklist');

        return;
    }
}
