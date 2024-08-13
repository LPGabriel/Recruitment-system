<?php

namespace App\Livewire\Lp;

use App\Models\Event;
use App\Models\EventRegistration;
use Exception;
use Filament\Actions\Concerns\InteractsWithActions;
use Filament\Actions\Contracts\HasActions;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Filament\Notifications\Notification;
use Filament\Support\Colors\Color;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Filament\Support\Enums\ActionSize;
use App\Actions\ResetStars;
use App\Actions\Star;
use Filament\Infolists\Components\Actions;
use Filament\Infolists\Components\Actions\Action;

use function Sentry\captureException;

class InscricaoFeira extends Component implements HasForms, HasInfolists, HasActions
{
    use InteractsWithInfolists;
    use InteractsWithForms;
    use InteractsWithActions;

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill();
    }

    public function ProfileAction(): Action
    {
        return Action::make('profile')
            ->color('info')
            ->size(ActionSize::Large)
            ->outlined()
            ->icon('heroicon-m-user')
            ->url(route('filament.app.pages.dashboard'), shouldOpenInNewTab: true);
    }

    public function registrationInfolist(Infolist $infolist): Infolist
    {
        $user = Auth::user();

        $registration = $user->registrations->where('id', 1)->first();

        return $infolist
            ->record($registration)
            ->state([
                'title' => 'Agora é hora de destacar ainda mais o seu perfil e aumentar suas chances de sucesso.',
                'content' => 'Para aprimorar sua participação, recomendamos que você acesse sua página de perfil para adicionar mais detalhes e o seu currículo.',
                'content2' => 'Agradecemos por se juntar a nós e desejamos a você uma experiência incrível na Feira de Empregabilidade!',
            ])

            ->schema([
                Section::make('Tudo certo ' . explode(" ", $user->name)[0] . '!')
                    ->description('Sua inscrição foi confirmada com sucesso.')
                    ->icon('heroicon-m-ticket')
                    ->iconcolor(Color::Green)
                    ->schema([
                        TextEntry::make('content2')
                            ->label(''),
                        TextEntry::make('title')
                            ->label(''),
                        TextEntry::make('content')
                            ->label(''),
                            Actions::make([
                                Action::make('star')
                                    ->label('Completar currículo')
                                    ->outlined()
                                    ->color(Color::Cyan)
                                    ->url(env('APP_VAGAS_URL') . '/app/profile')
                                    // ->url(env('APP_VAGAS_URL'), shouldOpenInNewTab: true)
                                    // ->url(env('APP_VAGAS_URL'), shouldOpenInNewTab: true)
                                    ->icon('heroicon-m-user'),
                                Action::make('resetStars')
                                    ->label('Realizar teste de perfil')
                                    ->icon('heroicon-m-clipboard-document-check')
                                    ->url(env('APP_GESTOR_URL'))
                                    ->color(Color::Green)
                                    ->outlined()
                            ])->fullWidth(),
                    ])
            ]);
    }

    // <h2>Inscrição Confirmada!</h2>
    //     <p>a
    //         Parabéns! Sua inscrição para a Feira de Empregabilidade foi confirmada com sucesso.
    //         Agora é hora de destacar ainda mais o seu perfil e aumentar suas chances de sucesso.
    //     </p>
    //     <p>
    //         Para aprimorar sua participação, recomendamos que você faça o <a href="#">teste de
    //             perfil</a>
    //         ou acesse sua <a href="#">página de perfil</a> para adicionar mais detalhes e o
    //         seu currículo.
    //     </p>
    //     <p>
    //         Agradecemos por se juntar a nós e desejamos a você uma experiência incrível na Feira de Empregabilidade!
    //     </p>

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->translateLabel()
                    // ->disabled(is_null(auth()->user()))
                    ->default(
                        function () {
                            if (Auth::check()) {
                                return auth()->user()->name;
                            }
                        }
                    )
                    ->required(),
                TextInput::make('email')
                    ->translateLabel()
                    ->email()
                    // ->disabled(is_null(auth()->user()))
                    ->default(
                        function () {
                            if (Auth::check()) {
                                return auth()->user()->email;
                            }
                        }
                    )
                    ->required(),
                Radio::make('area_interesse')
                    ->required()
                    // ->disabled(is_null(auth()->user()))
                    ->label('Considerando os seguintes papeis, em qual você se encaixa?')
                    // ->inline()
                    ->options([
                        'saude' => 'Saúde',
                        'tecnologia' => 'Tecnologia',
                        'comercial/vendas' => 'Comercial e vendas',
                        'administrativo' => 'Administrativo',
                        'servicos_gerais' => 'Serviços Gerais',
                        'atendimento' => 'Atendimento',
                        'contabilidade/finanças' => 'Contabilidade e Finanças',
                        'educacao' => 'Educação',
                        'industria' => 'Industria',
                        'tecnico' => 'Técnico',
                        'rh/dp' => 'RH e DP',
                        'outros' => 'Outros',
                    ])->columns(2)
            ])
            ->statePath('data');
    }

    public function create()
    {
        $data = $this->form->getState();

        $event = Event::first();
        $user = auth()->user();

        try {
            EventRegistration::create([
                'user_id' => $user->id,
                'event_id' => $event->id,
                'name' => $user->name,
                'email' => $user->email,
                'area_interesse' => $data['area_interesse'],
            ]);
        } catch (Exception $e) {
            captureException($e);
        }
    }

    // public function login()
    // {
    //     return redirect(route('filament.app.auth.login'));
    // }

    public function render()
    {
        if (auth()->user()) {
            $user = auth()->user();
            $registration = $user->registrations->first();
        }


        return view('livewire.lp.inscricao-feira', [
            'registration' => $registration ?? null
        ]);
    }
}
