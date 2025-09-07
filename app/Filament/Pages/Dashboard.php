<?php

namespace App\Filament\Pages;

class Dashboard extends \Filament\Pages\Dashboard
{

    protected int | string | array $columnSpan = 'full';


    public function getColumns(): int | string | array
    {
        return [
            'md' => 12,
            'xl' => 12,
            'sm' => 12,
        ];
    }

    // ...
}