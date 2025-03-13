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
use Google\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\Actions\Action;

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
                    ->reactive(),

                Forms\Components\Textarea::make('description')
                    ->label('Survey Description')
                    ->rows(3)
                    ->required(),

                Forms\Components\Select::make('members')
                    ->label('Assign to Members')
                    ->multiple()
                    ->relationship('members', 'name')
                    ->preload(),

                Forms\Components\Section::make('Generate Survey Questions')
                    ->schema([
                        Forms\Components\Placeholder::make('generate_button')
                            ->content('Click the button to generate survey questions.')
                            ->columnSpanFull(),

                        Forms\Components\Actions::make([
                            Action::make('generateQuestions')
                                ->label('Generate Questions')
                                ->color('primary')
                                ->icon('heroicon-o-light-bulb')
                                ->action(fn (callable $set, callable $get) => self::fetchQuestions($set, $get)),
                        ]),

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
                            ->columns(1)
                            ->default([])
                            ->hidden(fn ($get) => empty($get('questions'))), // Hide questions until generated
                    ])->hidden(function (?\Illuminate\Database\Eloquent\Model $record) {
                        if ($record?->questions->count() == 0) {
                            return false;
                        }
                        return true;


                    })
            ]);
    }

    /**
     * Fetch questions from Gemini API
     */
    protected static function fetchQuestions(callable $set, callable $get)
    {
        $title = $get('title');
        $description = $get('description');

        if (empty($title) || empty($description)) {
            return;
        }

        $gemini = new GeminiService();
        $questions = $gemini->generateQuestions($title, $description);

        if (!is_array($questions)) {
            throw new \Exception('Invalid response format from Gemini API');
        }

        $formattedQuestions = collect($questions)->map(function ($q) {
            return [
                'question_text' => $q['question_text'] ?? '',
                'type' => $q['type'] ?? 'open-ended',
                'answer_options' => isset($q['answer_options'])
                    ? collect($q['answer_options'])->map(fn($option) => ['option' => $option])->toArray()
                    : [],
            ];
        })->toArray();


        $set('questions', $formattedQuestions);
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
