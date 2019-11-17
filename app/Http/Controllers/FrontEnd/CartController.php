<?php

namespace App\Http\Controllers\FrontEnd;

use App\Helpers\Helper;
use App\Http\Requests\CheckCountRequest;
use App\Models\City;
use App\Models\District;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use App\Models\Wards;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Cart;
use DB;
use Auth;
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

//                Cart::store($id);
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

//                Cart::store($cart->id);
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
        $data = $request->all();
        $rowIds = explode(',', $request->get('row_id_checkout'));
        $data['order_code'] = 'SOP_' . uniqid() . '_' . time();
        $data['user_id'] = Auth::user() ? Auth::user()->id : null;
        $data['order_name'] = $request->get('name');
        $data['order_email'] = $request->get('email');
        $data['order_phone'] = $request->get('phone');
        $data['order_address'] = $request->get('wards');
        $data['order_monney'] = $request->get('total_price');
        $data['cart_row_id'] = serialize($rowIds);
        $data['status'] = 0;
        $order = Order::create($data);

        $orderDetail = [];
        $orderDetails = [];

        DB::beginTransaction();
        if ($order) {
            $idOrder = $order->id;
            $carts = $this->getCart($rowIds);

            foreach( $carts as $key => $cart ){
                $orderDetail['order_id'] = $idOrder;
                $orderDetail['product_id'] = $cart->id;
                $orderDetail['quantity'] = $cart->qty;
                $orderDetail['amount'] = $cart->price;
                $orderDetails[$key] = OrderDetail::create($orderDetail);
                Cart::remove($cart->rowId);
            }

//            Mail::to($order->email)->send(new ShoppingMail($order,$orderdetails));
            DB::commit();

            return redirect()->route(FRONT_END_HOME_INDEX);
        } else {
            DB::rollBack();
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
                $content = Cart::content();

                if ( $content->has($rowId)) {
                    $cartItem = Cart::get($rowId);
                    array_push($carts, $cartItem);
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
        Cart::remove($rowId);

        return response()->json(trans("messages.front_end.cart.delete_cart_success"), 200);
    }
}
