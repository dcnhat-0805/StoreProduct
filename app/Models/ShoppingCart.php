<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Auth;
use Cart;

class ShoppingCart extends Model
{
    protected $table = 'shopping_carts';

    protected $fillable = ['user_id', 'rowId', 'content'];

    public static function createShoppingCart()
    {
        $user = Auth::user();
        $contents = Cart::content();

        if ($contents) {
            foreach ($contents as $content) {
                $isExistsContent = self::isExistsContent($content->rowId);
                if ($isExistsContent) {
                    $currentQty = self::getQuantityCart($content->rowId);
                    $content->qty = $currentQty + $content->qty;
                }
                $shoppingCart = ShoppingCart::firstOrNew([
                    'user_id' => $user ? $user->id : null,
                    'rowId' => $content->rowId,
//                    'content' => serialize($content),
                ]);
                $shoppingCart->content = serialize($content);

                if ($shoppingCart->save()) {
                    Cart::remove($content->rowId);
                }
            }
        }
    }

    public static function isExistsContent($rowId)
    {
        $user = Auth::user();
        $contents = self::where('user_id', $user->id)
            ->where('rowId', $rowId)->exists();

        return $contents;
    }

    public static function getQuantityCart($rowId)
    {
        $user = Auth::user();
        $contents = self::where('user_id', $user->id)
            ->where('rowId', $rowId)
            ->select('content')
            ->pluck('content')
            ->first();

        $contents = unserialize($contents);

        return $contents->qty;
    }

    public static function getCountCart()
    {
        $user = Auth::user();
        $carts = self::where('user_id', $user->id)->get();

        $total = 0;
        foreach ($carts as $cart) {
            $contents = unserialize($cart->content);
            $total += $contents->qty;
        }

        return $total;
    }

    public static function getContentCart()
    {
        $user = Auth::user();
        $carts = self::where('user_id', $user->id)->get();

        $shoppingCarts = [];
        foreach ($carts as $key => $cart) {
            $contents = unserialize($cart->content);
            $shoppingCarts[$key] = $contents;
        }

        return $shoppingCarts;
    }

    public static function getContentCartByRowId($rowId)
    {
        $user = Auth::user();
        $content = self::where('user_id', $user->id)
            ->where('rowId', $rowId)
            ->select('content')
            ->pluck('content')
            ->first();

        return unserialize($content);
    }

    public static function getCartByRowId($rowId)
    {
        $user = Auth::user();
        $carts = self::where('user_id', $user->id)
            ->where('rowId', $rowId)
            ->first();

        return $carts;
    }

    public static function updateCart($request, $rowId)
    {
        $quantity = $request['quantity'];

        if ($quantity == 0) return;

        $carts = self::getCartByRowId($rowId);
        $content = self::getContentCartByRowId($rowId);
        $content->qty = $quantity;

        return $carts->update([
            'content' => serialize($content)
        ]);
    }

    public static function deleteCart($rowId)
    {
        $user = Auth::user();
        return self::where('user_id', $user->id)
            ->where('rowId', $rowId)
            ->delete();
    }
}
