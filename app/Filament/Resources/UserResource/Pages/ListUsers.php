<?php

namespace App\Filament\Resources\UserResource\Pages;

use App\Filament\Resources\UserResource;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

use function Sentry\captureException;

class ListUsers extends ListRecords
{
    protected static string $resource = UserResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Importar/Sincronizar')
            ->requiresConfirmation()
            ->icon('heroicon-m-arrow-path')
            ->action(function (array $data) {
                try {
                    $response = Http::rhcontratapa()->get('wp/v2/users')->json();

                    foreach ($response as $user) {
                        DB::table('users')
                            ->updateOrInsert(
                                ['id' => $user['id']], // Condição para atualização
                                ['id' => $user['id'], 'name' => $user['name'], 'email' => $user['email']] // Valores a serem atualizados ou inseridos
                            );
                    }

                    Notification::make()
                        ->title(count($response) . ' registros importados e/ou atualizados com sucesso!')
                        ->success()
                        ->send();
                } catch (\Exception $e) {
                    Notification::make()
                        ->title("Opa. Erro ao importar, consulte o suporte.")
                        ->color('danger')
                        ->danger()
                        ->send();
                    captureException($e);

                }
            }),
        ];
    }
}
