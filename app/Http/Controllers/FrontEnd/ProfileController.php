<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Requests\EditEmailRequest;
use App\Http\Requests\EditPasswordRequest;
use App\Http\Requests\EditProfileRequest;
use App\Mail\FrontEnd\RegisterUserMail;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use App\Models\User;
use App\Models\Wards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class ProfileController extends Controller
{
    public function showProfile(Request $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        $orders = Order::getListOrderByUserId($user->id);
        return view('frontend.pages.profile.index', compact('orders', 'user'));
    }

    public function showEditProfile(Request $request)
    {
        $user = Auth::user();
        $cities = City::getOptionCity();
        $districts = District::getOptionDistrict();
        $wards = Wards::getOptionWards();

        if (!$user) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        } else {
            return view('frontend.pages.profile.edit', compact('cities', 'districts', 'wards', 'user'));
        }
    }

    public function editProfile(EditProfileRequest $request)
    {
        $user = Auth::user();
        $input = $request->all();

        if (isset($input['email'])) {
            unset($input['email']);
        }
        if (isset($input['password'])) {
            unset($input['password']);
        }
        if (isset($input['id'])) {
            unset($input['id']);
        }

        if (!$user) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        $account = User::updateUser($user->id, $input);

        DB::beginTransaction();
        if ($account) {
//            Mail::to($user->email)->send(new RegisterUserMail($user));
            DB::commit();
            Session::flash("success", trans("messages.users.update_success"));
            return redirect()->route(FRONT_SHOW_PROFILE, ['sop' => convertStringToUrl($user->name)]);
        } else {
            DB::rollBack();
            Session::flash("error", trans("messages.users.update_failed"));
        }
    }

    public function showFormEditEmail()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        return view('frontend.pages.profile._email', compact( 'user'));
    }

    public function editEmail(EditEmailRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        $account = User::showUser($user->id);

        if ($account) {
            $account->email = $request->get('email');
            DB::beginTransaction();
            if ($account->save()) {
//            Mail::to($user->email)->send(new RegisterUserMail($user));
                DB::commit();
                Session::flash("success", trans("messages.users.update_success"));
                return redirect()->route(FRONT_SHOW_PROFILE, ['sop' => convertStringToUrl($user->name)]);
            } else {
                DB::rollBack();
                Session::flash("error", trans("messages.users.update_failed"));
            }
        }
    }

    public function showFormEditPassword()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        return view('frontend.pages.profile._password', compact( 'user'));
    }

    public function changePassword(EditPasswordRequest $request)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route(FRONT_END_HOME_INDEX);
        }

        $currentPassword = $request->get('current_password_user');
        $account = User::showUser($user->id);
        if (Hash::check($currentPassword, $account->password)) {
            $account->password = Hash::make($request->input('password_user'));
            $account->save();

            Auth::logoutOtherDevices($request->input('password_user'));
            Session::flash("success", trans("messages.users.update_success"));
            return redirect()->route(FRONT_SHOW_PROFILE, ['sop' => convertStringToUrl($user->name)]);
        } else {
            Session::flash('error', 'The old password you entered is incorrect.');
            return redirect()->back();
        }

    }
}
