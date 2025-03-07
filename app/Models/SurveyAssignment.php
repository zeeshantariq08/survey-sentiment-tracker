<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveyAssignment extends Model
{
    use HasFactory;

    protected $fillable = ['survey_id', 'member_id', 'status'];

    public function survey()
    {
        return $this->belongsTo(Survey::class);
    }

    public function member()
    {
        return $this->belongsTo(Member::class);
    }
}
