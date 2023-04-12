<?php

namespace App\Exceptions;

use App\Http\Resources\Common\ErrorResource;
use App\Http\Resources\Common\InvalidResource;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e, $request) {

            // if ($request->is('api/*')) {
            //     if ($e instanceof AccessDeniedException) {
            //         return new ErrorResource([
            //             'errors' => [
            //                 'message' => 'This action is unauthorized.',
            //             ], Response::HTTP_UNAUTHORIZED
            //         ]);
            //     }
            //     if ($e instanceof ValidationException) {
            //         return new InvalidResource($e->errors());
            //     }
            //     return new ErrorResource([
            //         'errors' => [
            //             'message' => $e->getMessage(),
            //             'class' => get_class($e),
            //             'file' => $e->getFile(),
            //             'line' => $e->getLine(),
            //         ]
            //     ]);
            // }
        });
    }
}
