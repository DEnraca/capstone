<?php

namespace App\Filament\Resources\TestResultResource\Pages;

use App\Filament\Resources\TestResultResource;
use App\Models\Service;
use App\Models\Station;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Table;
use Filament\Tables\Actions\Action;
use Illuminate\Contracts\Support\Htmlable;

class ServicesTable extends ListRecords
{

    protected static string $resource = TestResultResource::class;

    public $stationID;

    public function mount($stationID = null): void
    {
        $this->stationID = $stationID;
        if(!$stationID){
            redirect()->route('filament.admin.pages.dashboard');

            Notification::make()
                ->title('No Station Selected')
                ->danger()
                ->send();
        }
    }

    public function getTitle(): string | Htmlable
    {

        $service = Station::find($this->stationID);

        return $service->name.' Services';
    }

    protected function getTableQuery(): Builder
    {
        return Service::query()
            ->withCount([
                'patientTests as patient_tests_count' => function ($query) {
                    $query->where('status_id', '!=', 4);
                    $query->whereHas('transaction', function($q){
                        $q->where('billing_id','!=', null);
                    });
                },
            ])
            ->orderByDesc('patient_tests_count')
            ->where('station_id', $this->stationID);
    }



    public function table(Table $table): Table
    {
        return $table
            ->columns([
                Stack::make([
                    TextColumn::make('code'),
                    TextColumn::make('name'),
                    TextColumn::make('description'),
                    TextColumn::make('patient_tests_count')
                        ->badge()
                        ->sortable()
                        ->icon('heroicon-o-bell')
                        ->color('danger'),
                ])

            ])
            ->contentGrid([
                'md' => 3
            ])
            ->actions([

                Action::make('view')
                    ->url(fn (Service $record): string => TestResultResource::getUrl('sort', ['service_id' => $record->id]))
                    ->openUrlInNewTab()

                // ...
            ]);
    }


    protected function applyFiltersToTableQuery(Builder $query): Builder
    {
        // Prevent Filament from calling ->withoutTrashed() for this query
        return $query;
    }


}
