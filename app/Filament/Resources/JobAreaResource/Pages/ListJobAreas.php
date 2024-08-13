<?php

namespace App\Filament\Resources\JobAreaResource\Pages;

use App\Filament\Resources\JobAreaResource;
use App\Models\JobArea;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class ListJobAreas extends ListRecords
{
    protected static string $resource = JobAreaResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('Importar')
                ->requiresConfirmation()
                ->icon('heroicon-m-arrow-path')
                ->action(function (array $data) {
                    try {
                        $response = Http::rhcontratapa()->get('wp/v2/candidate_category?page=1&per_page=100')->json();

                        foreach ($response as $job) {
                            DB::table('job_areas')
                                ->updateOrInsert(
                                    ['id' => $job['id']], // Condição para atualização
                                    ['name' => $job['name'], 'slug' => $job['slug'], 'id' => $job['id']] // Valores a serem atualizados ou inseridos
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
                    }
                }),
        ];
    }
}
