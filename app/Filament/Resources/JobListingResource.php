<?php

namespace App\Filament\Resources;

use App\Filament\Resources\JobListingResource\Pages;
use App\Filament\Resources\JobListingResource\RelationManagers;
use App\Models\JobListing;
use Filament\Forms;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\TimePicker;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobListingResource extends Resource
{
    protected static ?string $model = JobListing::class;

    // protected static ?string $navigationIcon = 'heroicon-o-megaphone';

    protected static ?string $modelLabel = 'vaga';

    protected static ?string $pluralModelLabel = 'vagas de emprego';

    protected static ?string $navigationLabel = 'Vagas';

    protected static ?string $navigationGroup = 'Recrutamento';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
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
                Forms\Components\Select::make('job_listing_category_id')
                ->label('Categoria')
                ->relationship('jobListingCategory', 'name')
                ->searchable()
                ->preload()
                ->createOptionForm([
                    TextInput::make('name')
                    ->required()
                    ->maxLength(255)
                ])
                ->required(),
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                ->label('Título')
                ->searchable(),
                Tables\Columns\TextColumn::make('status')
                ->sortable(),
                Tables\Columns\TextColumn::make('salary')
                ->money('BRL')
                ->sortable()
                ->label('Salário'),
                Tables\Columns\TextColumn::make('location')
                ->label('Localização'),
                Tables\Columns\TextColumn::make('jobListingCategory.name')
                ->label('Categoria')
                ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                ->label('Criado em')
                ->sortable()
                ->dateTime('d M Y h:i A'),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('status')
                ->options([
                    'publish' => 'Publicado',
                    'future' => 'Agendado',
                    'draft' => 'Rascunho',
                    'pending' => 'Revisão pendente',
                    'private' => 'Privado',
                ]),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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

    public static function getRelations(): array
    {
        return [
            // RelationManagers\JobListingCategoryRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobListings::route('/'),
            'create' => Pages\CreateJobListing::route('/create'),
            'edit' => Pages\EditJobListing::route('/{record}/edit'),
        ];
    }
}
