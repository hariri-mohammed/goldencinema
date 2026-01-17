<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ManagerAuthenticate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  ...$guards
     * @return mixed
     */
    public function handle(Request $request, Closure $next, ...$guards): Response
    {
        if (!Auth::guard('manager')->check()) {
            return redirect()->route('manager.login');
        }

        // if (!Auth::guard('admin')->check()) {
        //     return redirect()->route('admin_login');
        // }
        return $next($request);
    }
}
