<?php

namespace App\Filament\Widgets;

use App\Models\Queue;
use App\Models\QueueChecklist;
use App\Models\QueueStatus;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class CompletedQueue extends BaseWidget
{

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
                QueueChecklist::where('station_id', $this->station)
                    ->where($this->column,$this->condition)
                    ->applySorting()
                    ->today()
                    ->where('latest_status', $this->status)
            // ...
            )
            ->columns([
                TextColumn::make('queue.queue_number')
            ]);
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


}
