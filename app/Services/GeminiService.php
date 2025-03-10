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

    public function generateQuestions(string $title, string $description): array
    {
        $apiKey = env('GEMINI_API_KEY');
        $endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$apiKey}";

        // Construct the prompt with both title & description
        $prompt = "Generate 5 diverse survey questions based on the following details:

    Title: $title
    Description: $description

    Each question should include:
    - A 'question_text'
    - A 'type' ('open-ended', 'multiple-choice', 'scale')
    - If 'multiple-choice' or 'scale', provide 'answer_options' (at least 3 options).
    Return a valid JSON array.";

        $response = Http::post($endpoint, [
            'contents' => [
                ['parts' => [['text' => $prompt]]]
            ]
        ]);

        $data = $response->json();

        if (empty($data) || isset($data['error'])) {
            \Log::error('Gemini API Error:', $data);
            return [];
        }

        $content = $data['candidates'][0]['content']['parts'][0]['text'] ?? '';

        // Remove potential JSON formatting artifacts
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
