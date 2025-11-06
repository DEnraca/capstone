<?php

namespace App\Exports\Sheets;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;

class InvoicesDiscounts implements FromView, WithTitle, ShouldAutoSize
{
    public $discounts;
    public $data;


    public function __construct($discounts)
    {
        $this->discounts = $discounts['discounts'];
        $this->data = $discounts;
    }
    public function view(): View
    {
        return view('exports.discounts', [
            'discounts' => $this->discounts,
            'type' => 'excel',
            'data' =>  $this->data
        ]);
    }


    public function title(): string
    {
        return 'Discounts';
    }
}
