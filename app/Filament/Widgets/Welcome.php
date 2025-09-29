<?php

namespace App\Filament\Widgets;

use Filament\Widgets\Widget;

class Welcome extends Widget
{
    protected int | string | array $columnSpan = '8';

    protected static string $view = 'filament.widgets.welcome';
}
