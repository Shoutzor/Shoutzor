<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [//
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
        'api_token'
    ];

    /**
     * Report or log an exception.
     *
     * @param  Throwable  $exception
     * @return void
     *
     * @throws Throwable
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  Request  $request
     * @param  Throwable  $exception
     * @return Response
     *
     * @throws Throwable
     */
    public function render($request, Throwable $exception)
    {
        if($request->is('api/*')) {
            if($exception instanceof NotFoundHttpException) {
                return response()->json([
                    'message' => 'The requested page was not found'
                ], 404);
            }

            if(config('app.debug') == false) {
                return response()->json([
                    'message' => 'a server error occurred, check the log for more information'
                ], 500);
            }

            return response()->json([
                'message' => 'a server error occurred, check the log or response JSON for more information',
                'exception' => $exception
            ], 500);
        }
        else {
            return parent::render($request, $exception);
        }
    }
}
