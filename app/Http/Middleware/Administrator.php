<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Administrator
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
      if(Auth::check()) {
        if(Auth::user()->isAdmin()) {
          return $next($request);
        } else {
          return response("Unauthorized", 419);
        }
      } else {
        return redirect('/login');
      }
    }
}