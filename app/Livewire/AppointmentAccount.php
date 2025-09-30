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
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Filament\Notifications\Notification;

class AppointmentAccount extends Component implements HasForms
{
    use InteractsWithForms;

    public string $email = '';
    public string $password = '';

    public $data;

    public $showModal = true;

    public function mount(): void
    {
        $app_form = session('appointment_form', []);
        if(auth()->check()){
            $this->form->fill($this->automateForm(Auth::user()));
        }else{
            $this->form->fill([]);
        }

    }

    public function login()
    {
        $this->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (! Auth::attempt([
            'email' => $this->email,
            'password' => $this->password,
        ], true)) {
            throw ValidationException::withMessages([
                'email' => __('filament-panels::pages/auth/login.messages.failed'),
            ]);
        }

        // session()->regenerate();

        // optional: close modal after login
        $this->dispatch('close-modal', id: 'appoinment-login-modal');

        Notification::make()
            ->success()
            ->title('Authenticated')
            ->send();

        return $this->form->fill($this->automateForm(Auth::user()));
        // // redirect to panel's home/dashboard
        // return redirect()->intended(filament()->getUrl());
    }


    public function automateForm($user){
    // dd($user);
        $info = $user->patient;
        $address = $info->address;
        $preFilled = [
            'info' => $info->toArray(),
            'address' => $address->toArray(),
            'account' => [
                'email' => $user->email,
            ]
        ];
        return $preFilled;
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
                                ->disabled(fn () => auth()->check())
                                ->statePath('info')
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
                                        ->options( fn () => CivilStatus::all()->pluck('name','id')->toArray() )
                                        ->required(),

                                ]),

                                Fieldset::make('Address')
                                    ->columns(2)
                                    ->statePath('address')
                                    ->disabled(fn () => auth()->check())
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
                                            ->required(),

                                        Select::make('barangay_id')
                                            ->label('Barangay')
                                            ->options( fn (callable $get): array => getBarangayCustom($get('city_id')) )
                                            ->disabled(fn (callable $get) => !$get('city_id'))
                                            ->searchable()
                                            ->live()
                                            ->optionsLimit(75)
                                            ->required(),

                                        TextInput::make('house_address')
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
                                ->statePath('book')
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
                                ->disabled(fn () => auth()->check())
                                ->columns(1)
                                ->schema([
                                    TextInput::make('email')
                                        ->email() // or
                                        ->prefixIcon('heroicon-o-at-symbol')
                                        ->prefixIconColor('primary')
                                        ->label('Email')
                                        ->unique(table: User::class, column: 'email', ignorable: fn () => Auth::user() )
                                        ->required(),

                                    TextInput::make('password')
                                        ->password()
                                        ->hidden(fn () => auth()->check())
                                        ->dehydrateStateUsing(fn (string $state): string => Hash::make($state))
                                        ->dehydrated(fn (?string $state): bool => filled($state))
                                        ->revealable()
                                        ->required(),

                                    TextInput::make('passwordConfirmation')
                                        ->password()
                                        ->hidden(fn () => auth()->check())
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

    public function submit()
    {
        // This will trigger validation based on your form schema
        $data = $this->form->getState();
        // Instead of saving to the database, put it in the session
        if(auth()->check()){
            $preFilled = $this->automateForm(auth()->user());
            $preFilled['book'] = $data['book'];
            $data= $preFilled;
        }
        Session::put('appointment_form', $data);

        $this->dispatch('changePage','appointment-details');

    }


    public function render()
    {
        return view('livewire.appointment-account');
    }
}


