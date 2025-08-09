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

    public function mount(): void
    {
        $this->form->fill();
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
                                        ->default(now()->format('Y-m-d'))
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
                                            ->default('Enraca')
                                            ->helperText('Kindly include suffix after last name, e.g. II, III')
                                            ->label('Last Name')
                                            ->required(),

                                        TextInput::make('first_name')
                                            ->prefixIcon('heroicon-o-user')
                                            ->default('Dennis')
                                            ->prefixIconColor('primary')
                                            ->label('First Name')
                                            ->required(),

                                        TextInput::make('middle_name')
                                            ->prefixIcon('heroicon-o-user')
                                            ->prefixIconColor('primary')
                                            ->default('Abellera')
                                            ->label('Middle Name'),
                                    ]),


                            TextInput::make('email')
                                ->email() // or
                                ->prefixIcon('heroicon-o-at-symbol')
                                ->prefixIconColor('primary')
                                ->label('Email')
                                ->default('dennisenraca25@gmail.com')
                                ->required(),

                            TextInput::make('mobile')
                                ->tel() // or
                                ->prefixIcon('heroicon-o-phone')
                                ->prefixIconColor('primary')
                                ->minLength(10)
                                ->maxLength(10)
                                ->prefix('+63')
                                ->label('Phone')
                                ->default('9050449294')
                                ->helperText('Mobile number must start with +63')
                                ->required(),

                            Textarea::make('message')
                                ->placeholder('I want to book an appointment')
                                ->rows(3)
                                ->default('Test')
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


}
