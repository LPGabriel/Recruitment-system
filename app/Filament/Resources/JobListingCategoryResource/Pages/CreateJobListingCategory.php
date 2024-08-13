<?php

namespace App\Filament\Resources\JobListingCategoryResource\Pages;

use App\Filament\Resources\JobListingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateJobListingCategory extends CreateRecord
{
    protected static string $resource = JobListingCategoryResource::class;
}
