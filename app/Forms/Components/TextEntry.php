<?php

namespace App\Forms\Components;

use Filament\Forms\Components\Field;

class TextEntry extends Field
{
    protected string $view = 'forms.components.text-entry';

    protected string | \Closure | null $currency = null;

    public function currency(string | \Closure | null $currency)
    {
        $this->currency = $currency;

        return $this;
    }

    public function getCurrency()
    {
        return $this->evaluate($this->currency);
    }
}
