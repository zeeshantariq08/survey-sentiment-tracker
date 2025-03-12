<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyResponseResource\Pages;
use App\Filament\Resources\SurveyResponseResource\RelationManagers;
use App\Models\SurveyResponse;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;

class SurveyResponseResource extends Resource
{
    protected static ?string $model = SurveyResponse::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $navigationGroup = 'Surveys';
    protected static ?int $navigationSort = 3;


    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('survey.title')
                    ->label('Survey Title')
                    ->sortable()
                    ->searchable()
                    ->toggleable(),

                Tables\Columns\TextColumn::make('question.question')
                    ->label('Question')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('answer')
                    ->label('Response')
                    ->limit(50)
                    ->sortable(),

                Tables\Columns\TextColumn::make('sentiment')
                    ->label('Sentiment')
                    ->formatStateUsing(fn($record) => ucfirst($record->sentiment)) // Capitalize first letter
                    ->badge() // Converts the text into a badge
                    ->color(fn($state) => match ($state) {
                        'positive' => 'success', // Green
                        'negative' => 'danger',  // Red
                        'neutral' => 'warning',  // Yellow
                        default => 'gray',       // Default color
                    })
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('survey_id')
                    ->relationship('survey', 'title')
                    ->label('Filter by Survey'),
            ])
            ->defaultSort('created_at', 'desc');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSurveyResponses::route('/'),
            'create' => Pages\CreateSurveyResponse::route('/create'),
            'edit' => Pages\EditSurveyResponse::route('/{record}/edit'),
        ];
    }
}
