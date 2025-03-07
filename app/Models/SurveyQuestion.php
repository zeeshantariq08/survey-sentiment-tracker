<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyQuestion extends Model
{
    use HasFactory;

    protected $guarded = [];


    // Relationship: A question belongs to a survey
    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    // Relationship: A question has many answer options
    public function answerOptions()
    {
        return $this->hasMany(SurveyAnswerOption::class, 'survey_question_id');
    }
}

