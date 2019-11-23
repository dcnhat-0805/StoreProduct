<?php

namespace App\Http\Controllers\FrontEnd;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Auth;

class OrderController extends Controller
{
    public function myOrder($userId)
    {
        $orders = Order::getListOrderByUserId($userId);

        dd($orders, Auth::user());
    }

    function checkOrder($orderCode) {
        $order = Order::getListOrderByOrderCode($orderCode);

        return view('frontend.pages.order.index', compact('order', 'orderCode'));
    }
}
