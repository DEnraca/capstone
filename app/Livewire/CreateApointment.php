<?php

namespace App\Livewire;
use App\Models\Appointment;
use App\Models\Address;
use App\Models\User;
use App\Models\PatientInformation;
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
        $selectedService = session('selected_service',[]);
        $appointment_form = session('appointment_form',[]);

        $pat_id = (auth()->check()?->patient ?? null) ? auth()->user()->patient->id : null;
        if(!$pat_id){
            $address = Address::create($appointment_form['address']);
            $info = $appointment_form['info'];
            $info['address_id'] = $address->id;

            $user_id = User::create([
                'username' => generateUniqueUsername($info['first_name'],$info['middle_name'] ?? null,$info['last_name']),
                'firstname' => $info['first_name'],
                'lastname' => $info['last_name'],
                'email' => $appointment_form['account']['email'],
                'password' => $appointment_form['account']['password'],
                'email_verified_at' => now(),
            ]);

            $info['user_id'] = $user_id->id;

            $pat_id = PatientInformation::create($info);
            $pat_id = $pat_id->id;
        }

        $book = $appointment_form['book'];
        $book['patient_id'] = $pat_id;
        $appointment = Appointment::create($book);
        foreach($selectedService as $service){
            $appointment->services()->attach($service,['status' => 1]);
        }

        session()->flush();

        Notification::make()
            ->title('Appointment Created')
            ->success()
            ->send();

        return redirect()->route('home');
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
