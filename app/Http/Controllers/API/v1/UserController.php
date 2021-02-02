<?php

namespace App\Http\Controllers\API\v1;

use App\Http\Controllers\Controller;
use App\Http\Requests\v1\User\UserAPIStoreFormRequest;
use App\Http\Requests\v1\User\UserAPIUpdateFormRequest;
use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     * @return JsonResponse
     */
    public function index()
    {
        $users = User::all();
        return response()->json(['users' => UserResource::collection($users), 'status' => __("main.successful")]);
    }


    /**
     * Store a newly created resource in storage.
     * @param UserAPIStoreFormRequest $request
     * @bodyParam  name string required
     * @bodyParam  email string required
     * @bodyParam  password string required
     * @return JsonResponse
     */
    public function store(UserAPIStoreFormRequest $request)
    {
        $data = $request->validated();
        $data['password']=Hash::make($data['password']);
        $user = User::create($data);
        if ($user)
            return response()->json(['user' => new UserResource($user), 'status' => __("main.successful")], 201);
        else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }

    /**
     * Display the specified resource.
     * @param User $user
     * @return JsonResponse
     */
    public function show(User $user)
    {
        return response()->json(['user' => new UserResource($user), 'status' => __("main.successful")]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param UserAPIUpdateFormRequest $request
     * @param User $user
     * @bodyParam  name string required
     * @bodyParam  email string required
     * @bodyParam  password string required
     * @return JsonResponse
     */
    public function update(UserAPIUpdateFormRequest $request,User $user)
    {
        $data = $request->validated();
        if(array_key_exists('password',$data))
        $data['password']= Hash::make($data['password']);
        $did_update = $user->update($data);
        if ($did_update)
            return response()->json(['user' => new UserResource($user), 'status' => __("main.successful")]);
        else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param User $user
     * @return JsonResponse
     */
    public function destroy(User $user)
    {
        $did_delete=$user->delete();
        if($did_delete)
            return response()->json(['status' => __("main.deleted successfully")]);
        else
            return response()->json(['message' => __("main.Error has occurred")], 422);
    }
}
