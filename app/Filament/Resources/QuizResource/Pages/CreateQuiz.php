<?php

namespace App\Filament\Resources\QuizResource\Pages;

use App\Filament\Resources\QuizResource;
use App\Models\Quiz;
use Filament\Actions;
use Filament\Forms\Components\Builder;
use Filament\Forms\Components\Checkbox;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\Wizard\Step;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Str;

class CreateQuiz extends CreateRecord
{

    use CreateRecord\Concerns\HasWizard;

    protected static string $resource = QuizResource::class;

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['user_id'] = auth()->id();
        return $data;
    }


    protected function getSteps(): array
    {
        return [
            Step::make('Quiz')
                ->columns(2)
                ->description('')
                ->schema([
                    TextInput::make('title')
                        ->label('Título')
                        ->required()
                        ->live()
                        ->afterStateUpdated(fn ($state, callable $set) => $set('slug', Str::slug($state))),
                    TextInput::make('slug')
                        ->label('slug - (Deve ser automático e único)')
                        ->required()
                        ->unique(Quiz::class, 'slug', fn ($record) => $record),
                    TextInput::make('description')
                        ->label('Descrição'),
                    Select::make('quiz_type')
                        ->label('quiz_type (quiz ou form)')
                        ->options([
                            'quiz' => 'Quiz',
                            'survey' => 'Pesquisa',
                        ]),
                    Select::make('quiz_system')
                        ->label('quiz_system (points ou correct/incorrect)')
                        ->options([
                            'points' => 'Pontos',
                            'incorrect/correct' => 'Correto/Incorreto',
                        ]),
                    // Toggle::make('')

                ]),
            Step::make('Questões')
                ->description('Adicione suas perguntas')
                ->schema([
                    Repeater::make('questions')
                        ->label('Perguntas')
                        ->relationship()
                        ->defaultItems(1)
                        ->schema([
                            // Toggle::make('hide_title')
                            //     ->label('hide_title')
                            //     ->columnSpan([
                            //         'sm' => 2,
                            //         'xl' => 3,
                            //         '2xl' => 2,
                            //     ]),
                            TextInput::make('title')
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
            Step::make('Textos e parametros')
                ->description('')
                ->schema([
                    RichEditor::make('message_before')
                        ->label('Texto antes do questionário'),
                    RichEditor::make('message_after')
                        ->label('Texto após teste'),
                ]),

        ];
    }
}
