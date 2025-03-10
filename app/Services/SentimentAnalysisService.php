<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SentimentAnalysisService
{
    protected string $apiKey;
    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$this->apiKey}";
    }

    public function analyze(string $text): string
    {
        $response = Http::post($this->endpoint, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => "Analyze the sentiment of this text: '{$text}'. Respond only with 'positive', 'negative', or 'neutral'."]
                    ]
                ]
            ]
        ]);

        $data = $response->json();

        return $data['candidates'][0]['content']['parts'][0]['text'] ?? 'neutral';
    }
}
