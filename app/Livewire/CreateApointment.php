<?php

namespace App\Livewire;

use App\Forms\Components\ServicesSelect;
use App\Models\Appointment;
use Livewire\Component;
use Filament\Notifications\Notification;
class CreateApointment extends Component
{
    public $data;

    public $selectedService;
    public $page;

    protected $listeners = [
        'changePage' => 'handlechangePage',
    ];




    public function mount(): void
    {
        session(['selected_service' => []]);
        $this->getPage('');
    }

    public function gotoNext()
    {
        $this->getPage($this->page['shownext']);
    }

    public function gotoPrev()
    {
        $this->getPage($this->page['showprev']);
    }


    public function create(): void
    {
        $appointment = Appointment::create($this->form->getState());
        $this->form->model($appointment)->saveRelationships();

            Notification::make()
                ->title('Appointment Created')
                ->body('Your appointment has been successfully created.')
                ->success()
                ->send();

            redirect()->to('/');

    }

    public function render()
    {
        return view('livewire.create-apointment');
    }

    public function getPage($page){
        switch ($page) {
            case 2:
                $details = [
                    'current_page' => 2,
                    'page1' => true,
                    'page2' => true,
                    'page3' => false,
                    'showprev' => 1,
                    'shownext' => 3,
                ];
                break;
            case 3:
                $details = [
                    'current_page' => 3,
                    'page1' => true,
                    'page2' => true,
                    'page3' => true,
                    'showprev' => 2,
                    'shownext' => null,
                ];
                break;
            default:
                $details = [
                    'current_page' => 2,
                    'page1' => true,
                    'page2' => false,
                    'page3' => false,
                    'showprev' => null,
                    'shownext' => 2,
                ];
                break;
        }
        $this->page = $details;
    }



}
