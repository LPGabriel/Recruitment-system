<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class JobApplicant extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'slug',
        'status',
        'title',
        'message',
        'job_listing_id',
        'profile_photo_path',
        'user_id'
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($job_applicant) {
            $job_applicant->slug = Str::slug($job_applicant->title . " " . $job_applicant->id);
            $job_applicant->title = auth()->user()->name;
        });
    }

    public function candidate(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function jobListing(): BelongsTo
    {
        return $this->belongsTo(JobListing::class);
    }
}
