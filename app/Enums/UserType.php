<?php

namespace App\Enums;

use Filament\Support\Colors\Color;
use Filament\Support\Contracts\HasLabel;
use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasIcon;


enum UserType: string implements HasIcon, HasColor, HasLabel
{
    case Company = 'company';
    case Candidate = 'candidate';
    case Internal = 'internal';
    case Undefined = 'undefined';

    public function getIcon(): ?string
    {
        return match ($this) {
            self::Company => 'heroicon-m-building-office',
            self::Candidate => 'heroicon-m-user',
            self::Internal => 'heroicon-m-shield-check',
            self::Undefined => 'heroicon-m-exclamation-triangle',
        };
    }

    public function getLabel(): ?string
    {
        return match ($this) {
            self::Company => 'Empresa',
            self::Candidate => 'Pessoa Física',
            self::Internal => 'Usuário Interno',
            self::Undefined => 'Tipo não definido',
        };
    }

    public function getColor(): string | array | null
    {
        return match ($this) {
            self::Company => Color::Blue,
            self::Candidate => Color::Pink,
            self::Internal => Color::Yellow,
            self::Undefined => Color::Red,
        };
    }
}
