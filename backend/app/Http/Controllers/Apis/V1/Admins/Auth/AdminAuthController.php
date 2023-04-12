<?php

namespace App\Http\Controllers\Apis\V1\Admins\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Common\SuccessResource;
use App\Models\User;
use App\Modules\ApplicationLogger;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * ユーザー新規登録
     *
     * @param Request $request
     * @return SuccessResource
     */
    public function register(Request $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);

        if (User::where('email', $request->email)->exists()) {
            return response()->json(['error' => "User already register"], 409);
        }
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'role' => User::ADMIN,
            'password' => Hash::make($request->password)
        ]);
        $token = $user->createToken($request->token_name)->plainTextToken;

        $logger->success();
        return new SuccessResource(['token' => $token]);
    }

    /**
     * トークン認証ログイン
     * 1emailにつき1つのトークンを発行する仕様
     *
     * @param Request $request
     * @return SuccessResource
     * @throws Exception
     */
    public function login(Request $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        try {
            if (!Auth::attempt($credentials)) {
                throw ValidationException::withMessages([
                    'email' => 'The provided credentials are incorrect.',
                ]);
            }
            $user = User::where('email', $request->email)->first();
            $user->tokens()->where('name', $request->email)->delete();
            $token = $request->user()->createToken($request->email)->plainTextToken;
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new SuccessResource(['token' => $token]);
    }

    /**
     * ログアウト
     *
     * @param Request $request
     * @return SuccessResource
     * @throws Exception
     */
    public function logout(Request $request): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            /** @var \App\Models\MyUserModel $user **/
            $user = Auth::guard('sanctum')->user();
            $user->currentAccessToken()->delete();
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new SuccessResource();
    }

    /**
     * 自身のアカウント情報を取得する
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function me(): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);
        try {
            $user = Auth::guard('sanctum')->user();
            $result = [
                'id' => $user->id,
                'email' => $user->email,
                'role' => $user->role,
            ];
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new SuccessResource($result);
    }
}
