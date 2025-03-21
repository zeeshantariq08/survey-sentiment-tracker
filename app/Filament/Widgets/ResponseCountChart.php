<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;

class ResponseCountChart extends ChartWidget
{
    protected static ?string $heading = 'Response Count by Sentiment';
    protected static string $type = 'bar';
    protected static ?int $sort = 2;

    public ?array $filters = [];

    protected function getData(): array
    {
        $query = SurveyResponse::selectRaw('surveys.title, sentiment, COUNT(*) as count')
            ->join('surveys', 'surveys.id', '=', 'survey_responses.survey_id')
            ->groupBy('surveys.title', 'sentiment');

        if (!empty($this->filters['sentiment'])) {
            $query->where('survey_responses.sentiment', $this->filters['sentiment']);
        }

        if (!empty($this->filters['surveyId'])) {
            $query->where('surveys.id', $this->filters['surveyId']);
        }

        $surveyResponses = $query->get()->groupBy('title');
        $surveys = $surveyResponses->keys()->toArray();

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
                ['label' => 'Positive', 'data' => $positive, 'backgroundColor' => '#22c55e', 'borderColor' => '#22c55e'],
                ['label' => 'Negative', 'data' => $negative, 'backgroundColor' => '#ef4444', 'borderColor' => '#ef4444'],
                ['label' => 'Neutral', 'data' => $neutral, 'backgroundColor' => '#facc15', 'borderColor' => '#facc15'],
            ],
            'labels' => $surveys,
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

    public function updateFilters(array $filters)
    {
        $this->filters = array_merge($this->filters, $filters);
        $this->updateChartData();
    }
}
