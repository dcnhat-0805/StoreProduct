<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class AdminLoginMiddleware
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
        if (Auth::guard("admins")->check()) {
            $admin = Auth::guard("admins")->user();
            $permission = Auth::guard("admins")->user()->adminGroup;

            if ($admin->admin_status == 1 && $permission->permission > 0) {
                return $next($request);
            } else {
                return redirect(route(ADMIN_SHOW_LOGIN))->with('danger', trans("messages.admin.login_failed"));
            }
        } else
        {
            return redirect(route(ADMIN_SHOW_LOGIN))->with('danger', trans("messages.admin.login_failed"));
        }
    }
}
