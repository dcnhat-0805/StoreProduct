<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Requests\ForgetPasswordFrontEndRequest;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\UpdatePasswordFrontEndRequest;
use App\Mail\FrontEnd\RegisterUserMail;
use App\Mail\FrontEnd\ResetPasswordUserMail;
use App\Models\City;
use App\Models\District;
use App\Models\PasswordResetUser;
use App\Models\User;
use App\Models\Wards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{

    public function showRegisterForm()
    {
        $cities = City::getOptionCity();
        $districts = District::getOptionDistrict();
        $wards = Wards::getOptionWards();

        return view('frontend.pages.user.register', compact('cities', 'districts', 'wards'));
    }

    public function getDistrictByCityId()
    {
        if (request()->ajax()) {
            $city_id = request()->get('city_id');
            $districts = District::getOptionDistrict($city_id);

            $html = view('frontend.pages.user._select_district', ['districts' => $districts])->render();

            return response()->json($html);
        }
    }

    public function getWardsByDistrictId()
    {
        if (request()->ajax()) {
            $district_id = request()->get('district_id');
            $wards = Wards::getOptionWards($district_id);

            $html = view('frontend.pages.user._select_wards', ['wards' => $wards])->render();

            return response()->json($html);
        }
    }

    public function store(RegisterUserRequest $request)
    {
        $input = $request->all();

        DB::beginTransaction();
        $user = User::createUser($input);

        if ($user) {
            Mail::to($user->email)->send(new RegisterUserMail($user));
            DB::commit();
            Session::flash("success", trans("messages.users.create_success"));
            return back();
        } else {
            DB::rollBack();
                Session::flash("error", trans("messages.users.create_failed"));
        }
    }

    public function accept($code)
    {
        if (User::acceptUser($code)) {
            Session::flash("success", trans("messages.users.accept_success"));
        } else {
            Session::flash("error", trans("messages.users.accept_failed"));
        }

        return redirect()->route(FRONT_LOGIN);
    }

    public function showFormForgetPassword() {
        return view('frontend.pages.user.forget_password');
    }

    public function checkEmailUser(ForgetPasswordFrontEndRequest $request)
    {

        $userPasswordReset = $this->_savePasswordReset($request);
        $this->_sendPasswordResetMail($userPasswordReset);

        return response()->json($userPasswordReset, 200);
    }

    /**
     * Save password reset
     *
     * @param $request
     *
     * @return AdminPasswordReset
     */
    private function _savePasswordReset($request)
    {
        $token = md5(uniqid(rand(), true));

        $adminPasswordReset = PasswordResetUser::firstOrNew(['email' => $request->email]);
        $adminPasswordReset->token = $token;
        $adminPasswordReset->save();

        return $adminPasswordReset;
    }

    /**
     * send Password Reset Mail
     *
     * @param $userPasswordReset
     */
    private function _sendPasswordResetMail($userPasswordReset)
    {
        Mail::to($userPasswordReset->email)->send(new ResetPasswordUserMail($userPasswordReset));
    }

    /**
     * Ajax post password reset
     *
     * @param UpdatePasswordFrontEndRequest $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updatePassword(UpdatePasswordFrontEndRequest $request)
    {
        DB::beginTransaction();
        try {
            $this->_updatePassword($request);
            DB::commit();
        } catch (\Exception $exception) {
            DB::rollBack();
        }

        return response()->json();
    }

    /**
     * Update password
     *
     * @param $request
     */
    private function _updatePassword($request)
    {
        $user = User::where('email', $request->email)->first();
        $user->password = Hash::make($request->new_password);

        if ($user->save()) {
            PasswordResetUser::deleteUserPasswordResetByEmail($request->email);
        }
    }
}
