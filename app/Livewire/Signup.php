<?php

namespace App\Livewire;

use Filament\Forms\Components\Grid;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Section;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Livewire\Component;
use Filament\Forms\Components\Wizard;

class Signup extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function form(Form $form): Form
    {
        return $form

            ->schema([
                Section::make('')
                    // ->description('Prevent abuse by limiting the number of requests per period')
                    ->schema([
                        TextInput::make('email')
                            ->label('Email')
                            ->email()
                            ->required(),
                        TextInput::make('name')
                            ->label('Nome completo')
                            ->required(),
                        TextInput::make('password')
                            ->label('Senha')
                            ->password()
                            ->required()
                    ])
            ])
            ->statePath('data');
    }

    public function create(): void
    {
        dd($this->form->getState());
    }

    public function render()
    {
        return view('livewire.signup');
    }
}
