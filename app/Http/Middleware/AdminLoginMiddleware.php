<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Session\Store;
use Illuminate\Support\Facades\Session;

class AdminLoginMiddleware
{
    protected $session;
    protected $timeout = 28800;

    public function __construct(Store $session){
        $this->session = $session;
    }

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
            $isLoggedIn = $request->path() != 'admin/logout';

            if (!Session::has(SESSION_LAST_ACTIVE_TIME)) {

                Session::put(SESSION_LAST_ACTIVE_TIME, time());

            } elseif(time() - Session::get(SESSION_LAST_ACTIVE_TIME) > $this->getTimeOut()){

                Session::forget(SESSION_LAST_ACTIVE_TIME);
                Auth::guard('admins')->logout();

                if (request()->ajax()) {
                    return response()->json(['error' => 'Unauthenticated.'], 302);
                }

                $lastUrl = $isLoggedIn ? $this->getLastUrl() : route(ADMIN_DASHBOARD_DAILY);
                Session::put(SESSION_LAST_URL, $lastUrl);

                return redirect(route(ADMIN_SHOW_LOGIN));
            }

            $isLoggedIn ? Session::put(SESSION_LAST_ACTIVE_TIME, time()) : Session::forget(SESSION_LAST_ACTIVE_TIME);

            $admin = Auth::guard("admins")->user();

            if ($admin->admin_status == 1 && $admin->role > 0) {
                return $next($request);
            } else {
                return redirect(route(ADMIN_SHOW_LOGIN))->with('danger', trans("messages.admin.login_failed"));
            }
        } else
        {
            return redirect(route(ADMIN_SHOW_LOGIN))->with('info', trans("messages.admin.login_admin"));
        }
    }

    public function getLastUrl()
    {
        if (!request()->ajax() && request()->method() == 'GET') {
            return url()->current();
        }

        return route(ADMIN_DASHBOARD_DAILY);
    }

    protected function getTimeOut()
    {
        return (env('TIMEOUT_BACK_END')) ?: $this->timeout;
    }
}
