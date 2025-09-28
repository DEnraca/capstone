<?php

namespace App\Livewire;

use App\Models\CivilStatus;
use App\Models\Gender;
use App\Models\User;
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
use Illuminate\Support\Facades\Session;
use Illuminate\Support\HtmlString;
use Livewire\Component;

class AppointmentAccount extends Component implements HasForms
{
    use InteractsWithForms;

    public $data;

    public $showModal = true;

    public function mount(): void
    {
        $app_form = session('appointment_form', []);
        // $this->form->fill([$app_form]);
        $this->form->fill();

    }

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
                                ->statePath('info')
                                ->schema([
                                    TextInput::make('last_name')
                                        ->prefixIcon('heroicon-o-user')
                                        ->prefixIconColor('primary')
                                        ->helperText('Kindly include suffix after last name, e.g. II, III')
                                        ->label('Last Name')
                                        ->default('Enraca')
                                        ->required(),

                                    TextInput::make('first_name')
                                        ->prefixIcon('heroicon-o-user')
                                        ->prefixIconColor('primary')
                                        ->label('First Name')
                                        ->default('Dennis')
                                        ->required(),

                                    TextInput::make('middle_name')
                                        ->prefixIcon('heroicon-o-user')
                                        ->prefixIconColor('primary')
                                        ->default('Abellera')
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
                                        ->default('9171234567')
                                        ->required(),

                                    DatePicker::make('dob')
                                        ->required()
                                        ->prefixIcon('heroicon-o-calendar-days')
                                        ->prefixIconColor('primary')
                                        ->maxDate(now()->subYear())
                                        ->closeOnDateSelection()
                                        ->default('1999-25-01')
                                        ->label('Birthdate'),

                                    Select::make('gender')
                                        ->label('Gender')
                                        ->options( fn () => Gender::all()->pluck('name','id')->toArray() )
                                        ->default(1)
                                        ->required(),

                                    Select::make('civil_status')
                                        ->label('Civil Status')
                                        ->options( fn () => CivilStatus::all()->pluck('name','id')->toArray() )
                                        ->default(1)
                                        ->required(),

                                ]),

                                Fieldset::make('Address')
                                    ->columns(2)
                                    ->statePath('address')
                                    ->schema([
                                        Select::make('region_id')
                                            ->label('Region')
                                            ->options( fn (): array => getRegionsCustom())
                                            ->live()
                                            ->optionsLimit(75)
                                            ->afterStateUpdated(function (callable $set) {
                                                $set('province_id', null);
                                                $set('city_id', null);
                                                $set('barangay_id', null);
                                            })
                                            ->default('03')
                                            ->required(),

                                        Select::make('province_id')
                                            ->label('Province')
                                            ->options( fn (callable $get): array => getProvincesCustom($get('region_id')) )
                                            ->disabled(fn (callable $get) => !$get('region_id'))
                                            ->afterStateUpdated(function (callable $set) {
                                                $set('city_id', null);
                                                $set('barangay_id', null);
                                            })
                                            ->searchable()
                                            ->live()
                                            ->optionsLimit(75)
                                            ->default('03014')
                                            ->required(),

                                        Select::make('city_id')
                                            ->label('Municipality/City')
                                            ->options( fn (callable $get): array => getCitiesCustom($get('province_id')) )
                                            ->disabled(fn (callable $get) => !$get('province_id'))
                                            ->searchable()
                                            ->afterStateUpdated(function (callable $set) {
                                                $set('barangay_id', null);
                                            })
                                            ->live()
                                            ->optionsLimit(75)
                                            ->default('0301404')
                                            ->required(),

                                        Select::make('barangay_id')
                                            ->label('Barangay')
                                            ->options( fn (callable $get): array => getBarangayCustom($get('city_id')) )
                                            ->disabled(fn (callable $get) => !$get('city_id'))
                                            ->searchable()
                                            ->live()
                                            ->default('8773')
                                            ->optionsLimit(75)
                                            ->required(),

                                        TextInput::make('house_address')
                                            ->columnSpanFull()
                                            ->default('1547 Banlok St. Farmers Subd.')
                                            ->helperText('House no., Street, Subdivision, Village')
                                            ->label('House Address')
                                            ->required(),
                                    ]),
                    ]),
                    Grid::make(1)
                        ->columnSpan(1)
                        ->schema([
                            Fieldset::make('Book schedule')
                                ->statePath('book')
                                ->schema([
                                    DatePicker::make('appointment_date')
                                        ->required()
                                        ->native(false)
                                        ->prefixIcon('heroicon-o-calendar-days')
                                        ->prefixIconColor('primary')
                                        ->default('2025-09-27')
                                        ->closeOnDateSelection()
                                        ->label('Date'),

                                    Select::make('appointment_time')
                                        ->label('Time')
                                        ->default('9:30')
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
                                ->statePath('account')
                                ->columns(1)
                                ->schema([
                                    TextInput::make('email')
                                        ->email() // or
                                        ->prefixIcon('heroicon-o-at-symbol')
                                        ->prefixIconColor('primary')
                                        ->label('Email')
                                        // ->unique(table: User::class, column: 'email')
                                        ->default('dennisenraca25@gmail.com')
                                        ->required(),

                                    TextInput::make('password')
                                        ->password()
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->revealable()
                                        ->default('admin123')
                                        ->required(),

                                    TextInput::make('passwordConfirmation')
                                        ->password()
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->revealable()
                                        ->same('password')
                                        ->default('admin123')
                                        ->required(),
                                ]),
                            ]),
                        ]),
            ]);

    }

    public function submit()
    {
        // This will trigger validation based on your form schema
        $data = $this->form->getState();
        // Instead of saving to the database, put it in the session
        Session::put('appointment_form', $data);

        $this->dispatch('changePage','appointment-details');

    }


    public function render()
    {
        return view('livewire.appointment-account');
    }
}


