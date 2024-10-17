<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleBasedDashboard
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next,String $role): Response
    {
        if($role == 'admin' && session()->get('user_role') != 'Admin'){
            abort(403);
        }
        if($role == 'instructor' && session()->get('user_role') != 'Instructor'){
            abort(403);
        }
        if($role == 'learner' && session()->get('user_role') != 'Learner'){
            abort(403);
        }
        return $next($request);
    }
}
