<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SurveyAnswerOptionResource\Pages;
use App\Filament\Resources\SurveyAnswerOptionResource\RelationManagers;
use App\Models\SurveyAnswerOption;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class SurveyAnswerOptionResource extends Resource
{
    protected static ?string $model = SurveyAnswerOption::class;
    protected static ?string $navigationGroup = 'Surveys';
    protected static ?int $navigationSort = 3;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                //
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question.question'),
                Tables\Columns\TextColumn::make('question.type'),
                Tables\Columns\TextColumn::make('option_text'),
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
            ]);
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
            'index' => Pages\ListSurveyAnswerOptions::route('/'),
            'create' => Pages\CreateSurveyAnswerOption::route('/create'),
            'edit' => Pages\EditSurveyAnswerOption::route('/{record}/edit'),
        ];
    }
}
