<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SentimentOverTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Over Time';
    protected static string $type = 'line';
    protected static ?int $sort = 3;

    public ?array $filters = [];

    protected function getData(): array
    {
        $query = SurveyResponse::selectRaw("DATE(created_at) as date, sentiment, COUNT(*) as count")
            ->groupBy('date', 'sentiment');

        if (!empty($this->filters['surveyId'])) {
            $query->where('survey_id', $this->filters['surveyId']);
        }

        if (!empty($this->filters['sentiment'])) {
            $query->where('sentiment', $this->filters['sentiment']);
        }

        $data = $query->get()->groupBy('sentiment');

        $labels = collect(Carbon::now()->subDays(30)->toPeriod(Carbon::now()))
            ->map->toDateString()->toArray();

        return [
            'datasets' => $data->map(fn($values, $sentiment) => [
                'label' => ucfirst($sentiment),
                'data' => collect($labels)->map(fn($date) => $values->firstWhere('date', $date)?->count ?? 0)->toArray(),
                'backgroundColor' => match ($sentiment) {
                    'positive' => '#22c55e',
                    'neutral' => '#facc15',
                    'negative' => '#ef4444',
                },
                'borderColor' => match ($sentiment) {
                    'positive' => '#16a34a',
                    'neutral' => '#d97706',
                    'negative' => '#d11f1f',
                },
            ])->values()->toArray(),
            'labels' => $labels,
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
