<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAssignment;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{

    public function dashboard()
    {
        $member = auth()->user();

        $surveys = SurveyAssignment::with('survey')
        ->where('member_id', $member->id)
            ->get();

        return view('member.dashboard', compact('surveys'));
    }


    public function show(Survey $survey)
    {
        // Ensure the survey has questions with answer options
        if (!$survey->questions()->whereHas('answerOptions')->exists()) {
            return redirect()->back()->with('error', 'This survey does not have valid questions.');
        }

        // Eager load related data
        $survey->load(['questions.answerOptions']);

        return view('survey.show', compact('survey'));
    }


    public function store(Request $request, Survey $survey)
    {


        $request->validate([
            'answers' => 'required|array',
        ]);

        foreach ($request->answers as $key=> $response) {
            SurveyResponse::create([
                'survey_id' => $survey->id,
                'question_id' => $key,
                'answer' => $response,
            ]);
        }

        return redirect()->back()->with('success', 'Survey submitted successfully!');
    }
}
