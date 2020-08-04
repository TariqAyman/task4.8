<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use App\Support\ApiHelper;
use Closure;
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
    public function handle($request, Closure $next, $guard = null)
    {
        switch ($guard) {
            case 'user':
                if (\Auth::guard($guard)->check()) {
                    return redirect()->route('login');
                }
                break;

            case 'api':
                if (\Auth::guard($guard)->check()) {
                    return response()->json(['errors' => 'Unauthenticated', 'status' => 0], 401);
                }
                break;
            default:
                if (\Auth::guard($guard)->check()) {
                    return redirect()->url('/');
                }
                break;
        }

        return $next($request);
    }
}
