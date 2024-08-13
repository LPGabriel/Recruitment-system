<?php

namespace App\Filament\Pages\Auth;

use App\Models\Company;
use Cheesegrits\FilamentPhoneNumbers\Forms\Components\PhoneNumber;
use DanHarrin\LivewireRateLimiting\Exceptions\TooManyRequestsException;
use Filament\Facades\Filament;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Pages\Auth\Register as BaseRegister;
use Filament\Support\RawJs;
use Filament\Http\Responses\Auth\Contracts\RegistrationResponse;
use Filament\Notifications\Notification;
use Illuminate\Auth\Events\Registered;

use function Sentry\captureException;

class Register extends BaseRegister
{
    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Radio::make('type')
                    ->label('Tipo de conta')
                    ->inline()
                    ->live()
                    ->default('candidate')
                    ->required()
                    ->options([
                        'candidate' => 'Candidato(a)',
                        'company' => 'Empresa',
                    ]),
                TextInput::make('name_company')
                    ->label('Razão Social')
                    ->hidden(fn (Get $get) => $get('type') !== 'company')
                    ->required(fn (Get $get) => $get('type') === 'company'),
                TextInput::make('cnpj')
                    ->hidden(fn (Get $get) => $get('type') !== 'company')
                    ->required(fn (Get $get) => $get('type') === 'company')
                    ->mask('99.999.999/9999-99')
                    ->maxLength(14)
                    ->placeholder('00.000.000/0000-00')
                    ->label('CNPJ'),
                $this->getNameFormComponent(),
                TextInput::make('phone')
                ->tel()
                ->label('Telefone/Whatsapp')
                ->required()
                ->maxLength(255),
                $this->getEmailFormComponent(),
                Grid::make([
                    'default' => 1,
                    'sm' => 1,
                    'md' => 2,
                    'lg' => 2,
                    'xl' => 2,
                    '2xl' => 2,
                ])
                    ->schema([
                        $this->getPasswordFormComponent(),
                        $this->getPasswordConfirmationFormComponent(),
                    ])
            ]);
    }

    public function register(): ?RegistrationResponse
    {
        try {
            $this->rateLimit(2);
        } catch (TooManyRequestsException $exception) {
            captureException($exception);
            Notification::make()
                ->title(__('filament-panels::pages/auth/register.notifications.throttled.title', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]))
                ->body(array_key_exists('body', __('filament-panels::pages/auth/register.notifications.throttled') ?: []) ? __('filament-panels::pages/auth/register.notifications.throttled.body', [
                    'seconds' => $exception->secondsUntilAvailable,
                    'minutes' => ceil($exception->secondsUntilAvailable / 60),
                ]) : null)
                ->danger()
                ->send();

            return null;
        }

        $data = $this->form->getState();

        $user_data = [
            'type' => $data['type'],
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => $data['password'],
        ];

        $user = $this->getUserModel()::create($user_data);

        if ($data['type'] == 'company') {
            $company_data = [
                'name' => $data['name_company'],
                'cnpj' => $data['cnpj'],
            ];

            $company = new Company($company_data);

            $user->company()->save($company);

            $user->assignRole('company');
        }

        if ($data['type'] == 'candidate') {
            $user->assignRole('candidate');
        }


        app()->bind(
            \Illuminate\Auth\Listeners\SendEmailVerificationNotification::class,
            \Filament\Listeners\Auth\SendEmailVerificationNotification::class,
        );
        // event(new Registered($user));

        Filament::auth()->login($user);

        session()->regenerate();

        return app(RegistrationResponse::class);
    }
}
