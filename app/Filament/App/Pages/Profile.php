<?php

namespace App\Filament\App\Pages;

use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Contracts\HasForms;
use Filament\Pages\Page;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;

class Profile extends Page implements HasForms
{
    use InteractsWithForms;

    public ?array $data = [];

    protected static ?string $navigationIcon = 'heroicon-o-user';

    protected static ?string $activeNavigationIcon = 'heroicon-s-user';

    protected static string $view = 'filament.app.pages.profile';

    protected static ?string $title = 'Meu perfil';

    protected static ?int $navigationSort = 1;

    public function mount(): void
    {
        $user = User::find(auth()->user()->id);
        abort_unless($user->hasRole('candidate'), 403);
        $this->form->fill(auth()->user()->candidate->attributesToArray());
    }

    public static function shouldRegisterNavigation(): bool
    {
        // dd(auth()->user()->hasRole('candidate'));
        return auth()->user()->hasRole('candidate');
    }

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ])
            ->columns(8)
            ->statePath('data');
    }

    public function save(): void
    {
        try {
            $data = $this->form->getState();

            auth()->user()->candidate->update($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }

    protected function getFormActions(): array
    {
        return [
            Action::make('save')
                ->label(__('filament-panels::resources/pages/edit-record.form.actions.save.label'))
                ->submit('save'),
        ];
    }
}
