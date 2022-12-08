<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class redirectIfLoggedIn
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
      if(Auth::check()) {
       if(Auth::user()->isAdmin()) {
         return redirect('/admin');
       } else {
         return redirect('/user');
       }
      } else {
        return $next($request);
      }
    }
}
