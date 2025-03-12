<?php

namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveyAssignment;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;

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
        if (!$survey->questions()->whereHas('answerOptions')->exists()) {
            return redirect()->back()->with('error', 'This survey does not have valid questions.');
        }

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

        SurveyAssignment::where('survey_id', $survey->id)
            ->where('member_id', auth()->user()->id)
            ->update(['status' => 'completed']);

        return redirect()->route('member.dashboard')->with('success', 'Survey submitted successfully!');
    }
}
