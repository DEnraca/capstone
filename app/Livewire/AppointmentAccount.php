<?php

namespace App\Livewire;

use App\Models\Gender;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class AppointmentAccount extends Component implements HasForms
{
    use InteractsWithForms;

    public $data;

    public $showModal = true;


    public function form(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Grid::make(3)
                ->schema([
                    Grid::make(1)
                        ->columnSpan(2)
                        ->schema( [

                            Placeholder::make('')
                                ->columnSpanFull()
                                ->hidden(fn () => auth()->check())
                                ->extraAttributes(['class' => 'text-center m-0'])
                                ->content(new HtmlString('
                                    <a
                                        x-on:click="$dispatch(\'open-modal\', { id: \'appoinment-login-modal\' })"
                                        class="cursor-pointer text-primary-500 hover:underline font-black rounded-lg text-sm px-3 py-2  m-0"
                                    >
                                        Click here to login if you already have an account.
                                    </a>
                                ')),

                            Fieldset::make('Personal Information')
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

                                    TextInput::make('mobile')
                                        ->tel() // or
                                        ->prefixIcon('heroicon-o-phone')
                                        ->prefixIconColor('primary')
                                        ->minLength(10)
                                        ->maxLength(10)
                                        ->columnSpan(2)
                                        ->prefix('+63')
                                        ->label('Phone')
                                        ->helperText('Mobile number must start with +63')
                                        ->required(),

                                    DatePicker::make('dob')
                                        ->required()
                                        ->prefixIcon('heroicon-o-calendar-days')
                                        ->prefixIconColor('primary')
                                        ->maxDate(now()->subYear())
                                        ->closeOnDateSelection()
                                        ->label('Birthdate'),

                                    Select::make('gender')
                                        ->label('Gender')
                                        ->options( fn () => Gender::all()->pluck('name','id')->toArray() )
                                        ->required(),

                                    Select::make('civil_status')
                                        ->label('Civil Status')
                                        ->options( fn () => Gender::all()->pluck('name','id')->toArray() )
                                        ->required(),

                                ]),

                                Fieldset::make('Address')
                                    ->columns(2)
                                    ->schema([
                                        Select::make('region_id')
                                            ->label('Region')
                                            ->required(),

                                        Select::make('province_id')
                                            ->label('Province')
                                            ->required(),

                                        Select::make('city_id')
                                            ->label('Municipality/City')
                                            ->required(),

                                        Select::make('barangay_id')
                                            ->label('Barangay')
                                            ->required(),

                                        TextInput::make('full_address')
                                            ->columnSpanFull()
                                            ->helperText('House no., Street, Subdivision, Village')
                                            ->label('House Address')
                                            ->required(),
                                    ]),
                    ]),
                    Grid::make(1)
                        ->columnSpan(1)
                        ->schema([
                            Fieldset::make('Book schedule')
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


                                    Textarea::make('message')
                                        ->placeholder('I want to book an appointment')
                                        ->rows(3)
                                        ->columnSpan(2)
                                        ->autosize(),
                                ]),
                            Fieldset::make('Account Information')
                                ->columnSpan(1)
                                ->columns(1)
                                ->schema([
                                    TextInput::make('email')
                                        ->email() // or
                                        ->prefixIcon('heroicon-o-at-symbol')
                                        ->prefixIconColor('primary')
                                        ->label('Email')
                                        ->required(),

                                    TextInput::make('password')
                                        ->password()
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->revealable()
                                        ->required(),

                                    TextInput::make('passwordConfirmation')
                                        ->password()
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->revealable()
                                        ->same('password')
                                        ->required(),
                                ]),



                            ]),



                        ]),


            ]);

    }

//     <!--
//     first_name
//     last_name
//     middle_name
//     address
//     gender
//     civil_status
//     email
//     dob
//     contact_number
//     pass

// -->


    public function render()
    {
        return view('livewire.appointment-account');
    }
}


