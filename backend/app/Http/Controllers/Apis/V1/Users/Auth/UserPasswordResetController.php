<?php

namespace App\Http\Controllers\Apis\V1\Users\Auth;

use App\Http\Controllers\Controller;
use App\Http\Resources\Common\SuccessResource;
use App\Http\Resources\Common\CreatedResource;
use App\Models\User;
use App\Modules\ApplicationLogger;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Users\Auth\SendPasswordResetMailRequest;
use Illuminate\Support\Facades\Password;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpException;

class UserPasswordResetController extends Controller
{
    /**
     * パスワードリセット用のメールを送信する
     *
     * @param SendPasswordResetMailRequest $request
     * @return CreatedResource
     * @throws Exception
     */
    public function sendMail(SendPasswordResetMailRequest $request): CreatedResource
    {
        $logger = new ApplicationLogger(__METHOD__);

        try {
            $status = Password::sendResetLink($request->only('email'));

            if ($status !== Password::RESET_LINK_SENT) {
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    trans($status)
                );
            }
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new CreatedResource();
    }

    /**
     * パスワードリセットを行う
     *
     * @return SuccessResource
     * @throws Exception
     */
    public function reset(): SuccessResource
    {
        $logger = new ApplicationLogger(__METHOD__);

        try {
            $credentials = request()->only(['email', 'token', 'password']);

            $status = Password::reset($credentials, function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            });

            if ($status !== Password::PASSWORD_RESET) {
                throw new HttpException(
                    Response::HTTP_UNPROCESSABLE_ENTITY,
                    trans($status)
                );
            }
        } catch (\Exception $e) {
            $logger->exception($e);
            throw $e;
        }
        $logger->success();
        return new SuccessResource();
    }
}