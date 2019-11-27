@extends('frontend.layouts.app')
@section('cssCustom')
@endsection
@section('title')
    Order detail
@endsection
@section('content')
    <div class="ads-grid box-order" style="margin-top: 20px">
        <div class="container" style="padding: 0;">
            <div class="row">
                <div class="col-sm-12">
                    @include('frontend.layouts.side_bar.account_side_bar')
                    <div class="col-md-9">
                        <div class="order-detail-lable" data-spm-anchor-id="">
                            <a>Order Details</a>
                        </div>
                        <div class="row box-info-order">
                            <div id="root_{{ $orderCode }}" class="page-root">
                                <div class="detail-info" data-spm-anchor-id="">
                                    <div class="pull-left detail-info-left">
                                        <div>
                                            <p class="order-number">Order&nbsp;<span class="order-code">{{ $orderCode }}</span></p>
                                            <p class="text desc light-gray">Placed on {{ date('d M Y H:i:s', strtotime($order->created_at)) }}</p>
                                        </div>
                                    </div>
                                    <div class="detail-right-info pull-right">
                                        <span class="detail-info-total-title">Total:&nbsp;</span>
                                        <span class="detail-info-total-value item_price">{{ \App\Helpers\Helper::loadMoney($order->order_monney) }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row box-info-order">
                            <div class="rootBody_{{ $orderCode }} page-root">
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
                        <div class="row box-info-order">
                            <div class="rootBottom rootBottom_{{ $orderCode }}">
                                <div class="col-sm-6 pull-left">
                                    <div class="row col-sm-12 page-root box-info-order">
                                        <div class="delivery-wrapper">
                                            <h3 class="title">Shipping Address</h3>
                                            <span class="username">{{ $order->order_name }}</span>
                                            <span class="address">
                                                <span class="in-line" style="color: red; font-size: 20px">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                </span>
                                                <span class="in-line">{{ App\Helpers\Helper::loadAddressByWardsId($order->order_address) }}</span>
                                            </span>
                                            <span>Tel: {{ $order->order_phone }}</span>
                                        </div>
                                    </div>
                                    <div class="row col-sm-12 page-root box-info-order">
                                        <div class="delivery-wrapper">
                                            <h3 class="title">Billing Address</h3>
                                            <span class="username">{{ $order->order_name }}</span>
                                            <span class="address">
                                                <span class="in-line" style="color: red; font-size: 20px">
                                                    <i class="fa fa-map-marker" aria-hidden="true"></i>
                                                </span>
                                                <span class="in-line">{{ App\Helpers\Helper::loadAddressByWardsId($order->order_address) }}</span>
                                            </span>
                                            <span>Tel: {{ $order->order_phone }}</span>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-sm-6 pull-right page-root">
                                    <div class="delivery-wrapper main-total" data-spm-anchor-id="a2o4n.order_details.0.i1.49ea5d0a0UlG0p">
                                        <h3 class="title" data-spm-anchor-id="a2o4n.order_details.0.i0.49ea5d0a0UlG0p">Total Summary</h3>
                                        <div class="row col-sm-12 subtotal" data-spm-anchor-id="a2o4n.order_details.0.i4.49ea5d0a0UlG0p">
                                            <div class="total-order">
                                                <div class="col-sm-6 pull-left" style="padding: 0">
                                                    <span class="text pull-left" data-spm-anchor-id="a2o4n.order_details.0.i3.49ea5d0a0UlG0p">Subtotal</span>
                                                </div>
                                                <div class="col-sm-6 pull-right" style="padding: 0">
                                                    <span class="text price pull-right item_price">{{ App\Helpers\Helper::loadMoney($order->order_monney) }}</span>
                                                </div>
                                            </div>
                                            <div class="total-order">
                                                <div class="col-sm-6 pull-left" style="padding: 0">
                                                    <span class="text pull-left">Shipping Fee</span>
                                                </div>
                                                <div class="col-sm-6 pull-right" style="padding: 0">
                                                    <span class="text price pull-right item_price">{{ App\Helpers\Helper::loadMoney(0) }}</span>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row col-sm-12 total">
                                            <div class="total-order">
                                                <div class="col-sm-6 pull-left" style="padding: 0">
                                                    <span class="text bold pull-left">Total</span>
                                                </div>
                                                <div class="col-sm-6 pull-right" style="padding: 0">
                                                    <span class="text bold total-price pull-right item_price">{{ App\Helpers\Helper::loadMoney($order->order_monney) }}</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
@endsection
