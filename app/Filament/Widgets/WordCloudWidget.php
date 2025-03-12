<?php

namespace App\Filament\Widgets;

use App\Models\SurveyResponse;
use Filament\Widgets\Widget;
use Illuminate\Support\Str;

class WordCloudWidget extends Widget
{
    protected static ?string $heading = 'Word Cloud (Top Words in Responses)';
    protected static string $view = 'filament.widgets.word-cloud-widget';
    protected static ?int $sort = 4;

    public static function canSpanColumns(): bool
    {
        return true;
    }

    public function getData(): array
    {
        $words = SurveyResponse::pluck('answer')->flatMap(fn($text) => explode(' ', Str::lower($text)))
            ->filter(fn($word) => strlen($word) > 3)
            ->countBy()
            ->sortDesc()
            ->take(10);

        return ['words' => $words];
    }
}