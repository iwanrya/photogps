<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
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
        // env - development can use session browser to see json result
        if ((App::isProduction() === false && $request->acceptsHtml()) || $request->acceptsAnyContentType()) {
            // has session
            if ($request->hasSession() && $request->user()) {
                return $next($request);
            }
        } else if (App::isProduction() && $request->acceptsHtml()) {
            
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
