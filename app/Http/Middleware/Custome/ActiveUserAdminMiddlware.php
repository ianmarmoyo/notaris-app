<?php

namespace App\Http\Middleware\Custome;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ActiveUserAdminMiddlware
{
  /**
   * Handle an incoming request.
   *
   * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
   */
  public function handle(Request $request, Closure $next): Response
  {
    // dd(Auth::guard('admin')->user()->is_active);
    if (Auth::guard('admin')->user()->is_active === 'inactive') {
      return abort(401, 'User is inactive');
    }
    return $next($request);
  }
}
