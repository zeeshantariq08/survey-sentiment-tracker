<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Carbon\Carbon;
use Filament\Widgets\ChartWidget;

class SentimentOverTimeChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Over Time';
    protected static string $type = 'line';
    protected static ?int $sort = 2;


    protected function getData(): array
    {
        $data = SurveyResponse::selectRaw("DATE(created_at) as date, sentiment, COUNT(*) as count")
            ->groupBy('date', 'sentiment')
            ->get()
            ->groupBy('sentiment');

        $labels = collect(Carbon::now()->subDays(30)->toPeriod(Carbon::now()))->map->toDateString()->toArray();

        return [
            'datasets' => $data->map(fn($values, $sentiment) => [
                'label' => ucfirst($sentiment),
                'data' => collect($labels)->map(fn($date) => $values->firstWhere('date',
                    $date)?->count ?? 0)->toArray(),
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
}
