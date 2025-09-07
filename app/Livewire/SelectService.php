<?php

namespace App\Livewire;

use App\Models\Service;
use Filament\Notifications\Notification;
use Livewire\Component;

class SelectService extends Component
{
    public $selectedService;

    public function mount(): void {
        $this->handleRefreshChecklist();
    }
    protected $listeners = [
        'serviceAdded' => 'handleServiceAdded',
        'serviceRemove' => 'handleServiceRemove',
        'refreshChecklist' => 'handleRefreshChecklist',
    ];

    public function handleServiceAdded($id)
    {
        $current = session('selected_service', []);
        $current[] = $id;
        session(['selected_service' => $current]);

        Notification::make()
            ->title('Added')
            ->success()
            ->send();
        $this->handleRefreshChecklist();
    }

    public function handleServiceRemove($id)
    {
        $current = session('selected_service', []);
        $current = array_filter($current, fn($value) => $value != $id);
        // reindex numeric keys
        $current = array_values($current);
        session(['selected_service' => $current]);
        $this->handleRefreshChecklist();

        Notification::make()
            ->title('Removed')
            ->danger()
            ->send();

    }

    public function handleRefreshChecklist()
    {
        $this->selectedService = Service::whereIn('id',session('selected_service', []))->get();
    }

    public function render()
    {
        return view('livewire.select-service');
    }
}


