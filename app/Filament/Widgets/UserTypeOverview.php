<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class UserTypeOverview extends BaseWidget
{
    protected function getStats(): array
    {
        return [
            Stat::make('Empresas', User::query()->where('type', 'company')->count()),
            Stat::make('Candidatos', User::query()->where('type', ['candidate'])->count()),
            Stat::make('Internos', User::query()->where('type', 'internal')->count()),
            Stat::make('Não definidos', User::query()->where('type', 'undefined')->count()),
        ];
    }
}
