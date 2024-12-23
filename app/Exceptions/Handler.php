<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
        AuthorizationException::class,
        HttpException::class,
        ModelNotFoundException::class,
        ValidationException::class,
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
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Exception  $exception
     * @return void
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Illuminate\Http\Response
     */
    public function render($request, Exception $e)
    {
         //处理自定义的APIException异常
        if($e instanceof ApiException) {
            $response=get_api_response($e->getCode(),$e->getMessage());
            return  response()->json($response);
        }else if($e instanceof NotFoundHttpException){
            if($request->ajax() || is_postman())  TEA('414');
            return get_api_response(404, $e->getMessage());
            // return parent::render($request, $e);
        }else if($e instanceof ApiParamException){
            $response = get_api_exception_response($e->getMessage());
            return response()->json($response);
        } else {
            $response = get_api_response(501, $e->getMessage());
            return  response()->json($response);
        }

        return parent::render($request, $e);

        // return parent::render($request, $e);
    }
}
