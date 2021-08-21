<?php

namespace App\Http\Services;

use App\Models\Question;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class ExamService
{

    /**
     * Check wither user can enter the exam or not
     * @param string $level
     * @param string $category_id
     */
    public function canEnterExam(string $level, string $category_id){

        $requested_exam_config=config('exam.levels.'.$level);

        $last_exam=Auth::user()->exams()->where('question_category_id',$category_id)->orderBy('created_at','desc')->first();

        if($last_exam){
            $last_exam_config= config('exam.levels.'.$last_exam->level);

            //check if the exam finished
            if($last_exam->status=="done"){
                //check if user passed the exam or not
                if($last_exam->degree>=$last_exam_config['passing-degree']){
                    return  ["status"=>true,"message"=>__("exam.user can enter the exam")];
                }
                //check if user had hard restriction and wither he passed it or not
                else if($last_exam->degree<=$last_exam_config['hard-restriction-degree']&&($last_exam->created_at->addDays($last_exam_config['hard-restriction-period'])>Carbon::now())){
                    return  ["status"=>false,"message"=>__("exam.user still restricted")];
                }
                //check if user had restriction and wither he passed it or not
                else if($last_exam->degree<$last_exam_config['passing-degree']&&($last_exam->created_at->addDays($last_exam_config['restriction-period'])>Carbon::now())){
                    return  ["status"=>false,"message"=>__("exam.user still restricted")];
                }
                //User cleared his restriction and now eligible to take the exam again
                else{
                    return  ["status"=>true,"message"=>__("exam.user clear to take the exam")];
                }


            }
            //exam did not finish
            else {
                return  ["status"=>false,"message"=>__("exam.user already started an exam in this category")];
            }
        }
        //user did not enter the exam before
        else{
            return  ["status"=>true,"message"=>__("exam.user can enter the exam")];
        }

    }

    /**
     * Create
     * @param array $answers_data
     * @param Question $question
     * @return Question
     */
    public function createQuestions($level, $conditions)
    {
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
