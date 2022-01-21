<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Throwable  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof NotFoundHttpException) {
            if ($request->is('api/*')) {
                $data = [
                    "status"  => 404,
                    "success" => false,
                    "message" => "url not found"
                ];
                return response()->json($data);
            }
        }

        if($exception instanceof MethodNotAllowedHttpException){
            if ($request->is('api/*')) {
                $data = [
                    "status"  => 401,
                    "success" => false,
                    "message" => "inavlid method"
                ];
                return response()->json($data);
            }
        }

        if($exception instanceof AuthenticationException){
            if ($request->is('api/*')) {
                $data = [
                    "status"  => 401,
                    "success" => false,
                    "message" => "unathencticated user"
                ];
                return response()->json($data);
            }
        }
        return parent::render($request, $exception);
    }
}
