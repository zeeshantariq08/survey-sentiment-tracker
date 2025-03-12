<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class SentimentAnalysisGeminiService
{
    protected string $apiKey;
    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$this->apiKey}";
    }

    public function analyze(string $text): string
    {

        $decoded = json_decode($text, true);
        $answer = $decoded['answer'] ?? $text;
        $response = Http::post($this->endpoint, [
            'contents' => [
                [
                    'role' => 'user',
                    'parts' => [
                        ['text' => "Analyze the sentiment of this survey response: '{$answer}'.

                    - If the response is a number (1-5), classify as:
                      • 1-2 → 'negative'
                      • 3 → 'neutral'
                      • 4-5 → 'positive'

                    - If the response is a multiple-choice answer, classify sentiment accordingly.
                    - If the response is open-ended, interpret sentiment naturally.

                    🚨 Respond with ONLY ONE word: 'positive', 'negative', or 'neutral'. NOTHING ELSE."]
                    ]
                ]
            ]
        ]);

        $data = $response->json();

        return trim($data['candidates'][0]['content']['parts'][0]['text'] ?? null);
    }


}
