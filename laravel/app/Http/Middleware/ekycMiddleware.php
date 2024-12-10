<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ekycMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        // Periksa status eKYC
        if ($user->ekyc_status === 0) {

            if (in_array(3, json_decode($user->role)))  {
                $redirectPath = '/organization/dashboard';
            } elseif (in_array(4, json_decode($user->role))) {
                $redirectPath = '/content-creator/dashboard'; 
            } else {
                $redirectPath = '/login';
            }

            return redirect($redirectPath)->with(
                'errorEkyc',
                'Sorry, you have not completed the eKYC verification. Please ensure it is completed first.'
            );
        }

        return $next($request);
    }
}
