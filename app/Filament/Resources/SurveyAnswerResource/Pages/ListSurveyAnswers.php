<?php

namespace App\Filament\Resources\SurveyAnswerResource\Pages;

use App\Filament\Resources\SurveyAnswerResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurveyAnswers extends ListRecords
{
    protected static string $resource = SurveyAnswerResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
