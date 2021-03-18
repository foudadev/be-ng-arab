<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Question\QuestionAPIStoreFormRequest;
use App\Http\Requests\v1\Question\QuestionAPIUpdateFormRequest;
use App\Http\Resources\v1\QuestionResource;
use App\Http\Services\AnswerService;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    /**
     * @var AnswerService
     */
    protected AnswerService $answerService;


    /**
     * QuestionController constructor.
     * @param AnswerService $answerService
     */
    public function __construct(AnswerService $answerService)
    {
        $this->answerService = $answerService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = Question::all();
        return response()->json(['questions' => QuestionResource::collection($users), 'status' => __("successful")]);
    }

    /**
     * Store a newly created resource in storage.
     * @param QuestionAPIStoreFormRequest $request
     * @bodyParam  question string required
     * @bodyParam  level enum in(junior,senior,expert) required
     * @bodyParam  status enum in(active,inactive) nullable
     * @bodyParam  question_category_id string required
     * @bodyParam  answers array nullable
     * @return JsonResponse
     */
    public function store(QuestionAPIStoreFormRequest $request)
    {
        $data = $request->validated();
        $data['user_id']=Auth::id();
        $question = Question::create(Arr::except($data, 'answers'));
        if ($question) {
            if(array_key_exists("answers",$data))
                $this->answerService->createAndAssociate($data['answers'],$question);
            return response()->json(['question' => new QuestionResource($question), 'status' => __("main.successful")], 201);
        } else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return JsonResponse
     */
    public function show(Question $question)
    {
        return response()->json(['question' => new QuestionResource($question), 'status' => __("main.successful")]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param QuestionAPIUpdateFormRequest $request
     * @param Question $question
     * @bodyParam  question string required
     * @bodyParam  level enum in(junior,senior,expert) required
     * @bodyParam  status enum in(active,inactive) nullable
     * @bodyParam  resource string nullable
     * @bodyParam  question_category_id string required
     * @bodyParam  answers array nullable
     * @return JsonResponse
     */
    public function update(QuestionAPIUpdateFormRequest $request, Question $question)
    {
        $data = $request->validated();
        $updated_question = $question->update(Arr::except($data, 'answers'));
        if ($updated_question) {
            if (array_key_exists("answers", $data))
                $this->answerService->reinsertAllAnswers($data['answers'], $question);
            return response()->json(['question' => new QuestionResource($question), 'status' => __("main.successful")]);
        } else
            return response()->json(['message' => __("Error has occurred")], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Question $question
     * @return JsonResponse
     */
    public function destroy(Question $question)
    {
        $did_delete = $question->delete();
        if ($did_delete)
            return response()->json(['status' => __("main.deleted successfully")]);
        else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }
}
