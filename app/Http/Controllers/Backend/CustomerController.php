<?php

namespace App\Http\Controllers\Backend;

use App\Models\City;
use App\Models\District;
use App\Models\User;
use App\Models\Wards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class CustomerController extends Controller
{
    public function index()
    {
        $params = \request()->all();
        $users = User::getAllUser($params);
        $cities = City::getOptionCity();
        $districts = District::getOptionDistrict();
        $wards = Wards::getOptionWards();

        return view('backend.pages.customer.index', compact('users', 'cities', 'districts', 'wards'));
    }

    public function getListAllCustomer(Request $request)
    {
        $users = User::getAllUser();
        $data = [];

        if (count($users)) {
            foreach ($users as $user) {
                $data[] = [
                    'id' => $user->id
                ];
            }
        }

        return response()->json(array_flatten($data));
    }

    public function delete($id)
    {
        $user = Auth::guard('admins')->user();

        if ($user->can('deleteCustomer', User::class)) {
            try {
                User::deleteUser($id);

                Session::flash("success", trans("messages.user.delete_success"));
                return response()->json();
            } catch (\Exception $e) {
                Session::flash("error", trans("messages.user.delete_failed"));
                return response()->json();
            }
        }
    }

    public function destroy(Request $request)
    {
        $user = Auth::guard('admins')->user();

        if ($user->can('deleteCustomer', User::class)) {
            try {
                User::destroy($request->get('ids'));

                Session::flash("success", trans("messages.user.delete_success"));
            } catch (\Exception $e) {
                Session::flash("error", trans("messages.user.delete_failed"));
            }
        }
    }
}
