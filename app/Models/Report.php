<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{

    protected $table = 'reports';

    protected $fillable = [
        'from',
        'to',
        'type',
        'report_kind_id',
        'range',
        'generated_by'
    ];

    public function reportKind()
    {
        return $this->belongsTo(ReportKind::class, 'report_kind_id');
    }


    public function generatedBy()
    {
        return $this->belongsTo(Employee::class, 'generated_by');
    }



}
