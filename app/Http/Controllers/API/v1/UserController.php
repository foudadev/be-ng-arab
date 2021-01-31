<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\UserAPIStoreFormRequest;
use App\Http\Requests\v1\User\UserAPIUpdateFormRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => UserResource::collection($users), 'status' => __("successful")]);
    }


    /**
     * Store a newly created resource in storage.
     * @param UserAPIStoreFormRequest $request
     * @bodyParam  name string required
     * @bodyParam  email string required
     * @bodyParam  password string required
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(UserAPIStoreFormRequest $request)
    {
        $data = $request->validated();
        $user = User::create($data);
        if ($user)
            return response()->json(['user' => new UserResource($user), 'status' => __("successful")], 201);
        else
            return response()->json(['message' => __("Error has occurred")], 422);
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(User $user)
    {
        return response()->json(['user' => new UserResource($user), 'status' => __("successful")]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UserAPIUpdateFormRequest $request
     * @param User $user
     * @bodyParam  name string required
     * @bodyParam  email string required
     * @bodyParam  password string required
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserAPIUpdateFormRequest $request, User $user)
    {
        $data = $request->validated();
        $user = $user->update($data);
        if ($user)
            return response()->json(['user' => new UserResource($user), 'status' => __("successful")]);
        else
            return response()->json(['message' => __("Error has occurred")], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(User $user)
    {
        $did_delete=$user->delete();
        if($did_delete)
            return response()->json(['status' => __("deleted successfully")]);
        else
            return response()->json(['message' => __("Error has occurred")], 422);
    }
}
