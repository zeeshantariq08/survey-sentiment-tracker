<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\ChartWidget;

class ResponseCountChart extends ChartWidget
{
    protected static ?string $heading = 'Response Count by Sentiment';
    protected static string $type = 'bar';
    protected static ?int $sort = 1;


    protected function getData(): array
    {
        $sentimentCounts = SurveyResponse::selectRaw("sentiment, COUNT(*) as count")
            ->groupBy('sentiment')
            ->pluck('count', 'sentiment')
            ->toArray();

        return [
            'datasets' => [
                [
                    'data' => array_values($sentimentCounts),
                    'backgroundColor' => ['#22c55e', '#facc15', '#ef4444'],
                    'borderColor' => ['#16a34a', '#d97706', '#d11f1f'],

                ]
            ],

            'labels' => array_keys($sentimentCounts),
        ];
    }

    protected function getType(): string
    {
        return self::$type;
    }
}