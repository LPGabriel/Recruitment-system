<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\Triagem;
use App\Filament\Resources\JobApplicantResource\Pages;
use App\Filament\Resources\JobApplicantResource\RelationManagers;
use App\Models\JobApplicant;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Pages\SubNavigationPosition;

class JobApplicantResource extends Resource
{
    protected static ?string $model = JobApplicant::class;

    protected static ?string $navigationIcon = 'heroicon-o-cursor-arrow-ripple';

    protected static ?string $modelLabel = 'Candidatura';

    protected static ?string $pluralModelLabel = 'candidaturas';

    protected static ?string $navigationLabel = 'Candidaturas';

    protected static ?string $cluster = Triagem::class;


    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('job_listing_id')
                    ->relationship('jobListing', 'title')
                    ->searchable()
                    ->label('Vaga pretendida')
                    ->required(),
                Forms\Components\Select::make('user_id')
                    ->relationship('candidate', 'email')
                    ->searchable()
                    ->label('Candidato')
                    ->required(),
                Forms\Components\RichEditor::make('message')
                    ->label('Deixe uma mensagem para a empresa')
                    ->columnSpan('full')
                    ->required()
                    ->maxLength(255),
                Forms\Components\Hidden::make('status')
                    ->default('pending'),
                Forms\Components\FileUpload::make('applicant_cv_file_path')
                    ->preserveFilenames()
                    ->directory('CVs')
                    ->acceptedFileTypes(['application/pdf'])
                    ->openable()
                    ->label('Enviar currículo'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Candidato')
                    ->searchable(),
                Tables\Columns\TextColumn::make('jobListing.title')
                    ->label('Vaga')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('status')
                    ->label('Status')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime('d/M/Y H:m')
                    ->label('Data')
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
                Tables\Actions\ForceDeleteAction::make(),
                Tables\Actions\RestoreAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ])
            ->emptyStateActions([
                Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageJobApplicants::route('/'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
