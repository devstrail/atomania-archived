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
     * Handle permission for api access ->
     * usage: ->middleware('permission:Manager,Farmer|Guest,User,Vendor')
     * explanation: Manager & Farmer is allowed to access. Guest, User & Vendors are not allowed to access.
     *
     * @param $next
     */
    public function handle(Request $request, Closure $next, ...$params): Response
    {
        // Extract and split the roles from the params
        $roles = $this->extractRoles($params);

        $user = Auth::user();

        if ((empty($roles['allowed']) && empty($roles['denied'])) || !$user) {
            return $next($request);
        }
        // TODO: Make the authentication more sophisticated
        //  have a look at App\Policies to understand the middleware more
        $permissionGranted = false;
        if (empty($roles['allowed'])) {
            $permissionGranted = true;
        }
        foreach ($roles['allowed'] as $allowed) {
            if ($allowed == "*" || $user->hasRole($allowed)) {
                $permissionGranted = true;
            }
        }
//        if (isset($roles['denied']) && $roles['denied'][0] == '*') {
//            $permissionGranted = true;
//        } else {
//            foreach ($roles['denied'] as $denied) {
//                if ($user->hasRole($denied)) {
//                    $permissionGranted = false;
//                }
//            }
//        }

        if ($permissionGranted) {
            return $next($request);
        }

        throw new UnauthorizedException("User does not have permission to access this resource. User Role: " . $user->type . ". Allowed Roles: " . implode(' & ', $roles['allowed']) . ", Denied Roles: " . implode(' & ', $roles['denied']));

    }

    function extractRoles($params) {
        return [
            'allowed' => isset($params[0]) ? array_map('trim', explode('|', $params[0])) : [],
            'denied' => isset($params[1]) ? array_map('trim', explode('|', $params[1])) : []
        ];
    }
}
