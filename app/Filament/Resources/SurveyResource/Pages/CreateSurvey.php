<?php

namespace App\Filament\Resources\SurveyResource\Pages;

use App\Filament\Resources\SurveyResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateSurvey extends CreateRecord
{
    protected static string $resource = SurveyResource::class;




    protected function handleRecordCreation(array $data): Model
    {
        // Extract questions from data
        $questions = $data['questions'] ?? [];
        unset($data['questions']); // Remove questions from main survey data

        // Create the survey record
        $survey = static::getModel()::create($data);

        // Store each question and its answer options
        foreach ($questions as $question) {
            // Ensure 'question' key exists before inserting
            if (!isset($question['question_text']) || empty($question['question_text'])) {
                continue; // Skip this question if it's missing or empty
            }

            $answerOptions = $question['answer_options'] ?? [];
            unset($question['answer_options']); // Remove answer options before saving the question

            // Create the question record
            $questionModel = $survey->questions()->create([
                'question' => $question['question_text'],
                'type'     => $question['type'],
            ]);

            // Store answer options if any
            if (!empty($answerOptions)) {
                $formattedOptions = array_map(function ($option) {
                    return ['option_text' => $option['option']];
                }, $answerOptions);

                $questionModel->answerOptions()->createMany($formattedOptions);
            }
        }

        return $survey;
    }


    protected function getRedirectUrl(): string
    {
        return $this->getResource()::getUrl('index');
    }

}
