<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\JWT;

class SessionOrJWTAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->acceptsAnyContentType()) {
            // has session
            if ($request->hasSession() && $request->user()) {
                return $next($request);
            }
        } else {

            if ($request->acceptsJson()) {
                if ($user = JWTAuth::parseToken()->authenticate()) {
                    return $next($request);
                }
            }
        }

        return response('', Response::HTTP_UNAUTHORIZED);
    }
}
