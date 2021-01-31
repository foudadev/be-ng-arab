<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\QuestionCategory\QuestionCategoryAPIStoreFormRequest;
use App\Http\Requests\v1\QuestionCategory\QuestionCategoryAPIUpdateFormRequest;
use App\Http\Resources\v1\QuestionCategoryResource;
use App\Models\Question;
use App\Models\QuestionCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = Question::where('status','active')->get();
        return response()->json(['categories' => QuestionCategoryResource::collection($users), 'status' => __("successful")]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param QuestionCategoryAPIStoreFormRequest $request
     * @bodyParam  name string required
     * @bodyParam  description string nullable
     * @bodyParam  status enum in(active,inactive) nullable
     * @return JsonResponse
     */
    public function store(QuestionCategoryAPIStoreFormRequest $request)
    {
        $data = $request->validated();
        $category = QuestionCategory::create($data);
        if ($category)
            return response()->json(['category' => new QuestionCategoryResource($category), 'status' => __("successful")], 201);
        else
            return response()->json(['message' => __("Error has occurred")], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param QuestionCategory $questionCategory
     * @return JsonResponse
     */
    public function show(QuestionCategory $questionCategory)
    {
        return response()->json(['category' => new QuestionCategoryResource($questionCategory), 'status' => __("successful")]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionCategoryAPIUpdateFormRequest $request
     * @param QuestionCategory $questionCategory
     * @return JsonResponse
     * @bodyParam  name string required
     * @bodyParam  description string nullable
     * @bodyParam  status enum in(active,inactive) nullable
     */
    public function update(QuestionCategoryAPIUpdateFormRequest $request, QuestionCategory $questionCategory)
    {
        $data = $request->validated();
        $updated_category = $questionCategory->update($data);
        if ($updated_category)
            return response()->json(['category' => new QuestionCategoryResource($updated_category), 'status' => __("successful")]);
        else
            return response()->json(['message' => __("Error has occurred")], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param QuestionCategory $questionCategory
     * @return JsonResponse
     */
    public function destroy(QuestionCategory $questionCategory)
    {
        $did_delete=$questionCategory->delete();
        if($did_delete)
            return response()->json(['status' => __("deleted successfully")]);
        else
            return response()->json(['message' => __("Error has occurred")], 422);
    }
}
