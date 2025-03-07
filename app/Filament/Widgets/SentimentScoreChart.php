<?php

namespace App\Filament\Widgets;

use Filament\Widgets\ChartWidget;
use App\Models\SurveyResponse;
use Illuminate\Support\Carbon;

class SentimentScoreChart extends ChartWidget
{
    protected static ?string $heading = 'Sentiment Score Changes';

    protected function getData(): array
    {
        $dates = [];
        $scores = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i)->toDateString();
            $dates[] = $date;

            $score = SurveyResponse::whereDate('created_at', $date)
                ->selectRaw('SUM(CASE WHEN sentiment = "positive" THEN 1 WHEN sentiment = "negative" THEN -1 ELSE 0 END) as score')
                ->value('score') ?? 0;

            $scores[] = $score;
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
}
