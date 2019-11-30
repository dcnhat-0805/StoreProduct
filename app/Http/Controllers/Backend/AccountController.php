<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\AccountEditEmailRequest;
use App\Http\Requests\AccountEditPasswordRequest;
use App\Http\Requests\AccountEditRequest;
use App\Models\Admin;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use Hash;
use Illuminate\Support\Facades\Session;

class AccountController extends Controller
{
    public function editAccount()
    {
        $userId = Auth::guard('admins')->id();
        $user = Admin::showAdmin($userId);

        return view('backend.pages.admin.edit_account', compact('user'));
    }

    public function updateAccount(AccountEditRequest $request)
    {
        $userId = Auth::guard('admins')->id();
        unset($request->email);
        unset($request->password);
        $input = $request->all();
        $user = Admin::updateAccountAdmin($userId, $input);
        if ($user) {
            Session::flash("success", trans("messages.admin.update_success"));
        } else {
            Session::flash("success", trans("messages.admin.update_failed"));
        }

        return back();
    }

    public function editEmail()
    {
        $userId = Auth::guard('admins')->id();
        $user = Admin::showAdmin($userId);

        return view('backend.pages.admin.edit_email', compact('user'));
    }

    public function updateEmail(AccountEditEmailRequest $request)
    {
        $userId = Auth::guard('admins')->id();
        $input = $request->all();
        $user = Admin::updateEmailAccount($userId, $input);

        if ($user) {
            Session::flash("success", trans("messages.admin.update_success"));
            return redirect()->route(ADMIN_ACCOUNT_EDIT)->with('user', $user);
        } else {
            Session::flash("success", trans("messages.admin.update_failed"));
            return redirect()->back();
        }
    }

    public function editPassword()
    {
        return view('backend.pages.admin.edit_password');
    }

    public function updatePassword(AccountEditPasswordRequest $request)
    {
        $userId = Auth::guard('admins')->id();
        $input = $request->all();
        $currentPassword = $input['current_password'];
        $user = Admin::showAdmin($userId);
        if (Hash::check($currentPassword, $user->password)) {
            $user->password = Hash::make($input['password']);
            $user->save();

            Auth::guard('admins')->logoutOtherDevices($input['password']);
            Session::flash("success", trans("messages.admin.update_success"));
            return redirect()->route(ADMIN_ACCOUNT_EDIT)->with('user', $user);
        } else {
            Session::flash("success", trans("messages.admin.update_failed"));
            return redirect()->back();
        }
    }
}
