<?php

namespace App\Livewire\App;

use App\Models\Candidate;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TagsInput;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Notifications\Notification;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Livewire\Component;
use Illuminate\Support\Str;

class Profile extends Component implements HasForms
{
    use InteractsWithForms;

    public ?array $candidateData = [];
    public ?array $userData = [];

    public Candidate $candidate;

    public function mount(): void
    {
        $user = User::find(auth()->user()->id);
        // $candidate = Candidate::find($user->candidate->id);
        // dd($user->candidate);
        $this->candidate = $user->candidate;

        $this->userForm->fill($user->toArray());
        $this->candidateForm->fill($this->candidate->attributestoArray());
    }

    public function userForm(Form $form): Form
    {
        return $form
            ->schema([
                Section::make()
                    ->heading('Dados de usuário')
                    ->schema([
                        TextInput::make('name')
                            ->label('Nome completo')
                            ->required(),
                        TextInput::make('email')
                            ->disabled()
                            ->email()
                            ->translateLabel(),

                    ])->columns(['md' => 2, 'lg' => 2, 'xl' => 2])->columnSpan(['md' => 2, 'lg' => 6, 'xl' => 6]),

                Section::make()
                    ->heading('Foto de perfil')
                    ->schema([
                        FileUpload::make('profile_photo_path')
                            ->label('')
                            ->image()
                            ->disk('public')
                            ->directory('profile')
                            ->imageEditor()
                            ->imageEditorAspectRatios([
                                '16:9',
                                '4:3',
                                '1:1',
                            ])
                    ])->columnSpan(['md' => 1, 'lg' => 2, 'xl' => 2]),

            ])
            ->columns(['md' => 3, 'lg' => 8, 'xl' => 8])
            ->statePath('userData');
    }

    public function candidateForm(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()
                    ->schema([
                        Section::make()
                            ->heading('Perfil')
                            ->schema([
                                TextInput::make('display_name')
                                    ->label('Como gostaria de ser chamado(a)')
                                    ->required(),
                                TextInput::make('job_title')
                                    ->label('Cargo Atual')
                                    ->required(),
                                DatePicker::make('birthdate')
                                    ->label('Data de nascimento')
                                    ->required(),
                                TextInput::make('phone')
                                    ->mask('(99) 99999-9999')
                                    ->placeholder('(99) 99999-9999')
                                    ->translateLabel(),
                                RichEditor::make('bio')
                                    ->hint('Deixe uma mini bio sobre você!')
                                    ->columnSpanFull()
                            ])->columns(2)->columnSpan(6),
                        Section::make()
                            ->heading('Formação acadêmica')
                            ->schema([
                                Select::make('qualification')
                                    ->options([
                                        'fundamental' => 'Ensino Fundamental',
                                        'medio' => 'Ensino Médio',
                                        'Técnico' => 'Técnico',
                                        'superior' => 'Superio/Graduação',
                                        'mestrado' => 'Mestrado',
                                    ])
                                    ->translateLabel(),
                                TagsInput::make('languages')
                                    ->translateLabel()
                                    ->separator(',')
                                    ->placeholder('Novo idioma')
                                    ->suggestions([
                                        'Inglês',
                                        'Português',
                                        'Espanhol',
                                        'Alemão',
                                    ]),
                            ])->columns(2)->columnSpan(6),
                        Section::make()
                            ->heading('Informações de Contato')
                            ->schema([
                                Group::make()
                                    ->relationship('address')
                                    ->schema([
                                        TextInput::make('zipcode')
                                            ->label('CEP')
                                            ->columnSpan(1)
                                            ->live()
                                            ->afterStateUpdated(function (Set $set, $state) {
                                                $address = Http::get('https://viacep.com.br/ws/' . $state . '/json/');

                                                // Verifica se a requisição foi bem-sucedida
                                                if ($address->successful()) {
                                                    // Define os dados de endereço no sistema
                                                    $set('state', $address['uf']);
                                                    $set('city', $address['localidade']);
                                                    $set('address', $address['logradouro']);
                                                    $set('district', $address['bairro']);
                                                } else {
                                                    // Em caso de erro, registra no log
                                                    Log::error('Erro ao obter dados de endereço: ' . $address->status());
                                                }
                                            })
                                            ->required(),
                                        TextInput::make('address')
                                            ->label('Endereço')
                                            ->columnSpan(['md' => 2])
                                            ->required(),
                                        TextInput::make('state')
                                            ->label('Estado/UF')
                                            ->maxLength(2)
                                            ->required(),
                                        TextInput::make('city')
                                            ->label('Cidade')
                                            ->required(),
                                        TextInput::make('district')
                                            ->label('Bairro')
                                            ->required(),
                                    ])->columns(['md' => 3, 'lg' => 3, 'xl' => 3])->columnSpan(['md' => 2, 'lg' => 6, 'xl' => 6]),
                            ])->columnSpan(6),
                    ])->columnSpan(6),

                Group::make()
                    ->schema([
                        Section::make()
                            ->heading('Interesses Profissionais')
                            ->schema([
                                Select::make('jobAreas')
                                    ->label('Áreas de atuação')
                                    ->relationship('jobAreas', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('jobPositionsInterest')
                                    ->label('Cargos de Interesse')
                                    ->relationship('jobPositionsInterest', 'name')
                                    ->multiple()
                                    ->searchable()
                                    ->preload()
                                    ->required(),
                                Select::make('salary_expectation')
                                    ->translateLabel()
                                    ->hintIcon('heroicon-m-question-mark-circle', tooltip: 'Usamos esta informação apenas para selecionar as melhores vagas para você, não será exibido em seu perfil público.')
                                    ->helperText('')
                                    ->options([
                                        'estagio' => 'Bolsa Estágio',
                                        'aprendiz' => 'Aprendiz',
                                        'salario_minimo' => 'Salário Mínimo',
                                        '1500-2500' => 'de R$ 1500,00 a R$ 2500,00',
                                        '2501-4000' => 'de R$ 2501,00 a R$ 4000,00',
                                        '4001-5000' => 'de R$ 4000,00 a R$ 5000,00',
                                        '+5000' => 'acima de R$ 5000,00',
                                    ])
                                    ->translateLabel(),
                            ])->columnSpan(['md' => 3]),

                        Group::make()
                            // ->heading('Redes Sociais')
                            ->schema([
                                Repeater::make('social_media')
                                    ->label('Links')
                                    // ->collapsed()
                                    ->addActionLabel('Adicionar Rede social')
                                    ->schema([
                                        Select::make('rede')
                                            ->label('Plataforma')
                                            ->options([
                                                'instagram' => 'Instagram',
                                                'facebook' => 'Facebook',
                                                'linkedin' => 'LinkedIn',
                                                'youtube' => 'Youtube',
                                                'tiktok' => 'Tiktok',
                                                'twitter' => 'Twitter',
                                            ])
                                            ->required(),
                                        TextInput::make('url')
                                            ->prefix('@')
                                            ->label('Perfil')
                                            ->required(),
                                    ])
                                    ->columns(1)
                            ])->columnSpan(2),
                    ])->columnSpan(2)
            ])
            ->columns(['md' => 3, 'lg' => 8, 'xl' => 8])
            ->statePath('candidateData')
            ->model($this->candidate);
    }

    public function render()
    {
        return view('livewire.app.profile');
    }

    protected function getForms(): array
    {
        return [
            'userForm',
            'candidateForm',
        ];
    }

    public function saveCandidate()
    {
        try {
            $data = $this->candidateForm->getState();

            auth()->user()->candidate->update($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();

        return redirect(route('filament.app.pages.c-v'));

    }

    public function saveUser(): void
    {
        try {
            $data = $this->userForm->getState();
            auth()->user()->update($data);
        } catch (Halt $exception) {
            return;
        }

        Notification::make()
            ->success()
            ->title(__('filament-panels::resources/pages/edit-record.notifications.saved.title'))
            ->send();
    }
}
