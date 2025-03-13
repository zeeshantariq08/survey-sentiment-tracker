<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use Carbon\Carbon;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Grid;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Widgets\Widget;
use Filament\Forms\Contracts\HasForms;
use Filament\Forms\Concerns\InteractsWithForms;

class SurveyFilterWidget extends Widget implements HasForms
{
    use InteractsWithForms;
    use HasFiltersForm;

    protected static bool $isLazy = false;
    protected static string $view = 'filament.widgets.survey-filter-widget';
    protected static ?int $sort = 1;
    public ?array $data = [];
    protected int|string|array $columnSpan = 'full';

    public function filtersForm(Form $form): Form
    {
        return $form
            ->statePath('data')
            ->schema([
                Grid::make(4)
                    ->schema([
                        Select::make('surveyId')
                            ->label('Select Survey')
                            ->options(Survey::pluck('title', 'id'))
                            ->live()
                            ->default(null)
                            ->afterStateUpdated(fn($state) => $this->dispatch('updateSurveyFilters', filters: ['surveyId' => $state])),

                        Select::make('sentiment')
                            ->label('Sentiment')
                            ->options([
                                'positive' => 'Positive',
                                'negative' => 'Negative',
                                'neutral' => 'Neutral',
                            ])
                            ->live()
                            ->default(null)
                            ->afterStateUpdated(fn($state) => $this->dispatch('updateSurveyFilters', filters: ['sentiment' => $state])),

//                        // Response Type Dropdown
//                        Select::make('responseType')
//                            ->label('Response Type')
//                            ->options([
//                                'text' => 'Text',
//                                'multiple_choice' => 'Multiple Choice',
//                            ])
//                            ->live()
//                            ->default(null)
//                            ->afterStateUpdated(fn ($state) => $this->dispatch('updateSurveyFilters', filters: ['responseType' => $state])),


                    ]),
            ]);
    }
}
