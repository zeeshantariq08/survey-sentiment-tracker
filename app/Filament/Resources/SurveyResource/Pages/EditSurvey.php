<?php

namespace App\Filament\Resources\SurveyResource\Pages;
use Illuminate\Database\Eloquent\Model;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSurvey extends EditRecord
{
    protected static string $resource = SurveyResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }

}
