<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class GeminiService
{
    protected string $apiKey;
    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey = config('services.gemini.api_key');
        $this->endpoint = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.0-flash:generateContent?key={$this->apiKey}";
    }

    public function generateQuestions(string $title, string $description): array
    {
        $prompt = "Generate 5 diverse survey questions based on the following details:

Title: $title
Description: $description

Each question should include:
- A 'question_text'
- A 'type' ('open-ended', 'multiple-choice', 'scale')
- If 'multiple-choice' or 'scale', provide 'answer_options' (at least 3 options).
Return a valid JSON array.";

        try {
            $response = Http::post($this->endpoint, [
                'contents' => [
                    ['parts' => [['text' => $prompt]]]
                ]
            ])->throw();

            $data = $response->json();

            if (!isset($data['candidates'][0]['content']['parts'][0]['text'])) {
                Log::error('Invalid API response format', ['response' => $data]);
                return [];
            }

            $content = $data['candidates'][0]['content']['parts'][0]['text'];

            // Remove triple backticks and trim whitespace
            $content = trim(preg_replace('/^```json\s*|\s*```$/', '', $content));

            $questions = json_decode($content, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                Log::error('Invalid JSON response from Gemini API', ['response' => $content]);
                return [];
            }

            return $questions;
        } catch (RequestException $e) {
            Log::error('Gemini API Request Failed', [
                'message' => $e->getMessage(),
                'response' => $e->response?->body(),
            ]);
            return [];
        }
    }
}