<?php

namespace App\Filament\Resources\TestResultResource\Pages;

use App\Filament\Resources\TestResultResource;
use App\Filament\Widgets\CompletedQueue;
use App\Filament\Widgets\QueueAction;
use App\Models\Service;
use App\Models\TestResult;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Database\Eloquent\Builder;

class ListTestResults extends ListRecords
{
    protected static string $resource = TestResultResource::class;

    public $service_id;



    public function getTitle(): string | Htmlable
    {

        $service = Service::find($this->service_id);

        return  $service->code.' - '. $service->name.' Results';
    }


    protected function getHeaderWidgets(): array
    {

        $service = Service::find($this->service_id);
        return [
            QueueAction::make(['station' => $service->station_id, 'column' => 'service_id', 'condition' => $service->id]),
            CompletedQueue::make(['station' => $service->station_id, 'status' => 1, 'column' => 'service_id', 'condition' => $service->id]),
            CompletedQueue::make(['station' => $service->station_id, 'status' => 4, 'column' => 'service_id', 'condition' => $service->id]),
            CompletedQueue::make(['station' => $service->station_id, 'status' => 3, 'column' => 'service_id', 'condition' => $service->id]),
        ];
    }

    public function getHeaderWidgetsColumns(): int | string | array
    {
        return 3;
    }


    public function mount($service_id = null): void
    {
        $this->service_id = $service_id;
        if(!$service_id){

            redirect()->route('filament.admin.pages.dashboard');

            Notification::make()
                ->title('No Service Selected')
                ->danger()
                ->send();
        }
    }

    protected function getTableQuery(): Builder
    {
        return TestResult::query()
            ->with('test')
            ->with([
                'test.transaction',
                'test.transaction.patient'
            ])
            ->whereHas('test', function ($query) {
                $query->where('service_id', $this->service_id);
            });
    }

    protected function applyFiltersToTableQuery(Builder $query): Builder
    {
        // Prevent Filament from calling ->withoutTrashed() for this query
        return $query;
    }

}
