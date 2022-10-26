<?php

namespace App\Helpers\JSend\Traits;

use Illuminate\Support\Arr;
use Illuminate\Validation\ValidationException;
use Throwable;

trait JSendExceptionFormatter
{
    protected function invalidJson($request, ValidationException $exception)
    {
        return jsend()->fail()->errors($exception->errors())->get($exception->status);
    }

    protected function prepareJsonResponse($request, Throwable $e)
    {
        $message = 'Server Error';

        if (config('app.debug') || $this->isHttpException($e)) {
            $message = $e->getMessage();
        }

        $errors = config('app.debug') ? [
            'exception' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => collect($e->getTrace())->map(function ($trace) {
                return Arr::except($trace, ['args']);
            })->all(),
        ] : [];

        return jsend()
            ->error()
            ->errors($errors)
            ->code($e->getCode())
            ->extraHeaders($this->isHttpException($e) ? $e->getHeaders() : [])
            ->get($this->isHttpException($e) ? $e->getStatusCode() : 500);
    }
}
