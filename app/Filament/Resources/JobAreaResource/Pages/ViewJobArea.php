<?php

namespace App\Filament\Resources\JobAreaResource\Pages;

use App\Filament\Resources\JobAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\ViewRecord;

class ViewJobArea extends ViewRecord
{
    protected static string $resource = JobAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\EditAction::make(),
        ];
    }
}
