<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuizResultResource\Pages;
use App\Filament\Resources\QuizResultResource\RelationManagers;
use App\Models\QuizResult;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuizResultResource extends Resource
{
    protected static ?string $model = QuizResult::class;

    protected static ?string $navigationGroup = 'Testes';

    protected static ?string $modelLabel = 'Resultados';

    protected static ?string $navigationIcon = 'heroicon-o-document-check';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('quiz_id')
                    ->label('#')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quiz_name')
                    ->label('Teste')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quiz_system')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('point_score')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('correct_score')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('correct')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('total')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('user_id')
                    ->required()
                    ->numeric(),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('business')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('form_type')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('quiz_results')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        function perfil(QuizResult $record, $perfil)
        {
            $quiz_results = $record->quiz_results;

            $contagem = array_count_values($quiz_results);

            $mapeamento = [
                "A" => "Dominância",
                "B" => "Influência",
                "C" => "Estabilidade",
                "D" => "Conformidade",
            ];

            $contagemRotulada = [];
            $totalElementos = count($quiz_results);

            foreach ($contagem as $chave => $ocorrencias) {
                $rotulo = $mapeamento[$chave];
                $porcentagem = ($ocorrencias / $totalElementos) * 100;
                $contagemRotulada[$rotulo] = number_format($porcentagem);
                // $contagemRotulada[$rotulo] = $ocorrencias;
            }
            // dd($record->quiz_results, $contagem, $totalElementos, $contagemRotulada);
            if (array_key_exists($perfil, $contagemRotulada)) {
                $result = $contagemRotulada[$perfil];
            } else {
                $result = 0;
            }

            return $result;
        }

        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('quiz_name')
                    ->label('Teste')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('candidate.phone')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->translateLabel()
                    ->searchable()
                    ->sortable(),
                Tables\Columns\TextColumn::make('result_dominacia')
                    ->label('Dominância')
                    ->suffix('%')
                    ->state(function (QuizResult $record): string {
                        $perfil = perfil($record, 'Dominância');
                        return $perfil;
                    }),
                Tables\Columns\TextColumn::make('result_influencia')
                    ->label('Influência')
                    ->suffix('%')
                    ->state(function (QuizResult $record): string {
                        $perfil = perfil($record, 'Influência');
                        return $perfil;
                    }),
                Tables\Columns\TextColumn::make('result_estabilidade')
                    ->label('Estabilidade')
                    ->suffix('%')
                    ->state(function (QuizResult $record): string {
                        $perfil = perfil($record, 'Estabilidade');
                        return $perfil;
                    }),
                Tables\Columns\TextColumn::make('result_conformidade')
                    ->label('Conformidade')
                    ->suffix('%')
                    ->state(function (QuizResult $record): string {
                        $perfil = perfil($record, 'Conformidade');
                        return $perfil;
                    }),
                Tables\Columns\TextColumn::make('email')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('id', 'desc')
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
            ])
            ->emptyStateActions([
                // Tables\Actions\CreateAction::make(),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ManageQuizResults::route('/'),
        ];
    }
}
