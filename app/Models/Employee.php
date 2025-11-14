<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Spatie\Image\Enums\Fit;


class Employee extends Model implements  HasMedia
{
    use HasFactory;
    use InteractsWithMedia;


    protected $table = 'employees';
    protected $fillable = [
        'emp_id',
        'last_name',
        'first_name',
        'middle_name',
        'gender_id',
        'birthdate',
        'mobile',
        'department_id',
        'position_id',
        'date_hired',
        'employment_type',
        'notes',
        'is_active',
        'user_id'
    ];


    public function registerMediaConversions(?Media $media = null): void
    {
        $this
            ->addMediaConversion('e_signatures')
            ->performOnCollections('e_signatures')
            ->sharpen(10)
            ->nonQueued();
    }



    public function gender(): BelongsTo
    {
        return $this->belongsTo(Gender::class,);
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Department::class,);
    }


    public function employmentType(): BelongsTo
    {
        return $this->belongsTo(EmployementType::class, 'employment_type');
    }

    public function position(): BelongsTo
    {
        return $this->belongsTo(Position::class,);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }


    public function services(): BelongsToMany
    {
        return $this->belongsToMany(Service::class, 'med_tech_has_services', 'med_tech_id', 'service_id');
    }

    public function getFullname()
    {
        return "{$this->first_name} {$this->middle_name} {$this->last_name}";
    }
    //
}
