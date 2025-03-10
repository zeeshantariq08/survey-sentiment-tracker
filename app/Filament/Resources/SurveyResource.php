<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyResource\Pages;
use App\Filament\Resources\SurveyResource\RelationManagers;
use App\Models\Member;
use App\Models\Survey;
use App\Models\SurveyAssignment;
use App\Services\GeminiService;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurveyResource extends Resource
{
    protected static ?string $model = Survey::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Surveys';



    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Survey Title')
                    ->required()
                    ->reactive()
                    ->afterStateUpdated(function ($state, callable $set, $livewire) {
                        if (!empty($state) && $livewire instanceof CreateRecord) { // Only generate questions on create
                            $gemini = new GeminiService();
                            $questions = $gemini->generateQuestions($state);

                            if (!is_array($questions)) {
                                throw new \Exception('Invalid response format from Gemini API');
                            }

                            // Convert options into an array of objects
                            $formattedQuestions = collect($questions)->map(function ($q) {
                                return [
                                    'question_text' => $q['question'] ?? '',
                                    'type' => $q['type'] ?? 'open-ended',
                                    'answer_options' => isset($q['answer_options'])
                                        ? collect($q['answer_options'])->map(fn($option) => ['option' => $option])->toArray()
                                        : [],
                                ];
                            })->toArray();

                            $set('questions', $formattedQuestions);
                        }
                    }),

                Forms\Components\Textarea::make('description')
                    ->label('Survey Description')
                    ->rows(3),
                Forms\Components\Select::make('members')
                    ->label('Assign to Members')
                    ->multiple()
                    ->relationship('members', 'name') // Adjust 'name' to the appropriate column
                    ->preload(),

                Forms\Components\Repeater::make('questions')
                    ->label('Survey Questions')
                    ->schema([
                        Forms\Components\TextInput::make('question_text')
                            ->label('Question')
                            ->required(),

                        Forms\Components\Select::make('type')
                            ->label('Question Type')
                            ->options([
                                'open-ended' => 'Open-Ended',
                                'scale' => 'Scale (1-10)',
                                'multiple-choice' => 'Multiple Choice',
                            ])
                            ->reactive()
                            ->required(),

                        Forms\Components\Repeater::make('answer_options')
                            ->label('Answer Options')
                            ->schema([
                                Forms\Components\TextInput::make('option')
                                    ->label('Option')
                                    ->required(),
                            ])
                            ->columns(1)
                            ->visible(fn ($get) => in_array($get('type'), ['multiple-choice', 'scale']))
                            ->default([]),
                    ])
                    ->hiddenOn(['edit'])
                    ->columns(1)
                    ->default([])
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title'),
                Tables\Columns\TextColumn::make('created_at')->dateTime(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
             //
            ]);
    }
    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveys::route('/'),
            'create' => Pages\CreateSurvey::route('/create'),
            'edit' => Pages\EditSurvey::route('/{record}/edit'),
        ];
    }
}
