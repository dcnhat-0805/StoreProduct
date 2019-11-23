<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_code', 'transaction_id', 'user_id', 'order_name', 'order_address', 'order_email', 'order_phone', 'order_monney', 'order_message', 'order_status',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'deleted_at'
    ];

    public function User(){
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function orderDetail(){
        return $this->hasMany(OrderDetail::class,'order_id','id');
    }

    public static function getListOrderByOrderCode($orderCode)
    {
        $order = self::where('orders.order_code', '=', $orderCode)
                ->whereNull('orders.deleted_at')
                ->select(
                    'orders.id',
                    'orders.order_code',
                    'orders.transaction_id',
                    'orders.user_id',
                    'orders.order_name',
                    'orders.order_address',
                    'orders.order_email',
                    'orders.order_phone',
                    'orders.order_monney',
                    'orders.order_message',
                    'orders.order_status',
                    'orders.created_at'
                )
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->with([
                    'orderDetail' => function ($orderDetail) {
                        $orderDetail->whereNull('order_details.deleted_at');
                    },
                ])
                ->orderBy('orders.created_at')
                ->first();

        return $order;
    }

    public static function getListOrderByUserId($userId)
    {
        $orders = self::where('orders.user_id', '=', $userId)
                ->whereNull('orders.deleted_at')
                ->where('users.status', STATUS_ENABLE)
                ->select(
                    'orders.id',
                    'orders.order_code',
                    'orders.transaction_id',
                    'orders.user_id',
                    'orders.order_name',
                    'orders.order_address',
                    'orders.order_email',
                    'orders.order_phone',
                    'orders.order_monney',
                    'orders.order_message',
                    'orders.order_status',
                    'orders.created_at'
                )
                ->join('order_details', 'order_details.order_id', 'orders.id')
                ->join('users', 'orders.user_id', 'users.id')
                ->with([
                    'orderDetail' => function ($orderDetail) {
                        $orderDetail->whereNull('order_details.deleted_at');
                    },
                ])
                ->orderBy('orders.created_at')
                ->get();

        return $orders;
    }
}
