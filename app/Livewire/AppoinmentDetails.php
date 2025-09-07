<?php

namespace App\Livewire;

use Livewire\Component;

use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;


class AppoinmentDetails extends Component implements HasForms
{
    use InteractsWithForms;


    public function form(Form $form): Form
    {
        return $form
            ->schema([

            ]);
    }
    public function render()
    {
        return view('livewire.appoinment-details');
    }
}
