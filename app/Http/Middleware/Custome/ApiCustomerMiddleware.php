<?php

namespace App\Http\Middleware\Custome;

use App\Traits\ResponseJson;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiCustomerMiddleware
{
    use ResponseJson;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (auth('api')->user()->customer == null) {
            return $this->responseNotAcceptable('User belum mendaftar sebagai pelanggan');
        }
        return $next($request);
    }
}
