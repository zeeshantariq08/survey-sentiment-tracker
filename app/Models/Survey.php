<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Survey extends Model
{
    use HasFactory;

    protected $fillable = ['title', 'description'];

    // Relationship: A survey has many questions
    public function questions()
    {
        return $this->hasMany(SurveyQuestion::class);
    }


    public function members()
    {
        return $this->belongsToMany(Member::class, 'survey_assignments', 'survey_id', 'member_id')->withTimestamps();
    }
}

