<?php

namespace App\Http\Services;



use App\Models\Question;
use Illuminate\Support\Facades\Auth;

class AnswerService
{


    /**
     * Create
     * @param array $answers_data
     * @param Question $question
     * @return Question
     */
    public function createAndAssociate(Array $answers_data,Question $question){
        $question->answers()->createMany($answers_data);
        return $question;
    }



    /**
     * Create
     * @param array $answers_data
     * @param Question $question
     * @return Question
     */
    public function reinsertAllAnswers(Array $answers_data,Question $question){
        $question->answers()->delete();
        $question->answers()->createMany($answers_data);
        return $question;
    }


}
