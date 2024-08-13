<?php

namespace App\Filament\App\Widgets;

use Filament\Widgets\Widget;
use App\Models\App;
use Filament\Widgets\StatsOverviewWidget\Stat;

class ProductsOverview extends Widget
{
    protected static string $view = 'filament.app.widgets.products-overview';

    // protected int | string | array $columnSpan = '1';

    // protected int | string | array $columnSpan = [
    //     'md' => 2,
    //     'xl' => 3,
    // ];

    // protected function getStats(): array
    // {
    //     return [
    //         Stat::make('Unique views', '192.1k'),
    //         Stat::make('Bounce rate', '21%'),
    //         Stat::make('Average time on page', '3:12'),
    //     ];
    // }

}
