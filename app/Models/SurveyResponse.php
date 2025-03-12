<?php

namespace App\Models;

use App\Services\SentimentAnalysisGeminiService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($response) {
            $sentimentService = new SentimentAnalysisGeminiService();
            $response->sentiment = $sentimentService->analyze($response);
        });
    }


}

