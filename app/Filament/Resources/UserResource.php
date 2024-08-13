<?php

namespace App\Filament\Resources;

use App\Enums\UserType;
use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Fieldset;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Facades\Auth;
use Tapp\FilamentAuthenticationLog\RelationManagers\AuthenticationLogsRelationManager;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-group';

    protected static ?string $pluralModelLabel = 'usuários';

    protected static ?string $modelLabel = 'usuário';

    protected static ?string $navigationLabel = 'Usuários';

    // protected static ?string $navigationGroup = 'Administração';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Grid::make([
                    'sm' => 2,
                    'xl' => 6,
                    '2xl' => 10,
                ])
                    ->schema([
                        Grid::make()
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 3,
                                '2xl' => 7,
                            ])->schema([
                                Section::make('Dados pessoais')
                                    ->schema([
                                        Forms\Components\TextInput::make('name')
                                            ->translateLabel()
                                            ->required()
                                            ->maxLength(255),
                                        Select::make('roles')
                                            ->multiple()
                                            ->relationship('roles', 'name')
                                            ->preload()
                                            ->translateLabel(),
                                        Forms\Components\TextInput::make('email')
                                            ->translateLabel()
                                            ->email()
                                            ->required()
                                            ->maxLength(255),
                                        Forms\Components\DateTimePicker::make('email_verified_at')
                                            ->disabled()
                                            ->translateLabel(),
                                        Forms\Components\Select::make('type')
                                            ->disabled()
                                            ->translateLabel()
                                            ->options([
                                                'company' => 'Empresa',
                                                'candidate' => 'Pessoa Física',
                                                'internal' => 'Usuário Interno',
                                            ])
                                            ->required(),
                                        Forms\Components\TextInput::make('birth_date')
                                            ->translateLabel()
                                            ->maxLength(255),
                                        Forms\Components\TextInput::make('cpf')
                                            ->label('CPF')
                                            ->mask('999.999.999-99')
                                            ->maxLength(14),
                                        Forms\Components\TextInput::make('rg')
                                            ->label('RG')
                                            ->maxLength(12),
                                    ])->columns(3),
                                // Section::make('Endereço')
                                // ->schema([
                                // Fieldset::make('Endereço')
                                //     ->relationship('address')
                                //     ->schema([
                                //         TextInput::make('cep')
                                //             ->label('CEP')
                                //             ->columnSpan(2)
                                //             ->mask('99999-999')
                                //             ->maxLength(9)
                                //             ->translateLabel(),
                                //         TextInput::make('address')
                                //             ->columnSpan(4)
                                //             ->translateLabel(),
                                //         TextInput::make('complement')
                                //             ->columnSpan(2)
                                //             ->translateLabel(),
                                //         TextInput::make('number')
                                //             ->columnSpan(1)
                                //             ->translateLabel(),
                                //         TextInput::make('district')
                                //             ->columnSpan(2)
                                //             ->translateLabel(),
                                //         TextInput::make('city')
                                //             ->columnSpan(2)
                                //             ->translateLabel(),
                                //         TextInput::make('state')
                                //             ->columnSpan(2)
                                //             ->translateLabel(),
                                //     ])->columns(6)
                                // ])

                            ]),
                        Section::make('Stripe')
                            ->columns([
                                'sm' => 1,
                                'xl' => 1,
                                '2xl' => 1,
                            ])
                            ->columnSpan([
                                'sm' => 2,
                                'xl' => 2,
                                '2xl' => 3,
                            ])
                            ->schema([
                                Forms\Components\TextInput::make('stripe_id')
                                    ->translateLabel()
                                    ->disabled()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('pm_type')
                                    ->translateLabel()
                                    ->disabled()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('pm_last_four')
                                    ->translateLabel()
                                    ->disabled()
                                    ->maxLength(4),
                                Forms\Components\DateTimePicker::make('trial_ends_at')
                                    ->disabled()
                                    ->translateLabel(),
                            ]),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->icon('heroicon-m-envelope')
                    ->searchable(),
                // Tables\Columns\TextColumn::make('email_verified_at')
                //     ->translateLabel()
                //     ->dateTime()
                //     ->dateTime('d/m/Y h:m')
                //     ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->translateLabel()
                    ->since()
                    ->dateTime('d/m/Y h:m')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->translateLabel()
                    ->dateTime('d/m/Y h:m')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('type')
                    ->sortable()
                    ->translateLabel()
                    ->badge(UserType::class)
                    ->searchable(),
            ])
            ->filters([
                SelectFilter::make('type')
                    ->label('Tipo')
                    ->options([
                        'candidate' => 'Pessoa Física',
                        'company' => 'Empresa',
                        'undefined' => 'Não definido',
                        'internal' => 'Interno',

                    ])
            ])
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // RelationManagers\RoleRelationManager::class,]
            AuthenticationLogsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
