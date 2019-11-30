@extends('frontend.layouts.app')
@section('cssCustom')
@endsection
@section('title')
    My Orders
@endsection
@section('content')
    <div class="ads-grid box-order" style="margin-top: 20px">
        <div class="container" style="padding: 0;">
            <!-- tittle heading -->
{{--            <h3 class="tittle-w3l">My Orders--}}

{{--                <span class="heading-style">--}}
{{--					<i></i>--}}
{{--					<i></i>--}}
{{--					<i></i>--}}
{{--				</span>--}}
{{--            </h3>--}}

            <div class="row">
                <div class="col-sm-12">
                    @include('frontend.layouts.side_bar.account_side_bar')
                    <div class="col-md-9">
                        <div class="order-detail-lable" data-spm-anchor-id="">
                            <a>My Orders</a>
                        </div>
                        @if(!empty($orders))
                            @foreach($orders as $order)
                                <div class="order-{{ $order->order_code }} box-info-order">
                                    <div class="row order-header">
                                        <div id="root_{{ $order->order_code }}" class="page-root">
                                            <div class="detail-info" data-spm-anchor-id="">
                                                <div class="pull-left detail-info-left">
                                                    <div>
                                                        <p class="order-number">Order&nbsp;<span class="order-code">{{ $order->order_code }}</span></p>
                                                        <p class="text desc light-gray">Placed on {{ date('d M Y H:i:s', strtotime($order->created_at)) }}</p>
                                                    </div>
                                                </div>
                                                <div class="detail-right-info pull-right">
                                                    @if($order->order_status == PENDING)
                                                        <a href="{{ route(FRONT_ORDER_CANCEL, ['code' => $order->order_code, 'sop' => $order->order_email]) }}">CANCEL</a>
                                                    @endif
                                                    <a href="{{ route(FRONT_ORDER_DETAIL, ['code' => $order->order_code, 'sop' => $order->order_email]) }}">MANAGE</a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row order-body">
                                        <div class="rootBody_{{ $order->order_code }} page-root">
                                        @if(!empty($order->orderDetail))
                                            @foreach($order->orderDetail as $key => $orderDetail)
                                                @php
                                                    $options = unserialize($orderDetail->options);
                                                @endphp
                                                <div class="order-detail-{{ $key }}">
                                                    <div class="col-sm-8">
                                                        <div class="order-image col-sm-2">
                                                            @if(isset($options['image']) && $options['image'] !== '0' && file_exists('/backend/images/uploads/product/' . $options['image']))
                                                                <img src="/backend/images/uploads/product/{{ $options['image'] }}" alt="" class="image-detail">
                                                            @else
                                                                <img src="{{ FILE_PATH_PRODUCT_THUMP }}" alt="" class="image-detail">
                                                            @endif
                                                        </div>
                                                        <div class="order-name col-sm-10">
                                                            <div class="title name">
                                                                <a>{{ $options['description'] }}</a>
                                                            </div>
                                                            <div class="title info">
                                                                <p class="text desc light-gray">{{ date('m', strtotime($order->created_at)) }} Months Invoice</p>
                                                            </div>
                                                            @if($options['color'])
                                                                <div data-color="{{ $options['color'] }}"
                                                                     style="background-color: {{ $options['color'] }};"
                                                                     class="attribute-item size-item size"></div>
                                                            @endif
                                                            @if($options['size'])
                                                                <div data-size="{{ $options['size'] }}"
                                                                     style="background-color: #fff;"
                                                                     class="attribute-item size-item size">{{ $options['size'] }}</div>
                                                            @endif
                                                            @if($options['storage'])
                                                                <div data-storage="{{ $options['storage'] }}"
                                                                     style="background-color: #fff;"
                                                                     class="attribute-item size-item size">{{ $options['storage'] }}</div>
                                                            @endif
                                                            @if($options['material'])
                                                                <div data-material="{{ $cart->options->material }}"
                                                                     style="background-color: #fff;"
                                                                     class="attribute-item size-item size">{{ $options['material'] }}</div>
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="order-total">
                                                            <span class="detail-info-total-value item_price">{{ App\Helpers\Helper::loadMoney($orderDetail->amount) }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2">
                                                        <div class="order-quantity">
                                                            <span class="detail-info-total-title">Qty:&nbsp;</span>
                                                            <span class="detail-info-total-value">{{ $orderDetail->quantity }}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
@endsection
