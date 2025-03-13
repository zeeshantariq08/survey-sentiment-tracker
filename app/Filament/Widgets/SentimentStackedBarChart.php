<?php

namespace App\Filament\Widgets;

use App\Models\Survey;
use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;

class SentimentStackedBarChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Distribution by Survey';
    protected static ?int $sort = 2;

    public ?array $filters = [];

    protected function getData(): array
    {
        $query = SurveyResponse::selectRaw('surveys.title, sentiment, COUNT(*) as count')
            ->join('surveys', 'surveys.id', '=', 'survey_responses.survey_id')
            ->groupBy('surveys.title', 'sentiment');

        if (!empty($this->filters['surveyId'])) {
            $query->where('surveys.id', $this->filters['surveyId']);
        }

        if (!empty($this->filters['sentiment'])) {
            $query->where('sentiment', $this->filters['sentiment']);
        }

        $surveyResponses = $query->get()->groupBy('title');
        $surveys = Survey::pluck('title')->toArray(); // Fetch all survey titles

        $positive = [];
        $negative = [];
        $neutral = [];

        foreach ($surveys as $surveyTitle) {
            $responses = $surveyResponses[$surveyTitle] ?? collect();
            $positive[] = $responses->firstWhere('sentiment', 'positive')?->count ?? 0;
            $negative[] = $responses->firstWhere('sentiment', 'negative')?->count ?? 0;
            $neutral[] = $responses->firstWhere('sentiment', 'neutral')?->count ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Positive',
                    'data' => $positive,
                    'backgroundColor' => '#22c55e',
                    'stack' => 'sentiments'
                ],
                [
                    'label' => 'Neutral',
                    'data' => $neutral,
                    'backgroundColor' => '#facc15',
                    'stack' => 'sentiments'
                ],
                [
                    'label' => 'Negative',
                    'data' => $negative,
                    'backgroundColor' => '#ef4444',
                    'stack' => 'sentiments'
                ],
            ],
            'labels' => $surveys, // Survey titles as labels
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
    {
        return [
            'scales' => [
                'x' => ['stacked' => true],
                'y' => ['stacked' => true],
            ],
        ];
    }

    protected function getListeners(): array
    {
        return [
            'updateSurveyFilters' => 'updateFilters',
        ];
    }

    public function updateFilters(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);
        $this->updateChartData();
    }
}
