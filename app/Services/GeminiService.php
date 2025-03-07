<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Collection;

class GeminiService
{
    protected string $apiKey;
    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$this->apiKey}";
    }

    public function generateQuestions(string $topic): array
    {
        $apiKey = env('GEMINI_API_KEY');
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        $response = Http::post($endpoint, [
            'contents' => [
                ['parts' => [['text' => "Generate 5 survey questions about: $topic. Specify the question type ('open-ended', 'multiple-choice', 'scale') and provide answer options if applicable. Return a valid JSON array."]]]
            ]
        ]);

        $data = $response->json();

        if (empty($data) || isset($data['error'])) {
            \Log::error('Gemini API Error:', $data);
            return [];
        }

        $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Remove possible code block formatting from response
        $content = preg_replace('/^```json\s*|\s*```$/', '', trim($content));

        // Decode JSON
        $questions = json_decode($content, true);

        if (json_last_error() !== JSON_ERROR_NONE) {
            \Log::error('Invalid JSON response from Gemini API:', ['response' => $content]);
            return [];
        }

        return $questions;
    }

}
