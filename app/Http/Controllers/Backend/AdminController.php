<?php

namespace App\Http\Controllers\Backend;

use App\Helpers\Helper;
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
        $params = request()->all();
        $admins = Admin::getListAllAdmin($params);

        if (!count($admins) && isset($params['page']) && $params['page']) {
            $route = Helper::isHasDataByPages($admins);

            return redirect($route);
        }

        return view(ADMIN_INDEX_BLADE, compact('admins'));
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
            } else {
//                Session::flash("error", trans("messages.admin.update_fail"));
            }
        }
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
            } else {
//                Session::flash("error", trans("messages.admin.update_success"));
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

        if ($user->can('deleteAdmin', Admin::class)) {
            try {
                if ($id != ADMIN) {
                    Admin::deleteAdmin($id);
                }

                Session::flash("success", trans("messages.admin.delete_success"));
                return response()->json();
            } catch (\Exception $e) {
                Session::flash("error", trans("messages.admin.delete_failed"));
                return response()->json();
            }
        }
    }

    public function getListAdmin()
    {
        $params = request()->all();
        $admin = Admin::getListAllAdmin($params);
        $data = [];

        if (count($admin)) {
            foreach ($admin as $ad) {
                if ($ad->id !== ADMIN) {
                    $data[] = [
                        'id' => $ad->id
                    ];
                }
            }
        }

        return response()->json(array_flatten($data));
    }

    public function destroy(Request $request)
    {
        $user = Auth::guard('admins')->user();

        if ($user->can('deleteAdmin', Admin::class)) {
            try {
                Admin::destroy($request->get('ids'));
                Session::flash("success", trans("messages.admin.delete_success"));
            } catch (\Exception $e) {
                Session::flash("error", trans("messages.admin.delete_failed"));
            }
        }
    }
}
