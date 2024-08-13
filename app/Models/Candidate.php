<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Candidate extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'job_title',
        'bio',
        'phone',
        'qualification',
        'birthdate',
        'salary_expectation',
    ];

    protected $casts = [
        'languages' => 'array',
        'academic_education' => 'array',
        'professional_experiences' => 'array',
        'professional_experiences' => 'array',
        'courses' => 'array',
        'social_media' => 'array',
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($candidate) {
            if (!is_null(auth()->user())) {
                $candidate->slug = Str::slug(auth()->user()->name . " " . $candidate->id);
            }
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function address(): HasOne
    {
        return $this->hasOne(Address::class);
    }

    public function jobAreas(): BelongsToMany
    {
        return $this->belongsToMany(JobArea::class, 'job_area_candidate')->withTimestamps();
    }

    public function jobPositionsInterest(): BelongsToMany
    {
        return $this->belongsToMany(JobPosition::class, 'job_position_candidate')->withTimestamps();
    }

    public function quiz_results(): HasMany
    {
        return $this->hasMany(QuizResult::class);
    }
}
