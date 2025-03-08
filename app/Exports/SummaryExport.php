<?php

namespace App\Exports;


use App\Models\Masterlist;
use App\Models\Employee;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SummaryExport implements FromView
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
                $interpretedResult = ($employee->bloodchem) ? $this->getBloodChemResult($employee->bloodchem->toArray(), $employee) : [];

                $collections[] = collect([
                    'name' => $employee->name,
                    'age' => $employee->age,
                    'gender' => $employee->gender,
                    'ape' => $employee->ape,
                    'blood' =>  $interpretedResult,
                    'serology' => $employee->serology,
                    'ecg' => $employee->ecgs,
                    'papsmear' => $employee->papsmears,
                    'accesscode' =>$employee->access_code,

                ]);

            }


        return view('exports.summary', [
            'collections' => $collections,
        ]);

    }


    public function getBloodChemResult($array, $employee){
        $range = [
            [
                'key' => 'fasting_blood_sugar',
                'name' => 'FBS',
                'max' => 6.12,
                'min' => 0.34,
                'max_result' => 'High',
                'min_result' => 'Low',
                'has_diff_gender_res' => False,
                'pass' => 'Normal'
            ],
            [
                'key' => 'random_blood_sugar',
                'name' => 'RBS',
                'max' => 10.0,
                'min' => 7.0,
                'max_result' => 'High',
                'min_result' => 'Low',
                'has_diff_gender_res' => False,
                'pass' => 'Normal'
            ],
            [
                'key' => 'creatinine',
                'name' => 'CREA',
                'max' => 106.08,
                'min' => 62,
                'max_result' => 'High',
                'min_result' => 'Low',
                // has different gender result add value if has? add seperate value for female but the max min is default for male
                'has_diff_gender_res' => True,
                'fem_max_val' => 106.08,
                'fem_min_val' =>  44.2,
                //end
                'pass' => 'Normal'
            ],
            [
                'key' => 'blood_uric_acid',
                'name' => 'BUA',
                'max' => 416.5,
                'min' => 202.3,
                'max_result' => 'High',
                'min_result' => 'Low',
                'has_diff_gender_res' => True,
                'fem_max_val' => 339,
                'fem_min_val' => 142,
                'pass' => 'Normal'
            ],
            [
                'key' => 'cholesterol',
                'name' => 'CHOLE',
                'max' => 5.17,
                'min' => 3.1,
                'max_result' => 'High',
                'min_result' => 'Low',
                'has_diff_gender_res' => False,
                'pass' => 'Normal'
            ],
            [
                'key' => 'potassium',
                'name' => 'POTASSIUM',
                'max' => 5.3,
                'min' => 3.5,
                'max_result' => 'High',
                'min_result' => 'Low',
                'has_diff_gender_res' => False,
                'pass' => 'Normal'
            ],
            // [
            //     'key' => 'blood_urea_nitrogen',
            //     'name' => 'BUN',
            //     'max' => 8.3,
            //     'min' => 1.7,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'triglycerides',
            //     'name' => 'TAG',
            //     'max' => 1.88,
            //     'min' => 0.41,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'hdl',
            //     'name' => 'HDL',
            //     'max' => 2.06,
            //     'min' => 0.93,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => True,
            //     'fem_max_val' => 2.28,
            //     'fem_min_val' => 1.09,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'ldl',
            //     'name' => 'LDL',
            //     'max' => 3.9,
            //     'min' => 0,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'vldl',
            //     'name' => 'VLDL',
            //     'max' => 1.04,
            //     'min' => 0,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'sgot',
            //     'name' => 'SGOT',
            //     'max' => 38,
            //     'min' => 0,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => True,
            //     'fem_max_val' => 31,
            //     'fem_min_val' => 0,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'sgpt',
            //     'name' => 'SGPT',
            //     'max' => 40,
            //     'min' => 0,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => True,
            //     'fem_max_val' => 31,
            //     'fem_min_val' => 0,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'sodium',
            //     'name' => 'SODIUM',
            //     'max' => 145,
            //     'min' => 135,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'chloride',
            //     'name' => 'CHLORIDE',
            //     'max' => 109,
            //     'min' => 96,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'total_calcium',
            //     'name' => 'Total Calcium',
            //     'max' => 10.6,
            //     'min' => 8.4,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'alkaline_phosphatase',
            //     'name' => 'ALP',
            //     'max' => 279,
            //     'min' => 98,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'total_bilirubin',
            //     'name' => 'TBIL',
            //     'max' => 20.50,
            //     'min' => 3.40,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'direct_bilirubin',
            //     'name' => 'DBIL',
            //     'max' => 5.1,
            //     'min' => 0,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'indirect_bilirubin',
            //     'name' => 'IBIL',
            //     'max' => 5.1,
            //     'min' => 0,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'albumin',
            //     'name' => 'ALB',
            //     'max' => 5.1,
            //     'min' => 0,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'globulin',
            //     'name' => 'GLB',
            //     'max' => 38,
            //     'min' => 28,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
            // [
            //     'key' => 'hba1c',
            //     'name' => 'HBA1C',
            //     'max' => 6.5,
            //     'min' => 4.5,
            //     'max_result' => 'High',
            //     'min_result' => 'Low',
            //     'has_diff_gender_res' => False,
            //     'pass' => 'Normal'
            // ],
        ];

        $overall_result = array();


        if(is_array($array)){

            foreach($range as $key => $item){
                $for_test = isset($array[$item['key']]) ? $array[$item['key']] : null;
                if($for_test){
                    // $for_test = 100;
                    // $employee->gender = 'female';
                    $max = $item['max'];
                    $min = $item['min'];
                    if($item['has_diff_gender_res']){
                        if(strtolower($employee->gender) == 'female' || strtolower($employee->gender) == 'f'){
                            $max = $item['fem_max_val'];
                            $min = $item['fem_min_val'];
                        }
                    }
                    if( $for_test >= $max){
                        $result = $item['max_result'];
                    }
                    else if($for_test <= $min){
                        $result = $item['min_result'];
                    }
                    else{
                        $result = $item['pass'];
                    }
                    $overall_result[$item['name']] = $result;
                }

            }
        }
        return $overall_result;
    }
}
