<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReportKind extends Model
{
    protected $table = 'report_kind';

    public $timestamps = false;

    protected $fillable = [
        'name',
    ];
    //
}
