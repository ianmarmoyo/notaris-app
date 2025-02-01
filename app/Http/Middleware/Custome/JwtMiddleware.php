<?php

namespace App\Http\Middleware\Custome;

use App\Traits\ResponseJson;
use Closure;
use Exception;
use Illuminate\Http\Request;
use PHPOpenSourceSaver\JWTAuth\Http\Middleware\BaseMiddleware;
use JWTAuth;
use Symfony\Component\HttpFoundation\Response;


class JwtMiddleware extends BaseMiddleware
{
    use ResponseJson;
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        try {
            $user = JWTAuth::parseToken()->authenticate();
        } catch (Exception $e) {
            if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenInvalidException) {
                return $this->responseUnauthorized('Token is Invalid');
            } else if ($e instanceof \Tymon\JWTAuth\Exceptions\TokenExpiredException) {
                return $this->responseUnauthorized('Token has Expired');
            } else {
                return $this->responseUnauthorized('Authorization Token not found');
            }
        }

        return $next($request);
    }
}
