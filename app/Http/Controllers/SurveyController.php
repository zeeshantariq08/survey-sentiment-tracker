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
        $member = auth()->user(); // Get the logged-in member

        // Fetch assigned surveys with their status using Eloquent
        $surveys = SurveyAssignment::with('survey') // Load related survey details
        ->where('member_id', $member->id)
            ->get();

        return view('member.dashboard', compact('surveys'));
    }


    public function show()
    {
        $survey = Survey::whereHas('questions', function ($query) {
            $query->whereHas('answerOptions');
        })
            ->with(['questions.answerOptions']) // Eager load questions & answer options
            ->first();

        if (!$survey) {
            return redirect()->back()->with('error', 'No surveys available.');
        }
//        dd($survey->toArray());
//
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
