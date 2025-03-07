<?php

namespace App\Filament\Resources\SurveyAnswerOptionResource\Pages;

use App\Filament\Resources\SurveyAnswerOptionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListSurveyAnswerOptions extends ListRecords
{
    protected static string $resource = SurveyAnswerOptionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
