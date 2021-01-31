<?php

namespace App\Http\Controllers\API\v1\Auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\v1\Auth\UserAPILoginFormRequest;
use App\Http\Requests\v1\Auth\UserAPIRegisterFormRequest;
use App\Http\Requests\v1\Auth\UserAPISocialLoginFormRequest;
use App\Models\User;
use App\Traits\AuthTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;


class AuthController extends Controller
{
    use AuthTrait;

    /**
     * Login user and create token
     * @param UserAPILoginFormRequest $request
     * @bodyParam  email string required
     * @bodyParam  password string required
     * @return JsonResponse
     */
    public function login(UserAPILoginFormRequest $request)
    {
        $data = $request->validated();
        $credentials = Arr::only($data, ['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json(['message' => __('user.Invalid_email_or_password')], 422);

        return $this->createToken($request->user());
    }

    /**
     * Sign up user and create token
     * @param UserAPIRegisterFormRequest $request
     * @bodyParam  name string required
     * @bodyParam  email string required
     * @bodyParam  password string required
     * @return JsonResponse
     */
    public function signup(UserAPIRegisterFormRequest $request): JsonResponse
    {
        $data = $request->validated();
        return $this->initiateSignup($data);
    }

    /**
     * Login or Sign up user using social login
     * @param UserAPISocialLoginFormRequest $request
     * @bodyParam  name string required
     * @bodyParam  email string required
     * @bodyParam  provider_id string required
     * @bodyParam  provider_type string required
     * @return JsonResponse
     */
    public function loginWithProvider(UserAPISocialLoginFormRequest $request): JsonResponse
    {
        $data = $request->validated();
        $user = User::where('provider_id', $data['provider_id'])->where('provider_name', $data['provider_type'])->first();
//        $user = $this->userRepository->findWhere(['provider_id' => $data['user_id'], 'provider_name' => $data['provider_type']])->first();
        if ($user) {
//            $user = $this->resendEmailVerification($user);
            return $this->createToken($user);
        } else {
            return $this->initiateSocialSignup($data);
        }
    }

    /**
     * Logout user (Revoke the token)
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json(['message' => __('Successfully logged out')]);
    }

}
