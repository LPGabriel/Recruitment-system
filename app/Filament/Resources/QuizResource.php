<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResource\Pages;
use App\Filament\Resources\QuizResource\RelationManagers;
use App\Models\Quiz;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Tabs;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Wizard;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResource extends Resource
{
    protected static ?string $model = Quiz::class;

    protected static ?string $navigationIcon = 'heroicon-o-clipboard-document-list';

    protected static ?string $navigationGroup = 'Testes';

    protected static ?string $modelLabel = 'teste psicológico';

    protected static ?string $pluralModelLabel = 'testes psicológicos';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Tabs::make('Label')
                    ->tabs([
                        Tabs\Tab::make('Dados Gerais')
                            ->schema([
                                Forms\Components\TextInput::make('title')
                                    ->label('Título'),
                                Forms\Components\TextInput::make('description')
                                    ->label('Descrição'),
                                Forms\Components\Select::make('quiz_type')
                                    ->label('Tipo de Formulário')
                                    ->options([
                                        'quiz' => 'Quiz',
                                        'survey' => 'Pesquisa',
                                    ]),
                                Forms\Components\Select::make('quiz_system')
                                    ->label('Sistema de classificação')
                                    ->options([
                                        'points' => 'Pontos',
                                        'incorrect/correct' => 'Correto/Incorreto',
                                    ]),
                                Forms\Components\RichEditor::make('message_before')
                                    ->label('Texto antes do questionário'),
                                Forms\Components\RichEditor::make('message_after')
                                    ->label('Texto após teste'),
                            ]),
                        Tabs\Tab::make('Questões')
                            ->schema([
                                Repeater::make('questions')
                                    ->label('Perguntas')
                                    ->relationship()
                                    ->defaultItems(1)
                                    ->collapsible()
                                    ->itemLabel(fn (array $state): ?string => $state['title'] ?? null)
                                    ->schema([
                                        // Toggle::make('hide_title')
                                        //     ->label('hide_title')
                                        //     ->columnSpan([
                                        //         'sm' => 2,
                                        //         'xl' => 3,
                                        //         '2xl' => 2,
                                        //     ]),
                                        TextInput::make('title')
                                            ->live(onBlur: true)
                                            // ->label('Título')
                                            // ->required()
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                        Repeater::make('answers')
                                            // ->label('Alternativas')
                                            ->relationship('answers')
                                            ->schema([
                                                TextInput::make('text')
                                                // ->label('texto')
                                                // ->required()
                                                ,
                                                TextInput::make('score')
                                                // ->label('Score')
                                                // ->required()
                                                ,
                                            ])
                                            ->addActionLabel('Adicionar alternativa')
                                            ->columnSpan([
                                                'sm' => 2,
                                                'xl' => 3,
                                                '2xl' => 4,
                                            ]),
                                    ])
                                    ->addActionLabel('Adicionar pergunta')
                                    ->columns([
                                        'sm' => 3,
                                        'xl' => 6,
                                        '2xl' => 8,
                                    ]),

                            ]),
                    ])->columnSpanFull()
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('slug'),
                Tables\Columns\TextColumn::make('quiz_type'),
                Tables\Columns\TextColumn::make('quiz_system'),
                // Tables\Columns\TextColumn::make('title'),
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
            // RelationManagers\QuizzesRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuizzes::route('/'),
            'create' => Pages\CreateQuiz::route('/create'),
            'edit' => Pages\EditQuiz::route('/{record}/edit'),
        ];
    }
}
