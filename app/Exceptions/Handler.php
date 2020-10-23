<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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
        if($exception instanceof HttpException){

            return $this->handle($request,$exception);

        }else{

            return parent::render($request, $exception);

        }
    }

    // 新添加的handle函数
    public function handle($request, HttpException $e)
    {
        // 只处理自定义的HttpException异常
        if ($e instanceof HttpException) {

            $result = [
                "code" => $e->errorCode,
                "msg" => $e->errorMsg,
            ];

            return response()->json($result);

        }

        return parent::render($request, $e);
    }
}
