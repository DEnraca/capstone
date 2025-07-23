<?php

namespace App\Livewire;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;

class CreateApointment extends Component implements HasForms
{
    use InteractsWithForms;

    public function mount(): void
    {
        $this->form->fill();
    }



    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make(2)
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
                                    ->placeholder('Select Time')
                                    ->prefixIcon('heroicon-o-clock')
                                    ->prefixIconColor('primary')
                                    ->required()
                                    ->disableOptionWhen(fn (string $value): bool => ($value) === '08:30')
                                    ->options(fn () => get_appointment_timeslots())
                                    ->searchable(),

                            ])->columnSpan(1),

                            TextInput::make('name')
                                ->prefixIcon('heroicon-o-identification')
                                ->prefixIconColor('primary')
                                ->label('Full Name')
                                ->placeholder('Juan Dela Cruz II')
                                ->required(),
                    ])->columnSpanFull(),

                TextInput::make('name')
                    ->prefixIcon('heroicon-o-identification')
                    ->prefixIconColor('primary')
                    ->label('Full Name')
                    ->columnSpanFull()
                    ->placeholder('Juan Dela Cruz II')
                    ->required(),


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
                    ->minLength(11)
                    ->maxLength(11)
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
            ])
            ->columns(2)
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.create-apointment');
    }


}
