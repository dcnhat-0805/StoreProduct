<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = [
        'order_code', 'transaction_id', 'cart_row_id', 'user_id', 'order_name', 'order_address', 'order_email', 'order_phone', 'order_monney', 'order_message', 'order_status',
    ];

    public function User(){
        return $this->belongsTo('App\Models\User','user_id','id');
    }

    public function orderDetail(){
        return $this->hasMany('App\Models\orderDetail','order_id','id');
    }
}
