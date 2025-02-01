<?php

namespace App\Http\Middleware\Custome;

use App\Traits\ResponseJson;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiDriverMiddleware
{
    use ResponseJson;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api')->user()->driver == null) {
            return $this->responseNotAcceptable('User belum mendaftar sebagai driver');
        }
        return $next($request);
    }
}
