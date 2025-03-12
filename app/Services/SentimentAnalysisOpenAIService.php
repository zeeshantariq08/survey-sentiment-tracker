<?php

namespace App\Services;

use Illuminate\Http\Client\RequestException;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SentimentAnalysisOpenAIService
{
    protected string $apiKey;
    protected string $endpoint;

    public function __construct()
    {
        $this->apiKey = config('services.openai.api_key');
        $this->endpoint = "https://api.openai.com/v1/chat/completions";
    }

    public function analyze(string $text): string|null
    {
        $decoded = json_decode($text, true);
        $answer = $decoded['answer'] ?? $text;

        $prompt = "Analyze the sentiment of this survey response: '{$answer}'.

- If the response is a number (1-5), classify as:
  • 1-2 → 'negative'
  • 3 → 'neutral'
  • 4-5 → 'positive'

- If the response is a multiple-choice answer, classify sentiment accordingly.
- If the response is open-ended, interpret sentiment naturally.

🚨 Respond with ONLY ONE word: 'positive', 'negative', or 'neutral'. NOTHING ELSE.";

        try {
            $response = Http::withHeaders([
                'Authorization' => "Bearer {$this->apiKey}",
                'Content-Type' => 'application/json',
            ])->post($this->endpoint, [
                'model' => 'gpt-4-turbo', // Use 'gpt-3.5-turbo' for lower cost
                'messages' => [['role' => 'user', 'content' => $prompt]],
                'temperature' => 0,
                'max_tokens' => 10,
            ])->throw();
            $data = $response->json();
            return trim($data['choices'][0]['message']['content']);

            if (!isset($data['choices'][0]['message']['content'])) {
                Log::error('Invalid API response format', ['response' => $data]);
                return null;
            }

            return trim($data['choices'][0]['message']['content']);
        } catch (RequestException $e) {
            Log::error('ChatGPT API Request Failed', [
                'message' => $e->getMessage(),
                'response' => $e->response?->body(),
            ]);
            return null; // Default fallback
        }
    }
}