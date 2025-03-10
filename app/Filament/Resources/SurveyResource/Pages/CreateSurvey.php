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
        $questions = $data['questions'] ?? [];
        unset($data['questions']); // Remove questions from main survey data

        $survey = static::getModel()::create($data);

        foreach ($questions as $question) {

            if (!isset($question['question_text']) || empty($question['question_text'])) {
                continue; // Skip this question if it's missing or empty
            }

            $answerOptions = $question['answer_options'] ?? [];
            unset($question['answer_options']); // Remove answer options before saving the question

            $questionModel = $survey->questions()->create([
                'question' => $question['question_text'],
                'type'     => $question['type'],
            ]);

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
