<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof UserNotFoundException) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], $exception->getCode());
        }

        if ($exception instanceof UserCreationException) {
            return response()->json([
                'error' => $exception->getMessage(),
            ], $exception->getCode());
        }

        return parent::render($request, $exception);
    }
}
