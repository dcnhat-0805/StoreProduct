<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Requests\LoginFrontEndRequest;
use App\Models\City;
use App\Models\District;
use App\Models\ShoppingCart;
use App\Models\UserLog;
use App\Models\Wards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Session;
use App\Models\User;
use Auth;
use Cart;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        if (Auth::check()) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        return view('frontend.pages.user.login');
    }

    public function loginSocial($social)
    {
        return Socialite::driver($social)->redirect();
    }

    public function callbackSocial($social)
    {
        $user = Socialite::driver($social)->user();
        if (!$user) {
            Session::flash("error", trans("messages.login.login_social_failed"));
            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        $authUser = $this->findOrCreateUser($user);
        Auth::login($authUser);

        ShoppingCart::createShoppingCart();

        Session::flash("success", trans("messages.login.login_success"));
        $lastUrl = Session::get(SESSION_LAST_URL_CUSTOMER);

        if ($lastUrl && $lastUrl !== route(FRONT_LOGIN)) {
            return redirect($lastUrl);
        }

        return redirect()->route(FRONT_END_HOME_INDEX);
    }

    private function findOrCreateUser($user)
    {
        $authUser = User::where('social_id', $user->id)->first();
        if ($authUser) {
            return $authUser;
        } else {
            return User::create([
                'name' => $user->name,
                'email' => $user->email,
                'password' => '',
                'social_id' => $user->id,
                'status' => 1,
                'avatar' => $user->avatar,
            ]);
        }
    }

    public function logout()
    {
        if (Auth::check()) {
            Auth::logout();
            Session::flash("success", trans("messages.login.logout_success"));
            Session::forget(SESSION_LAST_URL_CUSTOMER);

            return redirect()->route(FRONT_LOGIN);
        }
    }

    public function login(LoginFrontEndRequest $request)
    {
        $email = $request['email'];
        $message = trans("messages.users.login_success");
        $dataLogin = [
            'email' => $email,
            'password' => $request['password']
        ];
        $remember = $request->get('remember_token');

        $user = User::checkAcceptUser($email);

        if ($user) {
            Session::flash("danger", trans("messages.users.not_accept"));

            UserLog::saveUserLog(trans("messages.users.not_accept"), $email);
            return redirect()->back();
        }

        if (Auth::attempt($dataLogin, $remember)) {
            UserLog::saveUserLog($message, $email);
            Session::flash("success", trans("messages.users.login_success"));
            $lastUrl = Session::get(SESSION_LAST_URL_CUSTOMER);

            ShoppingCart::createShoppingCart();

            if ($lastUrl && $lastUrl !== route(FRONT_LOGIN)) {
                return redirect($lastUrl);
            }

            return redirect(route(FRONT_END_HOME_INDEX));
        } else {
            $count_user = User::where("email", $email)->count();
            if ($count_user) {
                $message = trans("messages.users.login_failed");
                UserLog::saveUserLog($message, $email);
            }
            Session::flash("error", trans("messages.users.login_failed"));

            return redirect()->back();
        }
    }
}
