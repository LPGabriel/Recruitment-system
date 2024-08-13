<?php

namespace App\Filament\Resources\JobListingCategoryResource\Pages;

use App\Filament\Resources\JobListingCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobListingCategory extends EditRecord
{
    protected static string $resource = JobListingCategoryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
