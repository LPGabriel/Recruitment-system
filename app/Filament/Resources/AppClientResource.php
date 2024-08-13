<?php

namespace App\Filament\Resources;

use App\Filament\Resources\AppClientResource\Pages;
use App\Filament\Resources\AppClientResource\RelationManagers;
use App\Models\AppClient;
use Filament\Forms;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AppClientResource extends Resource
{
    protected static ?string $model = AppClient::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?string $navigationGroup = 'Administração';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //title
                TextInput::make('name')
                    ->required(),
                TextInput::make('redirect')
                    ->required(),
                Radio::make('personal_access_client')
                    ->label('Personal access Client?')
                    ->required()
                    ->boolean()
                    ->inline(),
                Radio::make('password_client')
                    ->label('Password Client?')
                    ->required()
                    ->boolean()
                    ->inline(),
                Radio::make('revoked')
                    ->label('Revoked?')
                    ->required()
                    ->boolean()
                    ->inline(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),
                TextColumn::make('redirect')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft(),

                TextColumn::make('id')
                ->searchable()
                ->sortable()
                ->weight('medium')
                ->alignLeft(),

                TextColumn::make('secret')
                    ->searchable()
                    ->sortable()
                    ->weight('medium')
                    ->alignLeft()
            ])
            ->filters([
                //
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

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageApps::route('/'),
        ];
    }
}
