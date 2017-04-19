<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
		if (Auth::check()){
			$user = Auth::user();
			if ($user->user_type == 'User'){
				return $next($request);
			}
			return redirect('login');
		}else{
			return redirect('/');
		}
    }
}
