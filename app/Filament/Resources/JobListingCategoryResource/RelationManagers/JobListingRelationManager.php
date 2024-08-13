<?php

namespace App\Filament\Resources\JobListingCategoryResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobListingRelationManager extends RelationManager
{
    protected static string $relationship = 'jobListings';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('user_id')
                ->label('Autor')
                ->relationship('user', 'email',)
                ->searchable()
                ->preload()
                ->required(),
                TextInput::make('title')
                ->label('Título')
                ->required()
                ->maxLength(155),
                RichEditor::make('content')
                ->columnSpan('full')
                ->label('Descrição'),
                TextInput::make('location')
                ->label('Localização')
                ->required()
                ->maxLength(155),
                Forms\Components\TextInput::make('salary')
                ->label('Salário')
                ->numeric()
                ->prefix('R$')
                ->maxValue(42949672.95),
                Select::make('status')
                ->options([
                    'publish' => 'Publicado',
                    'future' => 'Agendado',
                    'draft' => 'Rascunho',
                    'pending' => 'Revisão pendente',
                    'private' => 'Privado',
                ])->required(),
                // Forms\Components\Select::make('job_listing_category_id')
                // ->label('Categoria')
                // ->relationship('jobListingCategory', 'name')
                // ->searchable()
                // ->preload()
                // ->createOptionForm([
                //     TextInput::make('name')
                //     ->required()
                //     ->maxLength(255)
                // ])
                // ->required(),
                Forms\Components\Select::make('job_listing_type_id')
                ->label('Tipo de vaga')
                ->relationship('jobListingType', 'name')
                ->searchable()
                ->preload()
                ->createOptionForm([
                    TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                ])
                ->required(),
                DatePicker::make('posting_date')
                ->label('Data de postagem')
                ->format('Y-m-d')
                ->timezone('America/Belem')
                ->required()
                ->maxDate(now()),
                DatePicker::make('expiration_date')
                ->label('Data de expiração')
                ->format('Y-m-d')
                ->timezone('America/Belem'),
                Radio::make('confidencial')
                ->label('É uma vaga confidencial?')
                ->boolean()
                ->inline(),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('title')
            ->columns([
                Tables\Columns\TextColumn::make('title'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }
}
