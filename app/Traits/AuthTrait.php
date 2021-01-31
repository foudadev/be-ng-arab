<?php
namespace App\Traits;

use App\Http\Resources\v1\UserResource;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
trait AuthTrait{

    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function initiateSignup(array $data): JsonResponse
    {
        $data['password']=Hash::make($data['password']);
        $user=User::create($data);
//        $user = $this->registerUserService->register(Arr::except($data, ['type', 'firebase_token', 'platform']));
//        $this->resendEmailVerification($user);
        return $this->createToken($user, __('user.Signed up successfully'), 201);
    }

    /**
     * @param array $data
     * @return JsonResponse
     */
    protected function initiateSocialSignup(array $data): JsonResponse
    {
        if (!$data['email'])
            return response()->json(['message' => __('user.Apple sign in error')], 422);

        $user = User::where('email', $data['email'])->first();
        if ($user)
            return response()->json(['message' => __('user.Email found')], 422);

        return $this->initiateSignup(Arr::except($data, ['provider_id', 'provider_type']));
    }

    /**
     * create Token
     *
     * @param User $user
     * @param string $message
     * @param int $status_code
     * @param $device
     * @return JsonResponse
     */
    public function createToken(User $user, $message = "", $status_code = 200, $device = null): JsonResponse
    {
        $tokenResult = $user->createToken('Personal Access Token');
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addMonths(3);
        $token->save();
        return response()->json(['status' => 'success', 'message' => $message, 'access_token' => $tokenResult->accessToken, 'user' => new UserResource($user), 'token_type' => 'Bearer', 'device' => $device, 'expires_at' => Carbon::parse($tokenResult->token->expires_at)->toDateTimeString()], $status_code);
    }


//todo:uncomment the implementation of this method in case of mail verification and implement MustVerifyEmail in User Model

//    /**
//     * @param User $user
//     * @return User
//     */
//    protected function resendEmailVerification(User $user): User
//    {
//        if (!$user->hasVerifiedEmail()) {
//            $user = $user->update(['vcode' => rand(1000, 9999)]);
//            $user->notify(new SendEmailVerification($this->vcode));
//        }
//        return $user;
//    }

}
