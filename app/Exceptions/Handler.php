<?php

namespace App\Exceptions;

use App\Support\ApiResponse;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;
use Throwable;

class Handler extends ExceptionHandler
{
    protected $dontReport = [
        AuthorizationException::class,
        HttpExceptionInterface::class,
        ModelNotFoundException::class,
        ValidationException::class,
    ];

    public function report(Throwable $exception)
    {
        parent::report($exception);
    }

    // Semua error (404, 405, 500, ...) dikembalikan dengan format yang sama dengan Accept
    public function render($request, Throwable $exception)
    {
        if ($exception instanceof HttpResponseException) {
            return $exception->getResponse();
        }

        if ($exception instanceof ModelNotFoundException) {
            return ApiResponse::make($request, null, 404, 'Data tidak ditemukan');
        }

        if ($exception instanceof HttpExceptionInterface) {
            $status = $exception->getStatusCode();
            $message = [404 => 'Endpoint tidak ditemukan', 405 => 'Method tidak diizinkan'][$status]
                ?? ($exception->getMessage() ?: 'HTTP error');
            return ApiResponse::make($request, null, $status, $message);
        }

        $message = env('APP_DEBUG', false) ? $exception->getMessage() : 'Terjadi kesalahan pada server';
        return ApiResponse::make($request, null, 500, $message);
    }
}
