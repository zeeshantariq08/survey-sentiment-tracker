<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;
use Illuminate\Support\Carbon;

class SentimentTrendChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Trend Over Time';

    protected function getData(): array
    {
        // Fetch data grouped by date
        $dates = [];
        $positiveData = [];
        $neutralData = [];
        $negativeData = [];

        // Last 7 days sentiment analysis
        for ($i = 30; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $dates[] = $date;

            $positiveData[] = SurveyResponse::whereDate('created_at', $date)->where('sentiment', 'positive')->count();
            $neutralData[] = SurveyResponse::whereDate('created_at', $date)->where('sentiment', 'neutral')->count();
            $negativeData[] = SurveyResponse::whereDate('created_at', $date)->where('sentiment', 'negative')->count();
        }

        return [
            'datasets' => [
                [
                    'label' => 'Positive',
                    'data' => $positiveData,
                    'backgroundColor' => '#22c55e',
                    'borderColor' => '#16a34a',
                ],
                [
                    'label' => 'Neutral',
                    'data' => $neutralData,
                    'backgroundColor' => '#facc15',
                    'borderColor' => '#f59e0b',
                ],
                [
                    'label' => 'Negative',
                    'data' => $negativeData,
                    'backgroundColor' => '#ef4444',
                    'borderColor' => '#dc2626',
                ],
            ],
            'labels' => $dates,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }
}

