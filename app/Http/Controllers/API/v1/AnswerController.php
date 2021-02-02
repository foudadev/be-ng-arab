<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Answer\AnswerAPIStoreFormRequest;
use App\Http\Requests\v1\Answer\AnswerAPIUpdateFormRequest;
use App\Http\Resources\v1\AnswerResource;
use App\Models\Answer;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AnswerController extends Controller
{


    /**
     * Store a newly created resource in storage.
     *
     * @param AnswerAPIStoreFormRequest $request
     * @return JsonResponse
     */
    public function store(AnswerAPIStoreFormRequest $request)
    {
        $data = $request->validated();
        $answer = Answer::create($data);
        if ($answer) {
            return response()->json(['answer' => new AnswerResource($answer), 'status' => __("main.successful")], 201);
        } else
            return response()->json(['message' => __("Error has occurred")], 422);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param AnswerAPIUpdateFormRequest $request
     * @param Answer $answer
     * @return JsonResponse
     */
    public function update(AnswerAPIUpdateFormRequest $request, Answer $answer)
    {
        $data = $request->validated();
        $updated_answer = $answer->update($data);
        if ($updated_answer) {
            return response()->json(['answer' => new AnswerResource($answer), 'status' => __("main.successful")], 201);
        } else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Answer $answer
     * @return JsonResponse
     */
    public function destroy(Answer $answer)
    {
        $did_delete = $answer->delete();
        if ($did_delete)
            return response()->json(['status' => __("main.deleted successfully")]);
        else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }
}
