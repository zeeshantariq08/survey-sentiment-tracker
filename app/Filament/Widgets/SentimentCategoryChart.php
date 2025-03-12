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
        $surveys = Survey::pluck('title')->toArray(); // Fetch survey titles once

        // Fetch all counts in a single query using GROUP BY
        $surveyResponses = SurveyResponse::selectRaw('surveys.title, sentiment, COUNT(*) as count')
            ->join('surveys', 'surveys.id', '=', 'survey_responses.survey_id')
            ->whereIn('surveys.title', $surveys)
            ->groupBy('surveys.title', 'sentiment')
            ->get()
            ->groupBy('title');

        // Initialize dataset arrays
        $positive = [];
        $negative = [];
        $neutral = [];

        // Loop through surveys and extract sentiment counts efficiently
        foreach ($surveys as $surveyTitle) {
            $responses = $surveyResponses[$surveyTitle] ?? collect();
            $positive[] = $responses->firstWhere('sentiment', 'positive')?->count ?? 0;
            $negative[] = $responses->firstWhere('sentiment', 'negative')?->count ?? 0;
            $neutral[] = $responses->firstWhere('sentiment', 'neutral')?->count ?? 0;
        }

        return [
            'datasets' => [
                ['label' => 'Positive', 'data' => $positive, 'backgroundColor' => '#22c55e'], // Green
                ['label' => 'Negative', 'data' => $negative, 'backgroundColor' => '#ef4444'], // Red
                ['label' => 'Neutral', 'data' => $neutral, 'backgroundColor' => '#facc15'], // Yellow
            ],
            'labels' => $surveys, // Survey titles as labels
        ];
    }

    protected function getType(): string
    {
        return 'radar';
    }
}
