<?php

namespace App\Models;

use App\Services\SentimentAnalysisService;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyResponse extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'question_id', 'answer', 'sentiment'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    public static function boot()
    {
        parent::boot();

        static::creating(function ($response) {
            $sentimentService = new SentimentAnalysisService();
            $response->sentiment = $sentimentService->analyze($response);
        });
    }


}

