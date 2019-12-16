<?php

namespace App\Http\Middleware;

use Closure;
use Auth;
use Illuminate\Support\Facades\Session;

class CustomerMiddleware
{
    protected $timeout = 28800;
    public function __construct()
    {

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
        if (!Session::has(SESSION_LAST_ACTIVE_TIME_CUSTOMER)) {
            Session::put(SESSION_LAST_ACTIVE_TIME_CUSTOMER, time());

        } elseif (time() - Session::get(SESSION_LAST_ACTIVE_TIME_CUSTOMER) > $this->getTimeOut()) {
            Session::forget(SESSION_LAST_ACTIVE_TIME_CUSTOMER);
            Auth::logout();

            $lastUrl = $this->getLastUrl();
            Session::put(SESSION_LAST_URL_CUSTOMER, $lastUrl);

            if ($lastUrl && $lastUrl !== route(FRONT_LOGIN)) {
                return redirect($lastUrl);
            }

            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        Session::put(SESSION_LAST_ACTIVE_TIME_CUSTOMER, time());
        return $next($request);
    }

    protected function getTimeOut()
    {
        return (env('TIMEOUT_FRONT_END')) ?: $this->timeout;
    }

    public function getLastUrl()
    {
        if (!request()->ajax() && request()->method() == 'GET') {
            $param = parse_url($_SERVER['REQUEST_URI'], PHP_URL_QUERY);

            if (isset($param) && $param) {
                return url()->current() . '?' . $param;
            } else {
                return url()->current();
            }
        }

        return route(FRONT_END_HOME_INDEX);
    }
}
