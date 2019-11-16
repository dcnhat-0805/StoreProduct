@extends('frontend.layouts.app')
@section('cssCustom')
    <link href="frontend/assets/css/popuo-box.css" rel="stylesheet" type="text/css" media="all" />
    <link rel="stylesheet" href="frontend/assets/css/flexslider.css" type="text/css" media="screen" />
@endsection
@section('content')
    @include('frontend.layouts.header_top', [
        'titleName' => isset($titleName) && $titleName ? $titleName : null,
        'namePage' => null,
    ])

    @include('frontend.layouts.banner')


    @include('frontend.layouts.logo')

    <!-- Detail Products -->
    <div class="banner-bootom-w3-agileits">
        <div class="container">
            <!-- tittle heading -->
{{--            <h3 class="tittle-w3l">Single Page--}}
{{--                <span class="heading-style">--}}
{{--					<i></i>--}}
{{--					<i></i>--}}
{{--					<i></i>--}}
{{--				</span>--}}
{{--            </h3>--}}
            <!-- //tittle heading -->
            <div class="col-md-5 single-right-left ">
                <div class="grid images_3_of_2">
                    <div class="jsFlexSlider">
                        <ul class="slides">
                            <li data-thumb="{{ FILE_PATH_PRODUCT . $product->product_image }}">
                                <div class="thumb-image">
                                    <img src="{{ FILE_PATH_PRODUCT . $product->product_image }}" data-imagezoom="true" class="img-responsive" alt="">
                                </div>
                            </li>
                            @foreach($product->productImage as $productImage)
                                <li data-thumb="{{ FILE_PATH_PRODUCT_IMAGE . $productImage->product_image_name }}">
                                    <div class="thumb-image">
                                        <img src="{{ FILE_PATH_PRODUCT_IMAGE . $productImage->product_image_name }}" data-imagezoom="true" class="img-responsive" alt="">
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 single-right-left simpleCart_shelfItem">
                <h3>{{ $product->product_name }}</h3>
                <div class="rating1">
					<span class="starRating">
						<input id="rating5" type="radio" name="rating" value="5">
						<label for="rating5">5</label>
						<input id="rating4" type="radio" name="rating" value="4">
						<label for="rating4">4</label>
						<input id="rating3" type="radio" name="rating" value="3" checked="">
						<label for="rating3">3</label>
						<input id="rating2" type="radio" name="rating" value="2">
						<label for="rating2">2</label>
						<input id="rating1" type="radio" name="rating" value="1">
						<label for="rating1">1</label>
					</span>
                    </div>
                    <p>
                        <span class="item_price product-price-item">{{ App\Helpers\Helper::loadMoney($product->product_promotion) }}</span>
                        <del>{{ App\Helpers\Helper::loadMoney($product->product_price) }}</del>
                    </p>

                    @if(count($product->attribute))
                        <?php
                            $colors = $product->attribute->where('attribute_name', COLOR);
                            $storages = $product->attribute->where('attribute_name', STORAGE);
                            $sizes = $product->attribute->where('attribute_name', SIZE);
                            $materials = $product->attribute->where('attribute_name', MATERIALS);
                        ?>
                        @if(count($colors))
                            <div class="attribute-list">
                                <p>
                                <div class="label-attribute">Color Family</div>
                                @foreach($colors as $key => $color)
                                    <div data-color="{{ $color->attribute_item_name }}"
                                         style="background-color: {{ $color->attribute_item_name }};"
                                         class="attribute-item color-item color"></div>
                                    @endforeach
                                </p>
                            </div>
                        @endif
                        @if(count($sizes))
                            <div class="attribute-list">
                                <p>
                                <div class="label-attribute">Size</div>
                                @foreach($sizes as $key => $size)
                                    <div data-size="{{ $size->attribute_item_name }}"
                                         style="background-color: #fff;"
                                         class="attribute-item size-item size">{{ $size->attribute_item_name }}</div>
                                    @endforeach
                                </p>
                            </div>
                        @endif
                        @if(count($storages))
                            <div class="attribute-list">
                                <p>
                                <div class="label-attribute">Storage Capacity</div>
                                @foreach($storages as $key => $storage)
                                    <div data-storage="{{ $storage->attribute_item_name }}"
                                         style="background-color: #fff;"
                                         class="attribute-item storage-item storage">{{ $storage->attribute_item_name }}</div>
                                    @endforeach
                                </p>
                            </div>
                        @endif
                        @if(count($materials))
                            <div class="attribute-list">
                                <p>
                                <div class="label-attribute">Storage Capacity</div>
                                @foreach($materials as $key => $material)
                                    <div data-material="{{ $material->attribute_item_name }}"
                                         style="background-color: #fff;"
                                         class="attribute-item material-item material">{{ $material->attribute_item_name }}</div>
                                    @endforeach
                                </p>
                            </div>
                        @endif
                    @endif

                    <div class="product-single-w3l">
                        <p>
                            <input class="jsQuantity quantity" type="text" name="quantity">
                        </p>
                    </div>
                    <div class="occasion-cart">
                        <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                            <button type="button" class="button btn btn-custon-three btn-primary add-to-cart" data-id="{{ $product->id }}"
                                    style="width: 100%; font-size: 20px">
                                Add to cart
                            </button>
                        </div>

                    </div>

            </div>
            <div class="clearfix"> </div>
        </div>
    </div>

    <div class="featured-section expand-product-content" id="expand-product-content">
        <div class="container">
            <h4 class="label-product-content">Product details of {{ $product->product_description }}</h4>
            <div class="body-product-content">
                {!! $product->product_content !!}
            </div>

            <div class="expand-button-show">
                <button class="button btn btn-custon-three btn-primary btn-view-more">View More</button>
            </div>
        </div>
    </div>

    <div class="featured-section expand-product-question" id="expand-product-question">
        <div class="container">
            <h4 class="label-product-question">Question of {{ $product->product_description }}</h4>
            <div class="body-product-question">
                <div class="mod-title">Questions about this product (9)</div>
{{--                {!! $product->product_content !!}--}}
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
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="Aashirvaad, 5g" />
                                            <input type="hidden" name="amount" value="220.00" />
                                            <input type="hidden" name="discount_amount" value="1.00" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button btn btn-custon-three btn-primary" />
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
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="Kissan Tomato Ketchup, 950g" />
                                            <input type="hidden" name="amount" value="99.00" />
                                            <input type="hidden" name="discount_amount" value="1.00" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button btn btn-custon-three btn-primary" />
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
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="Madhur Pure Sugar, 1g" />
                                            <input type="hidden" name="amount" value="69.00" />
                                            <input type="hidden" name="discount_amount" value="1.00" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button btn btn-custon-three btn-primary" />
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
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="Surf Excel Liquid, 1.02L" />
                                            <input type="hidden" name="amount" value="187.00" />
                                            <input type="hidden" name="discount_amount" value="1.00" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button btn btn-custon-three btn-primary" />
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
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="Cadbury Choclairs, 655.5g" />
                                            <input type="hidden" name="amount" value="160.00" />
                                            <input type="hidden" name="discount_amount" value="1.00" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button btn btn-custon-three btn-primary" />
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
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="Fair & Lovely, 80 g" />
                                            <input type="hidden" name="amount" value="121.60" />
                                            <input type="hidden" name="discount_amount" value="1.00" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button btn btn-custon-three btn-primary" />
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
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="Sprite, 2.25L (Pack of 2)" />
                                            <input type="hidden" name="amount" value="180.00" />
                                            <input type="hidden" name="discount_amount" value="1.00" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button btn btn-custon-three btn-primary" />
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
                                <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                    <form action="#" method="post">
                                        <fieldset>
                                            <input type="hidden" name="cmd" value="_cart" />
                                            <input type="hidden" name="add" value="1" />
                                            <input type="hidden" name="business" value=" " />
                                            <input type="hidden" name="item_name" value="Lakme Eyeconic Kajal, 0.35 g" />
                                            <input type="hidden" name="amount" value="153.00" />
                                            <input type="hidden" name="discount_amount" value="1.00" />
                                            <input type="hidden" name="currency_code" value="USD" />
                                            <input type="hidden" name="return" value=" " />
                                            <input type="hidden" name="cancel_return" value=" " />
                                            <input type="submit" name="submit" value="Add to cart" class="button btn btn-custon-three btn-primary" />
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
@endsection

@section('jsCustom')
    <script src="frontend/assets/js/cart.js"></script><!-- js-files -->

    <!-- imagezoom -->
    <script src="frontend/assets/js/imagezoom.js"></script>
    <script src="frontend/assets/js/detail.js"></script>
@endsection
