<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Question\QuestionAPIStoreFormRequest;
use App\Http\Requests\v1\Question\QuestionAPIUpdateFormRequest;
use App\Http\Resources\v1\QuestionResource;
use App\Models\Question;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = Question::where('status','active')->get();
        return response()->json(['questions' => QuestionResource::collection($users), 'status' => __("successful")]);
    }

    /**
     * Store a newly created resource in storage.
     * @param QuestionAPIStoreFormRequest $request
     * @bodyParam  question string required
     * @bodyParam  level enum in(junior,senior,expert) required
     * @bodyParam  status enum in(active,inactive) nullable
     * @bodyParam  question_category_id string required
     * @return JsonResponse
     */
    public function store(QuestionAPIStoreFormRequest $request)
    {
        $data = $request->validated();
        $question = Question::create(Arr::except($data,'answers'));
        if ($question)
            return response()->json(['question' => new QuestionResource($question), 'status' => __("successful")], 201);
        else
            return response()->json(['message' => __("Error has occurred")], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param Question $question
     * @return JsonResponse
     */
    public function show(Question $question)
    {
        return response()->json(['question' => new QuestionResource($question), 'status' => __("successful")]);
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
     * @return JsonResponse
     */
    public function update(QuestionAPIUpdateFormRequest $request, Question $question)
    {
        $data = $request->validated();
        $updated_question = $question->update(Arr::except($data,'answers'));
        if ($updated_question)
            return response()->json(['question' => new QuestionResource($updated_question), 'status' => __("successful")]);
        else
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
        $did_delete=$question->delete();
        if($did_delete)
            return response()->json(['status' => __("deleted successfully")]);
        else
            return response()->json(['message' => __("Error has occurred")], 422);
    }
}
