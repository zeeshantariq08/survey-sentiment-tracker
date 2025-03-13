<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;

class SentimentDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Distribution';
    protected static ?int $sort = 4;

    public ?array $filters = [];

    protected function getData(): array
    {
        $query = SurveyResponse::selectRaw("sentiment, COUNT(*) as count")->groupBy('sentiment');

        if (!empty($this->filters['surveyId'])) {
            $query->where('survey_id', $this->filters['surveyId']);
        }

        if (!empty($this->filters['sentiment'])) {
            $query->where('sentiment', $this->filters['sentiment']);
        }

        $sentimentCounts = $query->pluck('count', 'sentiment')->toArray();

        $availableSentiments = array_keys($sentimentCounts);
        $sentimentLabels = [
            'positive' => 'Positive',
            'neutral' => 'Neutral',
            'negative' => 'Negative',
        ];

        return [
            'datasets' => [
                [
                    'label' => 'Sentiments',
                    'data' => array_values($sentimentCounts),
                    'backgroundColor' => ['#22c55e', '#facc15', '#ef4444'],
                    'borderColor' => ['#22c55e', '#facc15', '#ef4444']
                ],
            ],
            'labels' => array_map(fn($s) => $sentimentLabels[$s] ?? ucfirst($s), $availableSentiments),
        ];
    }

    protected function getType(): string
    {
        return 'pie';
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
