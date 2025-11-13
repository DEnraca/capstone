<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;
class TestResult extends Model implements  HasMedia
{

    use InteractsWithMedia;

    protected $table = 'test_results';

    protected $fillable = [
        'patient_tests_id',
        'result_id',
        'impressions',
        'status_id'
    ];


    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('result_attachments')
            ->performOnCollections('result_attachments')
            ->sharpen(10)
            ->nonQueued();
    }


    public function result(): BelongsTo
    {
        return $this->belongsTo(Result::class, 'result_id');
    }

    public function test(): BelongsTo
    {
        return $this->belongsTo(PatientTest::class, 'patient_tests_id');
    }

    public function signatories()
    {
        return $this->belongsToMany(Employee::class, 'test_result_has_signatories', 'tests_result_id', 'emp_id')
            ->using(TestResultSignatory::class);

    }

}
