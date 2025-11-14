<?php

namespace App\Filament\Widgets;

use App\Models\Queue;
use App\Models\QueueChecklist;
use App\Models\QueueStatus;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Filament\Tables\Actions\Action;

class CompletedQueue extends BaseWidget
{

    use HasWidgetShield;

    public $status;
    public $checklists;
    public $column;
    public $condition;
    public $station;

    protected int | string | array $columnSpan = 1;

    public function table(Table $table): Table
    {

        return $table
            ->paginated(false)
            ->query(
                $this->tableQuery()
            // ...
            )
            ->columns([
                TextColumn::make('queue.queue_number'),
                TextColumn::make('status.name')
                    ->badge()
                    ->color(fn (string $state): string => match ($state) {
                        'Pending' => 'warning',
                        'Paused' => 'gray',
                        'Completed' => 'success',
                        'Removed' => 'danger',
                    }),
            ])
            ->actions([
                Action::make('recall')
                    ->label('Call')
                    ->color('success')
                    ->icon('heroicon-o-speaker-wave')
                    ->visible(fn ($record)=> ($record->latest_status != 4))
                    ->action(function ($record) {
                        $this->dispatch('recall_queue', $record->id);
                        // record
                        // $this->dispatch('', $record->id);
                    })
                    ->requiresConfirmation()

            ]);
    }

    public function tableQuery(){
        $status = [$this->status];
        if($this->status == 3){
            $status = [3,5];
        }
        $query = QueueChecklist::where('station_id', $this->station)
            ->where($this->column,$this->condition)
            ->applySorting()
            ->today()
            ->whereIn('latest_status', $status);

        if($this->status == 1){
            $query->current();
        }
        return $query;

    }
    protected function getTableHeading(): ?string
    {
        $name = QueueStatus::find($this->status)?->name ?? 'Undefined Status';
        if($this->status == 3 || $this->status == 5){
            $name = 'Paused & Removed';
        }
        // You can return a simple string or more complex HTML here
        return  $name;
    }


    public static function canView(): bool
    {
        if(!auth()->user()->can(static::getPermissionName())){
            return false;
        }
        // Hide only when on the dashboard
        if (request()->routeIs('filament.admin.pages.dashboard')) {
            return false;
        }

        return true;
    }

}
