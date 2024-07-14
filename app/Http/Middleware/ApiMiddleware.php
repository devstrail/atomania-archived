<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Closure(Request): (Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!$request->bearerToken()) {
            throw new UnauthorizedException('Missing token');
        }
        $user = Auth::guard('sanctum')->user();

        if (!$user) {
            throw new UnauthorizedException('Invalid token');
        }
//        if (!auth()->check()) {
//            return response() ->json(['error' => 'Unauthenticated.'], Response::HTTP_UNAUTHORIZED);
//        }
        return $next($request);
    }
}
