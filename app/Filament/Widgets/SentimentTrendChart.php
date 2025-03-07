<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SurveyResponse;
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
        for ($i = 6; $i >= 0; $i--) {
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
                ],
                [
                    'label' => 'Neutral',
                    'data' => $neutralData,
                    'backgroundColor' => '#facc15',
                ],
                [
                    'label' => 'Negative',
                    'data' => $negativeData,
                    'backgroundColor' => '#ef4444',
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

