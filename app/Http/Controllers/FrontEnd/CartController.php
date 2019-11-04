<?php

namespace App\Http\Controllers\FrontEnd;

use App\Helpers\Helper;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Cart;
use DB;
use Closure;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $carts = Cart::content();

        return view('frontend.pages.cart.index', compact('carts'));
    }

    public function addCart(Request $request, $id)
    {
        if ($request->ajax()) {
            $products = Product::showProduct($id);

            $cart = Helper::addToCart($products, $request->all());
            DB::beginTransaction();
            if (Cart::add($cart)) {

                Cart::store($id);
                DB::commit();
//                Session::flash("success", trans("messages.front_end.cart.add_cart_success"));
                return response()->json(['countCart' => Cart::count(), 'success' => trans("messages.front_end.cart.add_cart_success")], 200);
            } else {
                DB::rollBack();
//                Session::flash("error", trans("messages.front_end.cart.add_cart_failed"));
                return response()->json(['error' => trans("messages.front_end.cart.add_cart_failed")], 200);
            }
        }
    }

    public function updateCart(Request $request, $rowId)
    {
        if ($request->ajax()) {
            $cart = Helper::updateCart($request->all(), $rowId);

            DB::beginTransaction();
            if ($cart) {

                Cart::store($cart->id);
                DB::commit();
//                Session::flash("success", trans("messages.front_end.cart.update_cart_success"));
                return response()->json(['countCart' => Cart::count(), 'cart' => $cart, 'success' => trans("messages.front_end.cart.update_cart_success")], 200);
            } else {
                DB::rollBack();
//                Session::flash("error", trans("messages.category.update_cart_failed"));
                return response()->json(['error' => trans("messages.category.update_cart_failed")], 200);
            }
        }
    }

    public function listALLCart()
    {

        $carts = Cart::content();
        $data = [];

        if (count($carts)) {
            foreach ($carts as $cart) {
                $data[] = [
                    'row_id' => $cart->rowId
                ];
            }
        }

        return response()->json(array_flatten($data));
    }

    public function getAllCart()
    {

        $carts = Cart::content();
        $data = [];

        if (count($carts)) {
            foreach ($carts as $cart) {
                array_push($data, $cart->rowId);
            }
        }

        return $data;
    }

    public function getCart($arrRowId)
    {
        $carts = [];

        if (isset($arrRowId) && $arrRowId) {
            foreach ($arrRowId as $rowId) {
                array_push($carts, Cart::get($rowId));
            }
        }

        return $carts;
    }

    public function getTotalCart(Request $request)
    {
        $total = 0;
        $quantity = 0;
        $selectAll = $request->get('select_all');
        $rowIds = $request->get('ids');

        if ($selectAll) {
            $rowIds = $this->getAllCart();
        }


        $carts = $this->getCart($rowIds);

        if (count($carts)) {
            foreach ($carts as $cart) {
                $quantity += $cart->qty;
                $total += $cart->qty * $cart->price;
            }
        }

        return response()->json(['total' => $total, 'quantity' => $quantity], 200);
    }

    public function destroy(Request $request)
    {
        $selectAll = $request->get('select_all');
        $rowIds = $request->get('ids');

        dd($selectAll, $rowIds);
    }

    public function delete($rowId)
    {
        Cart::remove($rowId);

        return response()->json(trans("messages.front_end.cart.delete_cart_success"), 200);
    }
}
