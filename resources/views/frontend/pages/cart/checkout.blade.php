@extends('frontend.layouts.app')
@section('cssCustom')
@endsection
@section('content')
{{--    @include('frontend.layouts.header_top', [--}}
{{--        'titleName' => null,--}}
{{--        'namePage' => null,--}}
{{--    ])--}}

    @php
        $user = Auth::user();
        if (isset($user)) {
            $address = App\Helpers\Helper::getAddressByWardsId($user->address);
        }
    @endphp
    <!-- top Products -->
    <div class="ads-grid box-cart">
        <div class="container" style="padding: 0;">
            <div class="row fixed-table-body" style="padding: 20px 0 0 0;">
                <div class="col-sm-8" style="padding: 0;">
                    <div class="col-sm-12" style="">
                        <form action="">
                            <table id="cartTable" class="table border-table">
                                <thead>
                                <tr>
                                    <th data-field="product" data-editable="true" class="">Product</th>
                                    <th data-field="price" data-editable="true" class="text-center">Price</th>
                                    <th data-field="quantity" data-editable="true" class="text-center">Quantity</th>
                                    <th data-field="total" data-editable="true" class="text-center">Total</th>
                                    <th data-field="action" class="text-center deleteParent">
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="list-cart mod-list-cart">
                                @if(isset($carts))
                                    @foreach($carts as $cart)
                                        <tr id="cart-{{ $cart->id }}">
                                            <td class="text-center col-sm-4">
                                                <div class="cart-product-name col-sm-10 text-left">
                                                    <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($cart->options->description)]) }}">{{ $cart->options->description }}</a>
                                                </div>
                                                <div class="col-sm-10">
                                                    <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($cart->options->description)]) }}" class="" style="padding: 0; float: left">
                                                        <img src="{{ FILE_PATH_PRODUCT . $cart->options->image }}" alt="" style="width: 50px; height: 30px; object-fit: scale-down;">
                                                    </a>
                                                    <div class="col">
                                                        @if($cart->options->color)
                                                            <div data-color="{{ $cart->options->color }}"
                                                                 style="background-color: {{ $cart->options->color }};"
                                                                 class="attribute-item size-item size"></div>
                                                        @endif
                                                        @if($cart->options->size)
                                                            <div data-size="{{ $cart->options->size }}"
                                                                 style="background-color: #fff;"
                                                                 class="attribute-item size-item size">{{ $cart->options->size }}</div>
                                                        @endif
                                                        @if($cart->options->storage)
                                                            <div data-storage="{{ $cart->options->storage }}"
                                                                 style="background-color: #fff;"
                                                                 class="attribute-item size-item size">{{ $cart->options->storage }}</div>
                                                        @endif
                                                        @if($cart->options->material)
                                                            <div data-material="{{ $cart->options->material }}"
                                                                 style="background-color: #fff; width: auto; padding: 0 4px;"
                                                                 class="attribute-item size-item size">{{ $cart->options->material }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="cart-price">
                                                    <span class="cart-item-price cart-item-price-before item_price">
                                                        {{ App\Helpers\Helper::loadMoney($cart->price) }}
                                                    </span>

                                                    @if(!empty($cart->options->promotion) && $cart->options->promotion > 0)
                                                        <del>{{ App\Helpers\Helper::loadMoney($cart->options->promotion) }}</del>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <span>Qty: {{ $cart->qty }}</span>
                                            </td>
                                            <td class="text-center"
                                                style="padding-left: 0 !important; padding-right: 0 !important;">
                                                <span
                                                    class="cart-total-price item_price subtotal-{{ $cart->id }}">{{ App\Helpers\Helper::loadMoney($cart->price * $cart->qty) }}</span>
                                                {{--                                        <span class="cart-total-price item_price">{{ App\Helpers\Helper::loadMoney(Cart::subtotal(2,'.','')) }}</span>--}}
                                            </td>
                                            <td class="datatable-ct text-center">
                                                @if(count($carts))
                                                    <button data-toggle="modal" title="Delete cart" class="pd-setting-ed"
                                                            data-original-title="Trash" data-target="#deleteCart" data-id="1"
                                                            data-row_id="{{ $cart->rowId }}"
                                                            type="button"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>

                            @if (!$carts)
                                <div class="not-cart" style="margin-top: 10%">
                                    <div class="text-not-cart text-center pb-2">There are no items in this cart</div>
                                    <div class="button-back-home text-center">
                                        <a class="btn btn-custon-three btn-primary btn-block cart-list"
                                           href="{{ route(FRONT_END_HOME_INDEX) }}"
                                           style="width: 30%; text-transform: uppercase;">
                                            continue shopping
                                        </a>
                                    </div>
                                </div>
                            @endif
                        </form>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="col-sm-12 cart-sidebar-right">
                        <form action="{{ route(FRONT_PURCHASE) }}" method="POST" id="purchase_form">
                            @csrf
                            <div class="summary-section">
                                <div class="summary-section-heading">Shipping & Billing</div>
                                <div class="summary-section-content">
                                    <div class="checkout-summary">
                                        <div class="form-address-check-count name">
                                            <div class="col-sm-2">
                                                <lable for="name" class="form-address-check-count-lable"><i class="fa fa-user" aria-hidden="true"></i></lable>
                                            </div>
                                            <div class="col-sm-10" style="padding: 0; margin-bottom: 20px;">
                                                <input type="text" id="name" class="address-user-checkout" name="name" placeholder="Enter your name" value="{{ isset($user) ? $user->name : null }}">
                                            </div>
                                        </div>
                                        <div class="form-address-check-count email">
                                            <div class="col-sm-2">
                                                <lable for="email" class="form-address-check-count-lable"><i class="fa fa-envelope-o" aria-hidden="true"></i></lable>
                                            </div>
                                            <div class="col-sm-10" style="padding: 0; margin-bottom: 20px;">
                                                <input type="text" id="email" class="address-user-checkout" name="email" placeholder="Enter your email" value="{{ isset($user) ? $user->email : null }}">
                                            </div>
                                        </div>
                                        <div class="form-address-check-count phone">
                                            <div class="col-sm-2">
                                                <lable for="phone" class="form-address-check-count-lable"><i class="fa fa-phone-square" aria-hidden="true"></i></lable>
                                            </div>
                                            <div class="col-sm-10" style="padding: 0; margin-bottom: 20px;">
                                                <input type="tel" id="phone" class="address-user-checkout" name="phone" placeholder="Enter your phone" value="{{ isset($user) ? $user->phone : null }}">
                                            </div>
                                        </div>
                                        <div class="form-address-check-count address">
                                            <div class="col-sm-2">
                                                <lable for="address" class="form-address-check-count-lable"><i class="fa fa-map-marker" aria-hidden="true"></i></lable>
                                            </div>
                                            <div class="col-sm-10" style="padding: 0; margin-bottom: 30px;">
                                                <div class="col-sm-4 city" style="padding: 0;">
                                                    {{
                                                        Form::select('city', $cities, isset($address->cityId) ? $address->cityId : old('city'),
                                                        [
                                                            'class' => 'form-control jsSelectCity address-user-checkout'
                                                        ])
                                                    }}
                                                </div>
                                                <div class="col-sm-4 district" style="padding: 0;">
                                                    {{
                                                        Form::select('district', $districts, isset($address->districtId) ? $address->districtId : old('district'),
                                                        [
                                                            'class' => 'form-control jsSelectDistrict address-user-checkout'
                                                        ])
                                                    }}
                                                </div>
                                                <div class="col-sm-4 wards" style="padding: 0;">
                                                    {{
                                                        Form::select('wards', $wards, isset($address->wardsId) ? $address->wardsId : old('wards'),
                                                        [
                                                            'class' => 'form-control jsSelectWards address-user-checkout'
                                                        ])
                                                    }}
                                                    <span class="address-user-checkout__error">Please select the shipping address.</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="summary-section">
                                <div class="summary-section-heading">Order Summary</div>
                                <div class="summary-section-content">
                                    <div class="  checkout-summary">
                                        <div class="checkout-summary-rows">
                                            <div class="checkout-summary-row">
                                                <div class="checkout-summary-label">Subtotal ( <span class="total-checkcount-items" style="margin: 0 2px">{{ count($carts) }}</span> items )</div>
                                                <div class="checkout-summary-value">
                                                    <span class="checkout-summary-noline-value item_price subtotal-checkcount-price">{{ App\Helpers\Helper::loadMoney($total) }}</span>
                                                </div>
                                            </div>
                                            <div class="checkout-summary-row">
                                                <div class="checkout-summary-label">Shipping Fee</div>
                                                <div class="checkout-summary-value">
                                                    <span class="checkout-summary-noline-value item_price">0 ₫</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="voucher-input">
                                            <div class="voucher-input-inner">
                                                <div class="voucher-input-col">
                                                    <span class="next-input next-input-single next-input-medium clear voucher-input-control">
                                                        <input type="text" id="automation-voucher-input"
                                                               placeholder="Enter Voucher Code" value=""
                                                               height="100%">
                                                    </span>
                                                </div>
                                                <div class="voucher-input-col">
                                                    <button id="automation-voucher-input-button" type="button"
                                                            class="next-btn next-btn-normal next-btn-large voucher-input-button btn btn-custon-three btn-primary">
                                                        APPLY
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class=" checkout-order-total">
                                            <div class="checkout-order-total-row">
                                                <div class="checkout-order-total-title">Total</div>
                                                <div class="checkout-order-total-fee">
                                                    <input type="hidden" name="total_qty" value="{{ $quantity }}">
                                                    <input type="hidden" name="total_price" value="{{ $total }}">
                                                    <span class="total-checkout-price item_price">{{ App\Helpers\Helper::loadMoney($total) }}</span>
                                                    <small class="checkout-order-total-fee-tip">VAT included, where
                                                        applicable</small>
                                                </div>
                                            </div>
                                            <input type="hidden" name="row_id_checkout" class="row_id_checkout">
                                            <button id="btn-place-order" class="next-btn checkout-order-total-button automation-checkout-order-total-button-button btn btn-custon-three btn-warning btn-place-order">
                                                Place Order
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //top products -->

    <!-- delete Modal-->
    <div class="modal" id="deleteCart" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="min-height: 70px;">
                        <input type="hidden" name="id" id="rowId">
                        <h5 class="modal-title" id="exampleModalLabel" style="line-height: 70px; text-align: center">
                            Do you want to delete this product from the cart ?
                        </h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success btnDeleteCart" id="btnDeleteCart"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
                    <button class="btn btn-custon-three btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times edu-danger-error" aria-hidden="true"></i> No</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jsCustom')
    <script src="frontend/assets/js/cart.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CheckCountRequest', '#purchase_form') !!}
@endsection
