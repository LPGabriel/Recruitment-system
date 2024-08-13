<?php

namespace App\Filament\Resources\JobListingCategoryResource\Pages;

use App\Filament\Resources\JobListingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListJobListingCategories extends ListRecords
{
    protected static string $resource = JobListingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
