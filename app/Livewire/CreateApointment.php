<?php

namespace App\Livewire;

use App\Forms\Components\ServicesSelect;
use App\Models\Appointment;
use App\Models\Service;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Forms\Components\Wizard;
use Filament\Notifications\Notification;
use Illuminate\Support\HtmlString;

class CreateApointment extends Component implements HasForms
{
    use InteractsWithForms;
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


    public function form(Form $form): Form
    {
        return $form
            ->schema([

                Wizard::make([
                    Wizard\Step::make('Select Services')
                        ->schema([
                            Select::make('services')
                                ->label('Select Services')
                                ->relationship('services', 'name')
                                ->options(Service::orderBy('name','asc')->pluck('name', 'id'))
                                ->multiple(),
                            // ServicesSelect::make('services')
                            //     ->label(' ')
                            //     ->required(),
                            // ...
                        ]),
                    Wizard\Step::make('Appointment Details')
                        ->schema([

                            Grid::make(2)
                                ->schema([
                                    DatePicker::make('appointment_date')
                                        ->required()
                                        ->native(false)
                                        ->prefixIcon('heroicon-o-calendar-days')
                                        ->prefixIconColor('primary')
                                        ->closeOnDateSelection()
                                        ->label('Date'),

                                    Select::make('appointment_time')
                                        ->label('Time')
                                        ->default('8:30')
                                        ->placeholder('Select Time')
                                        ->prefixIcon('heroicon-o-clock')
                                        ->prefixIconColor('primary')
                                        ->required()
                                        ->disableOptionWhen(fn (string $value): bool => ($value) === '08:30')
                                        ->options(fn () => get_appointment_timeslots())
                                        ->searchable(),
                                ])->columnSpan(2),


                                Fieldset::make('Full Name')
                                    ->columns(3)
                                    ->schema([
                                        TextInput::make('last_name')
                                            ->prefixIcon('heroicon-o-user')
                                            ->prefixIconColor('primary')
                                            ->helperText('Kindly include suffix after last name, e.g. II, III')
                                            ->label('Last Name')
                                            ->required(),

                                        TextInput::make('first_name')
                                            ->prefixIcon('heroicon-o-user')
                                            ->prefixIconColor('primary')
                                            ->label('First Name')
                                            ->required(),

                                        TextInput::make('middle_name')
                                            ->prefixIcon('heroicon-o-user')
                                            ->prefixIconColor('primary')
                                            ->label('Middle Name'),
                                    ]),


                            TextInput::make('email')
                                ->email() // or
                                ->prefixIcon('heroicon-o-at-symbol')
                                ->prefixIconColor('primary')
                                ->label('Email')
                                ->required(),

                            TextInput::make('mobile')
                                ->tel() // or
                                ->prefixIcon('heroicon-o-phone')
                                ->prefixIconColor('primary')
                                ->minLength(10)
                                ->maxLength(10)
                                ->prefix('+63')
                                ->label('Phone')
                                ->helperText('Mobile number must start with +63')
                                ->required(),

                            Textarea::make('message')
                                ->placeholder('I want to book an appointment')
                                ->rows(3)
                                ->columnSpan(2)
                                ->autosize(),

                            // ...
                        ])->columns(2),
                        Wizard\Step::make('Confirmation')
                        ->schema([
                            // ...
                        ]),
                ])->submitAction(new HtmlString('<button type="submit">Submit</button>'))
            ])
            ->model(Appointment::class)
            ->statePath('data')
            ->columns(1);
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
                    'page4' => false,
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
                    'page4' => false,
                    'showprev' => 2,
                    'shownext' => 4,
                ];
                break;
            case 4:
                $details = [
                    'current_page' => 4,
                    'page1' => true,
                    'page2' => true,
                    'page3' => true,
                    'page4' => true,
                    'showprev' => 3,
                    'shownext' => null,
                ];
                break;
            default:
                $details = [
                    'current_page' => 1,
                    'page1' => true,
                    'page2' => false,
                    'page3' => false,
                    'page4' => false,
                    'showprev' => null,
                    'shownext' => 2,
                ];
                break;
        }
        $this->page = $details;
    }



}
