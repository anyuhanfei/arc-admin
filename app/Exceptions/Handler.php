<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->reportable(function (Throwable $e) {
            //
        });
        $this->reportable(function(BusinessException $e){})->stop();
    }

    public function render($request, Throwable $exception){
        // 自定义错误异常抛出
        if($exception instanceof BusinessException){
            $message = $exception->getMessage();
            // 获取错误码
            $start = strpos($message, '[');
            $end = strpos($message, ']', $start);
            $error = substr($message, $start + 1, $end - $start - 1);
            // 将错误码从消息内容中删除
            $message = substr($message, 0, $start);
            // 返回错误信息
            return error($message, $error);
        }
        return parent::render($request, $exception);
    }
}
