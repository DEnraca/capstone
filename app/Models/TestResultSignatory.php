<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\Pivot;
use Illuminate\Database\Eloquent\SoftDeletes;

class TestResultSignatory extends Pivot
{
    protected $table = 'test_result_has_signatories';

    public $timestamps = false;

    protected $fillable = [
        'tests_result_id',
        'emp_id',
    ];

    public function testresult(): BelongsTo
    {
        return $this->belongsTo(TestResult::class, 'tests_result_id');
    }

    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class, 'emp_id');
    }

}
