<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\Admin\PasswordResetRequest;
use App\Http\Requests\ForgetPassWordRequest;
use App\Models\Admin;
use App\Models\AdminPasswordReset;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Mail;
use App\Mail\Admin\ForgetPasswordMail;
use Hash;
use App\Http\Requests\UpdatePasswordRequest;

class PasswordResetController extends Controller
{
    /**
     * getForgetPassword
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function getForgetPassword()
    {
        return view('backend.mail.forget_password');
    }

    /**
     * postForgetPassword
     *
     * @param ForgetPassWordRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function checkEmailAdmin(ForgetPassWordRequest $request)
    {
        $adminPasswordReset = $this->_savePasswordReset($request);
        $this->_sendPasswordResetMail($adminPasswordReset);
        return response()->json($adminPasswordReset, 200);
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

        $adminPasswordReset = AdminPasswordReset::firstOrNew(['email' => $request->email]);
        $adminPasswordReset->token = $token;
        $adminPasswordReset->save();

        return $adminPasswordReset;
    }

    /**
     * send Password Reset Mail
     *
     * @param $adminPasswordReset
     */
    private function _sendPasswordResetMail($adminPasswordReset)
    {
        Mail::to($adminPasswordReset->email)->send(new ForgetPasswordMail($adminPasswordReset));
    }

    /**
     * Ajax post password reset
     *
     * @param PasswordResetRequest $request
     *
     * @return \Illuminate\Contracts\Routing\ResponseFactory|\Illuminate\Http\Response
     */
    public function updatePasswordAjax(UpdatePasswordRequest $request)
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
        $admin = Admin::where('email', $request->email)->first();
        $admin->password = Hash::make($request->new_password);

        if ($admin->save()) {
            AdminPasswordReset::deleteAdminPasswordResetByEmail($request->email);
        }
    }
}
