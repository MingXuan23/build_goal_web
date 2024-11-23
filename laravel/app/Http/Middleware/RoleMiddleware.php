<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, ...$roles): Response
    {
        Session::forget('user_id');
        Session::forget('user_email');
        $user = Auth::user();

        if (!Auth::check()) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->flush();
            Session::flush();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'You must be logged in to access this page.');
        }

        if (!$user) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->flush();
            Session::flush();
            $request->session()->regenerateToken();
            return redirect('/login')->with('error', 'You must be logged in to access this page.');
        }

        $userRoles = json_decode($user->role);

        $allowedRoles = explode('|', $roles[0]);

        if (empty(array_intersect($userRoles, $allowedRoles))) {
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->flush();
            $request->session()->regenerateToken();
            Session::flush();
            return redirect('/login')->with('error', 'You dont have permission to access this');
        }
        return $next($request);
    }
}
