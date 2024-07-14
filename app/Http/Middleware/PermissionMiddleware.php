<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class PermissionMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role = null): Response
    {
        $user = Auth::user();
        $test = [];
        if ($user && $user->hasRole($role)) {
            return $next($request);
        }
//        forEach($entities as $entity) {
//            list($name, $permissions) = explode('-', $entity);
//
//            $permissionsArray = explode('|', $permissions);
////            dd($permissionsArray);
//
////            if ($user && $user->hasPermission($permissionsArray)) {
////                return $next($request);
////            }
//        }
        throw new UnauthorizedException("User does not have permission to access this resource");

    }
}
