<?php

namespace App\Filament\App\Pages;

use Filament\Facades\Filament;
use Filament\Pages\Page;
use Filament\Support\Facades\FilamentIcon;
use Illuminate\Contracts\View\View;

class Dashboard extends \Filament\Pages\Dashboard
{

    protected static ?string $title = '';

    protected static ?string $navigationLabel = 'Dashboard';

    public static function getNavigationIcon(): ?string
    {
        return static::$navigationIcon
            ?? FilamentIcon::resolve('panels::pages.dashboard.navigation-item')
            ?? (Filament::hasTopNavigation() ? 'heroicon-m-home' : 'heroicon-o-home');
    }

    // public function getColumns(): int | string | array
    // {
    //     return [
    //         'md' => 1,
    //         'xl' => 1,
    //     ];
    // }


    protected static string $view = 'filament.app.pages.dashboard';

    public function getFooter(): ?View
    {
        return view('filament.app.footer');
    }
}
