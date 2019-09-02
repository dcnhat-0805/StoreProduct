<?php

namespace App\Http\Controllers\Backend;

use App\Http\Requests\LoginRequest;
use App\Models\AdminGroup;
use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Http\Requests\AdminRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AdminController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admin = Admin::getListAdmin();
        $permission = AdminGroup::all();
        return view(ADMIN_INDEX_BLADE, compact('admin', 'permission'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        $user = Auth::guard('admins')->user();

        if ($user->can('createAdmin', Admin::class)) {
            $input = $request->all();
            $admin = Admin::createNewAdmin($input);
            if ($admin) {
                Session::flash("success", trans("messages.admin.create_success"));
                return response()->json();
            }
        }
    }

    /**
     * Show Form Login
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function showLoginForm()
    {
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
        $userLogModel = new UserLog();
        if (Auth::guard('admins')->attempt($dataLogin, $remember)) {
            $userLogModel->saveData($message, $email);
            Session::flash("success", trans("messages.admin.login_success"));
            return redirect(route(ADMIN_DASHBOARD));
        } else {
            $errors = trans("messages.admin.login_failed");
            $count_user = Admin::where("email", $email)->count();
            if ($count_user) {
                $message = trans("messages.admin.login_failed");
                $userLogModel->saveData($message, $email);
            }
            Session::flash("danger", trans("messages.admin.login_failed"));
            return redirect()->back();
        }
    }

    public function logout()
    {
        Auth::guard('admins')->logout();
        Session::flash("success", trans("messages.admin.logout_success"));
        return redirect(route(ADMIN_LOGIN));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * @param AdminRequest $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(AdminRequest $request, $id)
    {
        $user = Auth::guard('admins')->user();
        if ($user->can('updateAdmin', Admin::class)) {
            $input = $request->all();
            $admin = Admin::updateAdmin($id, $input);
            if ($admin) {
                Session::flash("success", trans("messages.admin.update_success"));
                return response()->json();
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $user = Auth::guard('admins')->user();
        $admin = Admin::deleteAdmin($id);

        if ($user->can('deleteAdmin', Admin::class) && isset($admin)) {
            Session::flash("success", trans("messages.admin.delete_success"));
            return response()->json();
        } else {
            Session::flash("success", trans("messages.admin.delete_failed"));
            return response()->json();
        }
    }
}
