<?php

namespace App\Filament\Resources\ServiceResource\Pages;

use App\Filament\Resources\ServiceResource;
use App\Models\Service;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\CreateRecord;
use Stripe\Price;
use Stripe\Product;
use Stripe\StripeClient;

use function Sentry\captureException;

class CreateService extends CreateRecord
{
    protected static string $resource = ServiceResource::class;

    protected function afterCreate(): void
    {
        $stripe = new StripeClient(env('STRIPE_SECRET'));

        $service = $this->record;

        try {
            $newServiceOnStripe = $stripe->products->create([
                'name' => $service->name,
                'description' => $service->description,
            ]);

            if ($newServiceOnStripe->id) {
                $newPriceOnStripe = $stripe->prices->create([
                    'unit_amount' => (int)$service->price * 100,
                    'currency' => 'brl',
                    'product' => $newServiceOnStripe->id,
                ]);
            }

            if ($newPriceOnStripe->id) {
                $service->update(['stripe_id' => $newPriceOnStripe->id]);
            }

        } catch (\Exception $e) {
            captureException($e);
            Notification::make()
                ->warning()
                ->title('Erro ao cadastrar o serviço no stripe, clique em sincronizar.')
                // ->body('Choose a plan to continue.')
                ->persistent()
                ->send();
        }
    }

}
