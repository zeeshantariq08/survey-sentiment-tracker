<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class SentimentScoreChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Score Changes';
    protected static ?int $sort = 3;
    public ?array $filters = [];

    protected function getData(): array
    {
        $dates = [];
        $scores = [];

        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $dates[] = $date;

            $query = SurveyResponse::whereDate('created_at', $date)
                ->selectRaw('SUM(CASE WHEN sentiment = "positive" THEN 1 WHEN sentiment = "negative" THEN -1 ELSE 0 END) as score');

            if (!empty($this->filters['surveyId'])) {
                $query->where('survey_id', $this->filters['surveyId']);
            }

            if (!empty($this->filters['sentiment'])) {
                $query->where('sentiment', $this->filters['sentiment']);
            }

            $scores[] = $query->value('score') ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Sentiment Score',
                    'data' => $scores,
                    'borderColor' => '#3b82f6',
                    'fill' => false,
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'line';
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
