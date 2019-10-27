<?php

namespace App\Http\Controllers\FrontEnd;

use App\Helpers\Helper;
use App\Models\Product;
use Cart;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    public function index(Request $request)
    {
        dd(1);
    }

    public function addCart(Request $request, $id)
    {
        $products = Product::showProduct($id);

        $cart = Helper::addToCart($products, $request->all());
//        Cart::destroy();
        Cart::add($cart);

        Session::flash("success", trans("messages.front_end.cart.add_cart_success"));
        return back();
    }
}
