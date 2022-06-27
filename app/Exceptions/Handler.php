<?php

namespace App\Exceptions;

use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
use Throwable;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
        'api_token'
    ];

    /**
     * Render an exception into an HTTP response.
     *
     * @param Request $request
     * @param Throwable $e
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $e): Response
    {
        if ($request->is('api/*')) {
            if ($e instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'The requested page was not found'
                ], 404);
            }

            if ($e instanceof UnauthorizedHttpException || $e instanceof AuthorizationException) {
                return response()->json([
                    'message' => 'You do not have the required permissions',
                ], 403);
            }

            if (!config('app.debug')) {
                return response()->json([
                    'message' => 'a server error occurred, check the log for more information'
                ], 500);
            }

            return response()->json([
                'message' => 'a server error occurred, check the log or response JSON for more information',
                'exception' => $e
            ], 500);
        } else {
            return parent::render($request, $e);
        }
    }
}
