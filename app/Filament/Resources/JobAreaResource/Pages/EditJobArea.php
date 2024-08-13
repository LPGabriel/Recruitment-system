<?php

namespace App\Filament\Resources\JobAreaResource\Pages;

use App\Filament\Resources\JobAreaResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditJobArea extends EditRecord
{
    protected static string $resource = JobAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\ViewAction::make(),
            Actions\DeleteAction::make(),
        ];
    }
}
