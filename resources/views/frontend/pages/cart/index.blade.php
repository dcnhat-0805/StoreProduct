@extends('frontend.layouts.app')
@section('cssCustom')
@endsection
@section('content')
    @include('frontend.layouts.header_top', [
        'titleName' => null,
        'namePage' => 'Cart',
    ])

    <!-- top Products -->
    <div class="ads-grid box-cart">
        <div class="container" style="padding: 0;">
            <!-- tittle heading -->
            <h3 class="tittle-w3l">My Cart

                <span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
            </h3>
            <div class="row fixed-table-body" style="padding: 0;">
                <div class="col-sm-9" style="padding: 0;">
                    <div class="col-sm-12" style="">
                        <form action="">
                            <table id="cartTable" class="table border-table">
                                <thead>
                                <tr>
                                    <th data-field="state" data-checkbox="true">
                                        <div class="selectItem">
                                            <input type="checkbox" name="cartSelectAll" class="cartSelectAll">
                                        </div>
                                    </th>
                                    <th data-field="product" data-editable="true" class="text-center">Product</th>
                                    <th data-field="price" data-editable="true" class="text-center">Price</th>
                                    <th data-field="quantity" data-editable="true" class="text-center">Quantity</th>
                                    <th data-field="total" data-editable="true" class="text-center">Total</th>
                                    <th data-field="action" class="text-center deleteParent">
                                        <button data-toggle="modal" title="Delete cart" class="pd-setting-ed deleteAllCart"
                                                data-original-title="Trash" data-target="#deleteCart" data-id="1"
                                                type="button"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="list-cart mod-list-cart">
                                @if(isset($carts))
                                    @foreach($carts as $cart)
                                        <tr id="cart-{{ $cart->rowId }}">
                                            <td>
                                                <div class="selectItem">
                                                    <input type="checkbox" name="cartSelectItem"
                                                           class="cartSelectItem" data-num="{{ $cart->id }}"
                                                           id="item-{{ $cart->id }}" data-row_id="{{ $cart->rowId }}">
                                                </div>
                                            </td>
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
                                                                 style="background-color: #fff;"
                                                                 class="attribute-item size-item size">{{ $cart->options->material }}</div>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <div class="cart-price">
                                                    <span
                                                        class="cart-item-price cart-item-price-before item_price">{{ App\Helpers\Helper::loadMoney($cart->price) }}</span>
                                                    <del>{{ App\Helpers\Helper::loadMoney($cart->options->promotion) }}</del>
                                                </div>
                                            </td>
                                            <td class="text-center">
                                                <input class="jsTouchSpin quantity-{{ $cart->rowId }}" type="text"
                                                       value="{{ $cart->qty }}" readonly
                                                       name="quantity" data-row_id="{{ $cart->rowId }}">
                                            </td>
                                            <td class="text-center"
                                                style="padding-left: 0 !important; padding-right: 0 !important;">
                                                <span
                                                    class="cart-total-price item_price subtotal-{{ $cart->rowId }}">{{ App\Helpers\Helper::loadMoney($cart->price * $cart->qty) }}</span>
                                                {{--                                        <span class="cart-total-price item_price">{{ App\Helpers\Helper::loadMoney(Cart::subtotal(2,'.','')) }}</span>--}}
                                            </td>
                                            <td class="datatable-ct text-center">
                                                <button data-toggle="modal" title="Delete cart" class="pd-setting-ed"
                                                        data-original-title="Trash" data-target="#deleteCart" data-id="1"
                                                        data-row_id="{{ $cart->rowId }}"
                                                        type="button"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif
                                </tbody>
                            </table>

                            @if (!Cart::count())
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
                <div class="col-sm-3">
                    <div class="col-sm-12 cart-sidebar-right">
                        <form action="{{ route(FRONT_CHECK_COUNT_CART) }}" method="POST">
                            @csrf
                            <div class="row col-sm-12 location-box">
                                <div class="col-sm-12">
                                    <div class="location-label">Location</div>
                                    <div class="location-body">
                                        <i class="fa fa-map-marker location-icon" aria-hidden="true"></i>
                                        <div class="location-address">
                                            Hà Nội, Huyện Gia Lâm, Thị trấn Trâu Quỳ
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
                                                <div class="checkout-summary-label">Subtotal ( <span class="total-items" style="margin: 0 2px">0</span> items )</div>
                                                <div class="checkout-summary-value">
                                                    <span class="checkout-summary-noline-value item_price subtotal-price">0 ₫</span>
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
                                                    <span class="total-price item_price">0 ₫</span>
                                                    <small class="checkout-order-total-fee-tip">VAT included, where
                                                        applicable</small>
                                                </div>
                                            </div>
                                            <input type="hidden" name="row_id_checkout" class="row_id_checkout">
                                            <button type="submit" class="next-btn checkout-order-total-button automation-checkout-order-total-button-button btn btn-custon-three btn-warning">
                                                CONFIRM CART
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
    <!-- special offers -->
    <div class="featured-section" id="projects">
        <div class="container">
            <!-- tittle heading -->
            <h3 class="tittle-w3l">Special Offers
                <span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
            </h3>
            <!-- //tittle heading -->
            <div class="content-bottom-in">
                <ul id="jsFleiselCustom">
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="single.html">
                                    <img src="frontend/assets/images/s1.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="single.html">Aashirvaad, 5g</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>$220.00</h6>
                                    <p>Save $40.00</p>
                                </div>
                                <div
                                    class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart"/>
                                            <input type="hidden" name="add" value="1"/>
                                            <input type="hidden" name="business" value=" "/>
                                            <input type="hidden" name="item_name" value="Aashirvaad, 5g"/>
                                            <input type="hidden" name="amount" value="220.00"/>
                                            <input type="hidden" name="discount_amount" value="1.00"/>
                                            <input type="hidden" name="currency_code" value="USD"/>
                                            <input type="hidden" name="return" value=" "/>
                                            <input type="hidden" name="cancel_return" value=" "/>
                                            <input type="submit" name="submit" value="Add to cart"
                                                   class="button btn btn-custon-three btn-primary"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="single.html">
                                    <img src="frontend/assets/images/s4.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="single.html">Kissan Tomato Ketchup, 950g</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>$99.00</h6>
                                    <p>Save $20.00</p>
                                </div>
                                <div
                                    class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart"/>
                                            <input type="hidden" name="add" value="1"/>
                                            <input type="hidden" name="business" value=" "/>
                                            <input type="hidden" name="item_name" value="Kissan Tomato Ketchup, 950g"/>
                                            <input type="hidden" name="amount" value="99.00"/>
                                            <input type="hidden" name="discount_amount" value="1.00"/>
                                            <input type="hidden" name="currency_code" value="USD"/>
                                            <input type="hidden" name="return" value=" "/>
                                            <input type="hidden" name="cancel_return" value=" "/>
                                            <input type="submit" name="submit" value="Add to cart"
                                                   class="button btn btn-custon-three btn-primary"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="single.html">
                                    <img src="frontend/assets/images/s2.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="single.html">Madhur Pure Sugar, 1g</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>$69.00</h6>
                                    <p>Save $20.00</p>
                                </div>
                                <div
                                    class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart"/>
                                            <input type="hidden" name="add" value="1"/>
                                            <input type="hidden" name="business" value=" "/>
                                            <input type="hidden" name="item_name" value="Madhur Pure Sugar, 1g"/>
                                            <input type="hidden" name="amount" value="69.00"/>
                                            <input type="hidden" name="discount_amount" value="1.00"/>
                                            <input type="hidden" name="currency_code" value="USD"/>
                                            <input type="hidden" name="return" value=" "/>
                                            <input type="hidden" name="cancel_return" value=" "/>
                                            <input type="submit" name="submit" value="Add to cart"
                                                   class="button btn btn-custon-three btn-primary"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="single2.html">
                                    <img src="frontend/assets/images/s3.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="single2.html">Surf Excel Liquid, 1.02L</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>$187.00</h6>
                                    <p>Save $30.00</p>
                                </div>
                                <div
                                    class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart"/>
                                            <input type="hidden" name="add" value="1"/>
                                            <input type="hidden" name="business" value=" "/>
                                            <input type="hidden" name="item_name" value="Surf Excel Liquid, 1.02L"/>
                                            <input type="hidden" name="amount" value="187.00"/>
                                            <input type="hidden" name="discount_amount" value="1.00"/>
                                            <input type="hidden" name="currency_code" value="USD"/>
                                            <input type="hidden" name="return" value=" "/>
                                            <input type="hidden" name="cancel_return" value=" "/>
                                            <input type="submit" name="submit" value="Add to cart"
                                                   class="button btn btn-custon-three btn-primary"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="single.html">
                                    <img src="frontend/assets/images/s8.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="single.html">Cadbury Choclairs, 655.5g</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>$160.00</h6>
                                    <p>Save $60.00</p>
                                </div>
                                <div
                                    class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart"/>
                                            <input type="hidden" name="add" value="1"/>
                                            <input type="hidden" name="business" value=" "/>
                                            <input type="hidden" name="item_name" value="Cadbury Choclairs, 655.5g"/>
                                            <input type="hidden" name="amount" value="160.00"/>
                                            <input type="hidden" name="discount_amount" value="1.00"/>
                                            <input type="hidden" name="currency_code" value="USD"/>
                                            <input type="hidden" name="return" value=" "/>
                                            <input type="hidden" name="cancel_return" value=" "/>
                                            <input type="submit" name="submit" value="Add to cart"
                                                   class="button btn btn-custon-three btn-primary"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="single2.html">
                                    <img src="frontend/assets/images/s6.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="single2.html">Fair & Lovely, 80 g</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>$121.60</h6>
                                    <p>Save $30.00</p>
                                </div>
                                <div
                                    class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart"/>
                                            <input type="hidden" name="add" value="1"/>
                                            <input type="hidden" name="business" value=" "/>
                                            <input type="hidden" name="item_name" value="Fair & Lovely, 80 g"/>
                                            <input type="hidden" name="amount" value="121.60"/>
                                            <input type="hidden" name="discount_amount" value="1.00"/>
                                            <input type="hidden" name="currency_code" value="USD"/>
                                            <input type="hidden" name="return" value=" "/>
                                            <input type="hidden" name="cancel_return" value=" "/>
                                            <input type="submit" name="submit" value="Add to cart"
                                                   class="button btn btn-custon-three btn-primary"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="single.html">
                                    <img src="frontend/assets/images/s5.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="single.html">Sprite, 2.25L (Pack of 2)</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>$180.00</h6>
                                    <p>Save $30.00</p>
                                </div>
                                <div
                                    class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart"/>
                                            <input type="hidden" name="add" value="1"/>
                                            <input type="hidden" name="business" value=" "/>
                                            <input type="hidden" name="item_name" value="Sprite, 2.25L (Pack of 2)"/>
                                            <input type="hidden" name="amount" value="180.00"/>
                                            <input type="hidden" name="discount_amount" value="1.00"/>
                                            <input type="hidden" name="currency_code" value="USD"/>
                                            <input type="hidden" name="return" value=" "/>
                                            <input type="hidden" name="cancel_return" value=" "/>
                                            <input type="submit" name="submit" value="Add to cart"
                                                   class="button btn btn-custon-three btn-primary"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <li>
                        <div class="w3l-specilamk">
                            <div class="speioffer-agile">
                                <a href="single2.html">
                                    <img src="frontend/assets/images/s9.jpg" alt="">
                                </a>
                            </div>
                            <div class="product-name-w3l">
                                <h4>
                                    <a href="single2.html">Lakme Eyeconic Kajal, 0.35 g</a>
                                </h4>
                                <div class="w3l-pricehkj">
                                    <h6>$153.00</h6>
                                    <p>Save $40.00</p>
                                </div>
                                <div
                                    class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart"/>
                                            <input type="hidden" name="add" value="1"/>
                                            <input type="hidden" name="business" value=" "/>
                                            <input type="hidden" name="item_name" value="Lakme Eyeconic Kajal, 0.35 g"/>
                                            <input type="hidden" name="amount" value="153.00"/>
                                            <input type="hidden" name="discount_amount" value="1.00"/>
                                            <input type="hidden" name="currency_code" value="USD"/>
                                            <input type="hidden" name="return" value=" "/>
                                            <input type="hidden" name="cancel_return" value=" "/>
                                            <input type="submit" name="submit" value="Add to cart"
                                                   class="button btn btn-custon-three btn-primary"/>
                                        </fieldset>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- //special offers -->

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
@endsection
