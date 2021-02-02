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
use Illuminate\Support\Facades\Auth;

class QuestionCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index()
    {
        $users = QuestionCategory::where('status','active')->get();
        return response()->json(['categories' => QuestionCategoryResource::collection($users), 'status' => __("main.successful")]);
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
            return response()->json(['category' => new QuestionCategoryResource($category), 'status' => __("main.successful")], 201);
        else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }

    /**
     * Display the specified resource.
     *
     * @param QuestionCategory $category
     * @return JsonResponse
     */
    public function show(QuestionCategory $category)
    {
        return response()->json(['category' => new QuestionCategoryResource($category), 'status' => __("main.successful")]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param QuestionCategoryAPIUpdateFormRequest $request
     * @param QuestionCategory $category
     * @return JsonResponse
     * @bodyParam  name string required
     * @bodyParam  description string nullable
     * @bodyParam  status enum in(active,inactive) nullable
     */
    public function update(QuestionCategoryAPIUpdateFormRequest $request, QuestionCategory $category)
    {
        $data = $request->validated();
        $did_update = $category->update($data);
        if ($did_update)
            return response()->json(['category' => new QuestionCategoryResource($category), 'status' => __("main.successful")]);
        else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param QuestionCategory $category
     * @return JsonResponse
     */
    public function destroy(QuestionCategory $category)
    {
        $did_delete=$category->delete();
        if($did_delete)
            return response()->json(['status' => __("main.deleted successfully")]);
        else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }
}
