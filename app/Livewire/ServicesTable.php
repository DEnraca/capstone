<?php

namespace App\Livewire;

use App\Models\Service;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Support\Enums\Alignment;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\Layout\Stack;
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

class ServicesTable extends BaseWidget
{
    public $selectedService;

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

                // Filter::make('price_sort')
                //     ->form([
                //         Select::make('sort_by')
                //             ->options([
                //                 'asc' => 'Low to High',
                //                 'desc' => 'High to Low',
                //             ])
                //     ])
                //     ->query(function (Builder $query, array $data): Builder {

                //         if($data['sort_by']){
                //             return $query->orderBy('price', $data['sort_by']);
                //         }
                //         return $query;
                //     })
                //     ->label('Sort by Price')
                //     ->default('asc'),
            ], layout: FiltersLayout::Modal)
            ->contentGrid([
                'sm' => 3,
                'md' => 4,
                'xl' => 5,
            ])
            // ->striped()
            ->actions( [
                Action::make('view_more')
                    ->color('info')
                    ->button()
                    ->visible(function (Service $record) {
                        return (in_array( $record->id,$this->selectedService ?? [])) ? false : true;
                    })
                    ->action( function (Service $record) {
                        $this->dispatch('serviceAdded', id: $record->id);
                        $this->selectedService = session('selected_service');
                    })
                    ->modalHeading( fn (Service $record) => ucfirst($record->name))
                    ->modalDescription( fn (Service $record) => nl2br($record->description))
                    ->modalCancelActionLabel('Cancel')
                    ->modalFooterActionsAlignment(Alignment::End)
                    ->modalSubmitActionLabel('Add to book'),

                Action::make('add')
                    ->button()
                    ->visible(function (Service $record) {
                        return (in_array( $record->id,$this->selectedService ?? [])) ? false : true;
                    })
                    ->action(function (Service $record){
                        $this->dispatch('serviceAdded', id: $record->id);
                        $this->selectedService = session('selected_service');
                    }),

            ])
            ->columns([
                Stack::make([
                    TextColumn::make('name')->searchable(),
                    TextColumn::make('code')->searchable(),
                    // TextColumn::make('station.name')->searchable(),
                    // TextColumn::make('department.name')->searchable(),
                    TextColumn::make('description')
                        ->searchable()
                        ->limit(50),
                    TextColumn::make('price'),
                ])
            ]);
    }


    protected function getTableHeading(): string|Htmlable|null
    {
        return '';
    }



}

