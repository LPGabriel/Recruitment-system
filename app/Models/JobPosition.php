<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;
class JobPosition extends Model
{
    use HasFactory;

    protected static function boot()
    {
        parent::boot();

        static::saving(function ($jobPosition) {
            $jobPosition->slug = Str::slug($jobPosition->name);
        });
    }

    public function candidates(): BelongsToMany
    {
        return $this->belongsToMany(Candidate::class, 'job_position_candidate')->withTimestamps();
    }
}
