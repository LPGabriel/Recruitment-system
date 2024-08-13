<?php

namespace App\Models;

use App\Casts\MoneyCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
class JobListing extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'job_listings';

    protected $fillable = [
        'slug',
        'status',
        'title',
        'content',
        'location',
        'salary',
        'user_id',
        'posting_date',
        'expiration_date',
    ];

    protected $casts = [
        'salary' => MoneyCast::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($joblisting) {
            $joblisting->slug = Str::slug($joblisting->title . " " . $joblisting->location);
        });
    }

    public function jobListingTags(): BelongsToMany
    {
        return $this->belongsToMany(JobListingTag::class);
    }

    public function jobListingCategory(): BelongsTo
    {
        return $this->belongsTo(JobListingCategory::class);
    }

    public function jobListingType(): BelongsTo
    {
        return $this->belongsTo(JobListingType::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jobApplicants(): HasMany
    {
        return $this->hasMany(JobApplicant::class);
    }

}
