<?php

namespace App\Filament\Resources;

use App\Filament\Clusters\JobSettings;
use App\Filament\Clusters\Triagem;
use App\Filament\Resources\JobListingCategoryResource\Pages;
use App\Filament\Resources\JobListingCategoryResource\RelationManagers;
use App\Models\JobListingCategory;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class JobListingCategoryResource extends Resource
{
    protected static ?string $model = JobListingCategory::class;

    protected static ?string $modelLabel = 'categoria';

    protected static ?string $pluralModelLabel = 'categorias';

    protected static ?string $navigationLabel = 'Categorias das vagas';

    protected static ?string $navigationIcon = 'heroicon-o-hashtag';

    protected static ?string $cluster = JobSettings::class;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')->label('name')->required()->maxLength(155),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nome')
            ])
            ->filters([
                //
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
             RelationManagers\JobListingRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListJobListingCategories::route('/'),
            'create' => Pages\CreateJobListingCategory::route('/create'),
            'edit' => Pages\EditJobListingCategory::route('/{record}/edit'),
        ];
    }
}
