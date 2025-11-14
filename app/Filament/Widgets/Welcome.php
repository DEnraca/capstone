<?php

namespace App\Filament\Widgets;

use BezhanSalleh\FilamentShield\Traits\HasWidgetShield;
use Filament\Widgets\Widget;

class Welcome extends Widget
{
    use HasWidgetShield;

    protected int | string | array $columnSpan = '8';

    protected static string $view = 'filament.widgets.welcome';
}
