<?php

namespace App\Exports;


use App\Models\Masterlist;
use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class AvailmentExport implements FromView
{
    /**
    * @return \Illuminate\Support\Collection
    */

    private $data;

    public function __construct(string $data)
    {
        $this->data = $data;
    }

    public function view(): View
    {
        //
        $data = $this->data;
        $masterlist = Masterlist::where('id', $data)->first();
        $employees = Employee::where('masterlist_id', $masterlist->id)
        ->where('status','4')->get();

        foreach($employees as $employee){

            $collections[] = collect([
                'NAME' => $employee->name,
                'DATE' => $employee->checkin->checkin_date,
                'LAB' => $employee->checkin->lab_no,
                'PE' => $employee->checkin->pe_status,
                'CBC' => $employee->checkin->cbc_status,
                'VA' => $employee->checkin->va_status,
                'UA' => $employee->checkin->ua_status,
                'FE' => $employee->checkin->fe_status,
                'CXR' => $employee->checkin->cxr_status,
                'DRUGTEST' => $employee->checkin->dt_status,
                'ECGCHEM' => $employee->checkin->ecg_chem_status,
                'BREAST' => $employee->checkin->breast_status,
                'DRE' => $employee->checkin->dre_status,
                'GEN' => $employee->checkin->gen_status,
                'PAPS' => $employee->checkin->paps_status,
                'STATUS' => $employee->checkin->status,
                'TESTFORCOMPLETION' => $employee->checkin->tests_for_completion,
            ]);
        }


        return view('exports.availment', [
            'collections' => $collections,
        ]);

    }
}
