<?php

namespace App\Console\Commands;

use App\Models\SurveyResponse;
use App\Services\SentimentAnalysisService;
use Illuminate\Console\Command;

class ProcessSurveySentiment extends Command
{
    protected $signature = 'survey:process-sentiment {response_id?}';
    protected $description = 'Process sentiment analysis for survey responses';

    /**
     * Execute the console command.
     */
    public function handle(SentimentAnalysisService $sentimentService)
    {
        // Get the optional response_id argument
        $responseId = $this->argument('response_id');

        // Query responses to process
        $query = SurveyResponse::whereNull('sentiment');

        if ($responseId) {
            $query->where('id', $responseId);
        }

        $responses = $query->whereNull('sentiment')->get();

        if ($responses->isEmpty()) {
            $this->info('No survey responses found that need sentiment analysis.');
            return;
        }

        $this->info("Processing " . $responses->count() . " responses...");

        foreach ($responses as $response) {
            $sentiment = $sentimentService->analyze($response->answer);
            if(!$sentiment) {
                $this->error("Failed to analyze sentiment for response ID {$response->id}. Text: {$response->answer}");
                continue;
            }
            $response->update(['sentiment' => $sentiment]);

            $this->info("Updated response ID {$response->id}. Text {$response->answer} => with sentiment: {$sentiment}");
        }

        $this->info("Sentiment processing completed!");
    }
}
