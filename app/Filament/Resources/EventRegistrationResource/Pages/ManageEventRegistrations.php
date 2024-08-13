<?php

namespace App\Filament\Resources\EventRegistrationResource\Pages;

use App\Filament\Resources\EventRegistrationResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEventRegistrations extends ManageRecords
{
    protected static string $resource = EventRegistrationResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
