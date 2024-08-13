<?php

namespace App\Filament\Resources\AppClientResource\Pages;

use App\Filament\Resources\AppClientResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;

class ManageApps extends ManageRecords
{
    protected static string $resource = AppClientResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make()
            ->using(function (array $data, string $model): Model {

                return $model::create($data);
            }),
        ];
    }
}
