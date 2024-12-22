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

        if($user->active === 0){
            return redirect('/login')->with('error', 'Your account is block, Please Contact us by email to help-center@xbug.online for inform if we mistake');
        }

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

        $allowedRoles = is_array($roles) ? $roles : explode('|', $roles);  // Split the string into an array

        // Convert all allowed roles into integers (to avoid comparison issues between strings and integers)
        $allowedRoles = array_map('intval', $allowedRoles);

        if (empty(array_intersect($userRoles, $allowedRoles))) {
           // dd($userRoles, $allowedRoles,$roles, is_array($roles));
            Auth::logout();

            $request->session()->invalidate();
            $request->session()->flush();
            $request->session()->regenerateToken();
            Session::flush();
            return redirect('/login')->with('error', 'You dont have permission to access this');
        }

       // dd('success');
        return $next($request);
    }
}
