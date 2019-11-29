<?php

namespace App\Http\Controllers\Backend;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $orders = Order::getListAllOrder($params);

        return view('backend.pages.order.index', compact('orders'));
    }

    public function detail(Request $request, $code)
    {
        if ($request->ajax()) {
            $order = Order::getListOrderByOrderCode($code);

            $html = view('backend.pages.order.detail', compact('order'))->render();

            return response()->json(['html' => $html, 'order' => $order]);
        }
    }

    public function delivery(Request $request, $id)
    {
        if ($request->ajax()) {
            $order = Order::deliveryOrder($id);
            DB::beginTransaction();

            if ($order) {
                Session::flash("success", trans("messages.product_category.create_success"));
                DB::commit();
                return response()->json($order, 200);
            } else {
                DB::rollBack();
            }
        }
    }
}
