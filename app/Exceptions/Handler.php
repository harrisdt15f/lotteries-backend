<?php

namespace App\Exceptions;

use App\Lib\T;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        //
    ];

    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    public function report(Exception $exception)
    {
        if (app()->bound('sentry') && $this->shouldReport($exception)) {
            app('sentry')->captureException($exception);
        }

        // 通知到相关组
        $msg    = $exception->getMessage();
        $file   = $exception->getFile();
        $line   = $exception->getLine();

        $text = $file . "\r\n";
        $text .= $line . "\r\n";
        $text .= $msg . "\r\n";

        T::exceptionNotice($text);
        parent::report($exception);
    }

    public function render($request, Exception $exception)
    {
        return parent::render($request, $exception);
    }
}
