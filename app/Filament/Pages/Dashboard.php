<?php

namespace App\Filament\Pages;


use App\Filament\Widgets\SentimentTrendChart;
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

    }

}
