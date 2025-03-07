<?php

namespace App\Filament\Pages;


use App\Filament\Widgets\SentimentCategoryChart;
use App\Filament\Widgets\SentimentScoreChart;
use App\Filament\Widgets\SentimentTrendChart;
use App\Filament\Widgets\SentimentDistributionChart;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected int|string|array $columnSpan = 'full';

    public function getColumns(): int|array
    {
        return 6;
    }

    public function getWidgets(): array
    {
        return [
            SentimentDistributionChart::class,
            SentimentTrendChart::class,
            SentimentScoreChart::class,
            SentimentCategoryChart::class,
        ];
    }

}
