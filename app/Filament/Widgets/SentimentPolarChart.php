<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;

class SentimentPolarChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Distribution (Polar Area)';
    protected static string $type = 'polarArea';
    protected static ?int $sort = 3;

    public ?array $filters = [];

    public function updateFilters(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);
        $this->updateChartData();
    }

    protected function getData(): array
    {
        $query = SurveyResponse::selectRaw('sentiment, COUNT(*) as count')
            ->groupBy('sentiment');

        if (!empty($this->filters['sentiment'])) {
            $query->where('sentiment', $this->filters['sentiment']);
        }

        if (!empty($this->filters['surveyId'])) {
            $query->where('survey_id', $this->filters['surveyId']);
        }

        $sentimentCounts = $query->pluck('count', 'sentiment')->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Sentiments',
                    'data' => [
                        $sentimentCounts['positive'] ?? 0,
                        $sentimentCounts['neutral'] ?? 0,
                        $sentimentCounts['negative'] ?? 0,
                    ],
                    'backgroundColor' => ['#22c55e', '#facc15', '#ef4444'],
                    'borderColor' => ['#16a34a', '#d97706', '#d11f1f']
                ],
            ],
            'labels' => ['Positive', 'Neutral', 'Negative'],
        ];
    }

    protected function getType(): string
    {
        return self::$type;
    }

    protected function getListeners(): array
    {
        return [
            'updateSurveyFilters' => 'updateFilters',
        ];
    }
}
