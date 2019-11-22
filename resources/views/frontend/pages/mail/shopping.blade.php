<br>
<strong>Hello! {{ $order->order_name }}</strong>
<br>
<strong>Code orders：{{ $order->order_code }}</strong><br>
<br>
※Thank you for shopping at {{ EMAIL_NAME }}
<br>
Your order is pending shop confirmation(within 24 hours)
<br>
Please check your order regularly.
<br>
[<a href="{{ route(FRONT_SHOPPING_CART, ['order_code' => $order->order_code, 'email' => $order->order_email]) }}">Check orders</a>]
<br>
<br>
────────────────────<br>
※Thank you !<br>
The StoreOnline Team<br>
