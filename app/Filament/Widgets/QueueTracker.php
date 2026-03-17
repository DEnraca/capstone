<?php

namespace App\Filament\Widgets;

use App\Models\Queue;
use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class QueueTracker extends Widget
{
    use HasWidgetShield;

    protected static string $view = 'filament.widgets.queue-tracker';

    public ?Queue $queue = null;

    protected static ?string $pollingInterval = '5s';

    protected int|string|array $columnSpan = 'full';

    public function mount(Queue $queue)
    {
        $this->queue = $queue;
    }


     public static function canView(): bool
    {
        // Hide only when on the dashboard
        if(!auth()->user()->can(static::getPermissionName())){
            return false;
        }
        if (request()->routeIs('filament.admin.pages.dashboard')) {
            // if(auth()->user()->hasRole('patient')){

            //     return true;
            // }
            return false;
        }

        return true;
    }


    public function getSteps()
    {
        return $this->queue
            ->checklists()
            ->with(['station','status'])
            ->orderBy('sort_order')
            ->get();
    }

}
