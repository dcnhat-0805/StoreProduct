<?php

namespace App\Http\Controllers\FrontEnd;

use App\Helpers\Helper;
use App\Http\Requests\CheckCountRequest;
use App\Mail\FrontEnd\ShoppingMail;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\ShoppingCart;
use App\Models\Wards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use Cart;
use DB;
use Auth;
use Closure;

class CartController extends FrontEndController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $carts = Cart::content();
        if ($user) {
            $carts = ShoppingCart::getContentCart();
        }

        return view('frontend.pages.cart.index', compact('carts'));
    }

    public function addCart(Request $request, $id)
    {
        if ($request->ajax()) {
            $products = Product::showProduct($id);
            $user = Auth::user();

            $cart = Helper::addToCart($products, $request->all());
            DB::beginTransaction();
            if (Cart::add($cart)) {
                if ($user) {
                    ShoppingCart::createShoppingCart();
                }

                $countCart = Cart::count();
                if ($user) {
                    $countCart = ShoppingCart::getCountCart();
                }
//                Cart::store($id);
                DB::commit();
//                Session::flash("success", trans("messages.front_end.cart.add_cart_success"));
                return response()->json(['countCart' => $countCart, 'success' => trans("messages.front_end.cart.add_cart_success")], 200);
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
            $user = Auth::user();
            if ($user) {
                ShoppingCart::updateCart($request->all(), $rowId);
                $cart = ShoppingCart::getContentCartByRowId($rowId);
            } else {
                $cart = Helper::updateCart($request->all(), $rowId);
            }

            DB::beginTransaction();
            if ($cart) {

                $countCart = Cart::count();
                if ($user) {
                    $countCart = ShoppingCart::getCountCart();
                }
//                Cart::store($cart->id);
                DB::commit();
//                Session::flash("success", trans("messages.front_end.cart.update_cart_success"));
                return response()->json(['countCart' => $countCart, 'cart' => $cart, 'success' => trans("messages.front_end.cart.update_cart_success")], 200);
            } else {
                DB::rollBack();
//                Session::flash("error", trans("messages.category.update_cart_failed"));
                return response()->json(['error' => trans("messages.category.update_cart_failed")], 200);
            }
        }
    }

    public function checkCount(Request $request)
    {
        $cities = City::getOptionCity();
        $districts = District::getOptionDistrict();
        $wards = Wards::getOptionWards();
        $rowIds = explode(',', $request->get('row_id_checkout'));
        $total = 0;
        $quantity = 0;

        if ($rowIds) {
            $carts = $this->getCart($rowIds);
            Session::put(SESSION_ROW_IDS, $rowIds);

            if (count($carts)) {
                foreach ($carts as $cart) {
                    $quantity += $cart->qty;
                    $total += $cart->qty * $cart->price;
                }
            }

            return view('frontend.pages.cart.checkout', compact('carts', 'cities', 'districts', 'wards', 'total', 'quantity'));
        }

        abort(400, 'Page not found!');
    }

    public function purchase(CheckCountRequest $request)
    {
        $user = Auth::user();
        $data = $request->all();
        $rowIds = Session::get(SESSION_ROW_IDS);
        $data['order_code'] = 'SOP_' . uniqid() . '_' . time();
        $data['user_id'] = Auth::user() ? Auth::user()->id : null;
        $data['order_name'] = $request->get('name');
        $data['order_email'] = $request->get('email');
        $data['order_phone'] = $request->get('phone');
        $data['order_address'] = $request->get('wards');
        $data['order_monney'] = $request->get('total_price');
        $data['status'] = 0;
        $order = Order::create($data);

        $orderDetail = [];
        $orderDetails = [];

        DB::beginTransaction();
        if ($order) {
            $idOrder = $order->id;
            $carts = $this->getCart($rowIds);

            foreach( $carts as $key => $cart ) {
                $orderDetail['order_id'] = $idOrder;
                $orderDetail['product_id'] = $cart->id;
                $orderDetail['quantity'] = $cart->qty;
                $orderDetail['options'] = serialize($cart->options);
                $orderDetail['amount'] = $cart->price;
                $orderDetails[$key] = OrderDetail::create($orderDetail);

                Product::updateCountBuy($cart->id);
                if ($user) {
                    ShoppingCart::deleteCart($cart->rowId);
                } else {
                    Cart::remove($cart->rowId);
                }
                Session::forget(SESSION_ROW_IDS);
            }

            Mail::to($order->order_email)->send(new ShoppingMail($order, $orderDetails));
            DB::commit();

            Session::flash("success", trans("messages.users.shopping_success"));
            return redirect()->route(FRONT_END_HOME_INDEX);
        } else {
            DB::rollBack();
        }
    }

    public function listALLCart()
    {
        $user = Auth::user();
        $carts = Cart::content();
        if ($user) {
            $carts = ShoppingCart::getContentCart();
        }
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
        $user = Auth::user();
        $carts = Cart::content();
        if ($user) {
            $carts = ShoppingCart::getContentCart();
        }
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
                $user = Auth::user();
                $contents = Cart::content();
                if ($user) {
                    $contents = ShoppingCart::getContentCart();
                }

                if ($user) {
                    foreach ($contents as $content) {
                        if ($content->rowId == $rowId) {
                            $cartItem = ShoppingCart::getContentCartByRowId($rowId);
                            array_push($carts, $cartItem);
                        }
                    }
                } else {
                    if ($contents->has($rowId)) {
                        $cartItem = Cart::get($rowId);
                        array_push($carts, $cartItem);
                    }
                }
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
        $user = Auth::user();
        if ($user) {
            ShoppingCart::deleteCart($rowId);
        } else {
            Cart::remove($rowId);
        }

        return response()->json(trans("messages.front_end.cart.delete_cart_success"), 200);
    }
}
