<?php


namespace App\Filament\Widgets;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;

class SentimentCategoryChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Category Analysis';
    protected static ?int $sort = 10;

    protected function getData(): array
    {
        $surveys = Survey::pluck('title'); // Fetch dynamic survey titles

        $positive = [];
        $negative = [];
        $neutral = [];

        foreach ($surveys as $surveyTitle) {
            $positive[] = SurveyResponse::whereHas('survey', function ($query) use ($surveyTitle) {
                $query->where('title', $surveyTitle);
            })->where('sentiment', 'positive')->count();

            $negative[] = SurveyResponse::whereHas('survey', function ($query) use ($surveyTitle) {
                $query->where('title', $surveyTitle);
            })->where('sentiment', 'negative')->count();

            $neutral[] = SurveyResponse::whereHas('survey', function ($query) use ($surveyTitle) {
                $query->where('title', $surveyTitle);
            })->where('sentiment', 'neutral')->count();
        }

        return [
            'datasets' => [
                ['label' => 'Positive', 'data' => $positive, 'backgroundColor' => '#22c55e'], // Green
                ['label' => 'Negative', 'data' => $negative, 'backgroundColor' => '#ef4444'], // Red
                ['label' => 'Neutral', 'data' => $neutral, 'backgroundColor' => '#facc15'], // Yellow
            ],
            'labels' => $surveys->toArray(), // Survey titles as labels
        ];
    }

    protected function getType(): string
    {
        return 'radar';
    }
}
