<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;

class SentimentDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Distribution';
    protected static ?int $sort = 4;

    protected function getData(): array
    {
        $sentimentCounts = SurveyResponse::selectRaw("sentiment, COUNT(*) as count")
            ->groupBy('sentiment')
            ->pluck('count', 'sentiment')
            ->toArray();

        return [
            'datasets' => [
                [
                    'label' => 'Sentiments',
                    'data' => array_values($sentimentCounts),
                    'backgroundColor' => ['#22c55e', '#facc15', '#ef4444'],
                    'borderColor' => ['#22c55e', '#facc15', '#ef4444']
                ],
            ],
            'labels' => ['Positive', 'Neutral', 'Negative'],
        ];
    }

    protected function getType(): string
    {
        return 'pie'; // ✅ Ensure it's a valid chart type
    }
}
