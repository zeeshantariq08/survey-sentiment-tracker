<?php

namespace App\Filament\Resources\SurveyResponseResource\Pages;

use App\Filament\Resources\SurveyResponseResource;
use App\Models\Status;
use Filament\Resources\Components\Tab;
use Filament\Resources\Pages\ListRecords;
use Illuminate\Database\Eloquent\Builder;

class ListSurveyResponses extends ListRecords
{
    protected static string $resource = SurveyResponseResource::class;

    protected function getHeaderActions(): array
    {
        return [
//            Actions\CreateAction::make(),
        ];
    }

    public function getTabs(): array
    {
        //get all different sentiment values
        $sentiments = SurveyResponseResource::getModel()::select('sentiment')->distinct()->get();
        $tabs['All'] = Tab::make()
            ->label('All')
            ->modifyQueryUsing(fn(Builder $query) => $query);
        foreach ($sentiments as $sentiment) {
            $tabs[$sentiment->sentiment] = Tab::make()
                ->label($sentiment->sentiment)
                ->modifyQueryUsing(fn(Builder $query) => $query->where('sentiment', $sentiment->sentiment));
        }
        return $tabs;
    }
}
