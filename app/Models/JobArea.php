<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class JobArea extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($jobArea) {
            $jobArea->slug = Str::slug($jobArea->name);
        });
    }

    public function candidates(): BelongsToMany
    {
        return $this->belongsToMany(Candidate::class, 'job_area_candidate')->withTimestamps();
    }
}
