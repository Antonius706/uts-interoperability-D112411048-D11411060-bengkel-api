<?php

namespace App\Http\Middleware;

use App\Support\ApiResponse;
use Closure;
use Illuminate\Http\Request;

class BasicAuthMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $user = (string) $request->getUser();
        $pass = (string) $request->getPassword();

        $validUser = (string) env('API_USERNAME', 'admin');
        $validPass = (string) env('API_PASSWORD', 'bengkel123');

        if ($user === '' || !hash_equals($validUser, $user) || !hash_equals($validPass, $pass)) {
            return ApiResponse::make(
                $request,
                null,
                401,
                'Unauthorized: username atau password salah',
                ['WWW-Authenticate' => 'Basic realm="Bengkel API"']
            );
        }

        return $next($request);
    }
}
