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
        'serviceRemove' => 'handleServiceRemove',
        'refreshChecklist' => 'handleRefreshChecklist',
    ];

    public function handleServiceRemove($id)
    {
        $current = session('selected_service', []);

        // Search for the value and get its key
        if (($key = array_search($id, $current)) !== false) {
            // Unset the element using the found key
            unset($current[$key]);
            $current = array_values($current); // Re-index the array
            session(['selected_service' => $current]);
            $this->handleRefreshChecklist();

            $this->dispatch('refreshServiceTable');

            Notification::make()
                ->title('Removed')
                ->danger()
                ->send();

        }
    }

    public function submitServiceSelection(){
        if(count(session('selected_service', [])) == 0){
            Notification::make()
                ->title('No Service Selected')
                ->body('Please select at least one service to proceed.')
                ->danger()
                ->send();
            return;

        }
        $this->dispatch('changePage','service-selection');
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


