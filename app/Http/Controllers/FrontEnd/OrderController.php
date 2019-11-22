<?php

namespace App\Http\Controllers\FrontEnd;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    function checkOrder($orderCode) {
        $order = Order::getListOrderByOrderCode($orderCode);

        return view('frontend.pages.order.index', compact('order', 'orderCode'));
    }
}
