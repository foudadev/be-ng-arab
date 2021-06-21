<?php

namespace App\Http\Services;

use App\Models\Question;

class ExamService {

    /**
     * Create
     * @param array $answers_data
     * @param Question $question
     * @return Question
     */
    public function createQuestions($level, $conditions) {
        $questions = null;

        if ($level == 'junior') {
            $questions = Question::where($conditions + ['level' => 'junior'])->take(22)->get();
        } elseif ($level == 'mid-senior') {
            $questions_junior = Question::where($conditions + ['level' => 'junior'])->take(10)->get();
            $questions_mid_senior = Question::where($conditions + ['level' => 'mid-senior'])->take(23)->get();
            $questions = $questions_junior->merge($questions_mid_senior);
        } elseif ($level == 'senior') {
            $questions_junior = Question::where($conditions + ['level' => 'junior'])->take(5)->get();
            $questions_mid_senior = Question::where($conditions + ['level' => 'mid-senior'])->take(10)->get();
            $questions_senior = Question::where($conditions + ['level' => 'senior'])->take(29)->get();
            $questions = $questions_junior->merge($questions_mid_senior);
            $questions = $questions->merge($questions_senior);
        } elseif ($level == 'expert') {
            $questions_mid_senior = Question::where($conditions + ['level' => 'mid-senior'])->take(5)->get();
            $questions_senior = Question::where($conditions + ['level' => 'senior'])->take(15)->get();
            $questions_expert = Question::where($conditions + ['level' => 'expert'])->take(35)->get();
            $questions = $questions_mid_senior->merge($questions_senior);
            $questions = $questions->merge($questions_expert);
        }

        return $questions->shuffle();
    }

}
