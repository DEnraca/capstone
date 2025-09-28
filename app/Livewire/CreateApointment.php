<?php

namespace App\Livewire;

use App\Forms\Components\ServicesSelect;
use App\Models\Appointment;
use Livewire\Component;
use Filament\Notifications\Notification;
class CreateApointment extends Component
{
    public $data;


    public $page;

    protected $listeners = [
        'changePage' => 'handlechangePage',
        'backPage' => 'getPage',

    ];


    public function mount(): void
    {
        $this->getPage('');

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

    public function handlechangePage($fromPage){
        if($fromPage == 'service-selection'){
            return $this->getPage(2);
        }

        if($fromPage == 'appointment-details'){
            return $this->getPage(3);
        }

        return $this->getPage(1);
    }

    public function saveAppointment(){
        dd(session()->all());
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
                    'current_page' => 1,
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
