<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;

class SentimentDistributionChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Distribution';

    protected function getData(): array
    {
        $positive = SurveyResponse::where('sentiment', 'positive')->count();
        $neutral = SurveyResponse::where('sentiment', 'neutral')->count();
        $negative = SurveyResponse::where('sentiment', 'negative')->count();

        return [
            'datasets' => [
                [
                    'label' => 'Sentiments',
                    'data' => [$positive, $neutral, $negative],
                    'backgroundColor' => ['#22c55e', '#facc15', '#ef4444'], // ✅ Moved inside dataset
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
