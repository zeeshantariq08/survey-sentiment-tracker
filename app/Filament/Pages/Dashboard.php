<?php

namespace App\Filament\Pages;


use App\Filament\Widgets\SentimentStackedBarChart;
use App\Filament\Widgets\SentimentScoreChart;
use App\Filament\Widgets\SentimentTrendChart;
use App\Filament\Widgets\SentimentDistributionChart;
use App\Filament\Widgets\SurveyFilterWidget;
use Filament\Pages\Dashboard as BasePage;

class Dashboard extends BasePage
{
    protected int|string|array $columnSpan = 'full';

    public function getColumns(): int|array
    {
        return 6;
    }

    public function getHeaderWidgets(): array
    {
        return [
            SurveyFilterWidget::class,
            SentimentDistributionChart::class,
            SentimentScoreChart::class,
            SentimentStackedBarChart::class,
            SentimentBubbleChart::class,
        ];
    }

}
