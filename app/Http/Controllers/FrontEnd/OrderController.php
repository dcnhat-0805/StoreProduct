<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Auth;

class OrderController extends FrontEndController
{
    public function myOrder(Request $request)
    {
        $user  = Auth::user();
        if ($user) {
            $orders = Order::getListOrderByUserId($user->id);

            return view('frontend.pages.order.index', compact('orders', 'user'));
        } else {
            abort(404);
        }
    }

    public function orderDetail($orderCode)
    {
        $user  = Auth::user();

        if ($user) {
            $order = Order::getListOrderByOrderCode($orderCode);

            return view('frontend.pages.order.detail', compact('order', 'orderCode', 'user'));
        } else {
            abort(404);
        }
    }

    public function cancelOrder($orderCode)
    {
        $user  = Auth::user();

        if ($user) {
            Order::cancelOrder($orderCode);

            return back();
        } else {
            abort(404);
        }
    }
}
