<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAnswerOption extends Model
{
    use HasFactory;

    protected $guarded = [];

    // Relationship: An answer option belongs to a question
    public function question()
    {
        return $this->belongsTo(SurveyQuestion::class,'survey_question_id');
    }
}

