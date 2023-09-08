<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\User;

class CheckPermissionsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $user = User::find(currentUserId());
        // Get the required permission for the current route
        $requiredPermission = $request->route()->getName();

 
    

        /*if ($user->permissions->contains('name', $requiredPermission)) {*/
            return $next($request);
        //} 
        // User doesn't have the required permission, handle accordingly
        //return redirect()->route('access.denied');


        /*=== For Role Wise Permission=== */
        /*$roles = $user->roles;
        $routeName = $request->route()->getName();

        foreach ($roles as $role) {
            if ($role->hasPermission($routeName)) {
                return $next($request);
            }
        }*/
    }
}
