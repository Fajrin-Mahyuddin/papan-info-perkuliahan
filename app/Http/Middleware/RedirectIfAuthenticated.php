<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // if (Auth::guard($guard)->check()) {
        //     return redirect('/home');
        // }

        if(Auth::check()) {
            if($request->user()->level === 'admin') {
                return redirect('admin');
            } elseif($request->user()->level === 'dosen') {
                return redirect('dosen');
            }
        }

        return $next($request);
    }
}
