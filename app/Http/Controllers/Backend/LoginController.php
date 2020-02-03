<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\ForgetPassWordRequest;
use App\Http\Requests\LoginRequest;
use App\Models\Admin;
use App\Models\AdminPasswordReset;
use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    /**
     * Show Form Login
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
        if (Auth::guard('admins')->check()) {
            return redirect(route(ADMIN_DASHBOARD_DAILY));
        }

        return view('backend.login');
    }

    /**
     * Login
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function login(LoginRequest $request)
    {
        $email = $request['email'];
        $message = trans("messages.admin.login_success");
        $dataLogin = [
            'email' => $email,
            'password' => $request['password']
        ];
        $remember = $request->get('remember_token');
        Session::put(SESSION_REMEMBER_TOKEN, $remember);

        if (Auth::guard('admins')->attempt($dataLogin, $remember)) {
            UserLog::saveAdminLog($message, $email);
            Session::flash("success", trans("messages.admin.login_success"));
            Session::forget(SESSION_REMEMBER_TOKEN);
            $lastUrl = Session::get(SESSION_LAST_URL);

            if ($lastUrl && $lastUrl !== route(ADMIN_SHOW_LOGIN)) {
                return redirect($lastUrl);
            }

            return redirect(route(ADMIN_DASHBOARD_DAILY));
        } else {
            $count_user = Admin::where("email", $email)->count();
            if ($count_user) {
                $message = trans("messages.admin.login_failed");
                UserLog::saveAdminLog($message, $email);
            }
            Session::flash("danger", trans("messages.admin.login_failed"));

            return redirect()->back();
        }
    }

    /**
     * Log Out
     *
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Auth::guard('admins')->logout();
        Session::flash("success", trans("messages.admin.logout_success"));
        Session::forget(SESSION_LAST_URL);

        return redirect(route(ADMIN_LOGIN));
    }
}
