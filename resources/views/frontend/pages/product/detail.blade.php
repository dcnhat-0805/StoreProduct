@extends('frontend.layouts.app')
@section('metaDescription')
    <meta name="description" content="{{ $product->product_meta_description }}">
@endsection
@section('metaTitle')
    <meta name="title" content="{{ $product->product_meta_title }}">
@endsection
@section('title')
    {{ $product->product_description }}
@endsection
@section('cssCustom')
    <link href="frontend/assets/css/popuo-box.css" rel="stylesheet" type="text/css" media="all"/>
    <link rel="stylesheet" href="frontend/assets/css/flexslider.css" type="text/css" media="screen"/>
@endsection
@section('content')
    @php
        $user = Auth::user();
    @endphp

    @include('frontend.layouts.header_top', [
        'titleName' => isset($titleName) && $titleName ? $titleName : null,
        'namePage' => null,
    ])

    @include('frontend.layouts.banner')

    @include('frontend.layouts.logo')

    <!-- Detail Products -->
    <div class="banner-bootom-w3-agileits">
        <div class="container">
            <!-- //tittle heading -->
            <div class="col-md-5 single-right-left ">
                <div class="grid images_3_of_2">
                    <div class="jsFlexSlider">
                        <ul class="slides">
                            @if(isset($product->product_image) && $product->product_image !== '0' && file_exists(FILE_PATH_PRODUCT . $product->product_image))
                                <li data-thumb="{{ FILE_PATH_PRODUCT . $product->product_image }}">
                                    <div class="thumb-image">
                                        <img src="{{ FILE_PATH_PRODUCT . $product->product_image }}"
                                             data-imagezoom="true" class="img-responsive" alt="">
                                    </div>
                                </li>
                            @else
                                <li data-thumb="{{ FILE_PATH_PRODUCT_THUMP }}">
                                    <div class="thumb-image">
                                        <img src="{{ FILE_PATH_PRODUCT_THUMP }}" data-imagezoom="true"
                                             class="img-responsive" alt="">
                                    </div>
                                </li>
                            @endif
                            @foreach($product->productImage as $productImage)
                                @if(isset($productImage->product_image_name) && $productImage->product_image_name !== '0' && file_exists(FILE_PATH_PRODUCT_IMAGE . $productImage->product_image_name))
                                    <li data-thumb="{{ FILE_PATH_PRODUCT_IMAGE . $productImage->product_image_name }}">
                                        <div class="thumb-image">
                                            <img src="{{ FILE_PATH_PRODUCT_IMAGE . $productImage->product_image_name }}"
                                                 data-imagezoom="true" class="img-responsive" alt="">
                                        </div>
                                    </li>
                                @endif
                            @endforeach
                        </ul>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
            <div class="col-md-7 single-right-left simpleCart_shelfItem">
                <h3>{{ $product->product_description }}</h3>
                <div class="jsRating disabled"></div>
                <p>
                        <span class="item_price product-price-item">
                            {{ App\Helpers\Helper::loadMoney($product->product_promotion > 0 ? $product->product_promotion : $product->product_price) }}
                        </span>
                    @if(!empty($product->product_promotion) && $product->product_promotion > 0)
                        <del>{{ App\Helpers\Helper::loadMoney($product->product_price) }}</del>
                    @endif
                </p>

                @if(isset($product->productAttribute))
                    <?php
                    $colors = $product->productAttribute->where('attribute_name', COLOR);
                    $storages = $product->productAttribute->where('attribute_name', STORAGE);
                    $sizes = $product->productAttribute->where('attribute_name', SIZE);
                    $materials = $product->productAttribute->where('attribute_name', MATERIALS);
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
                        <button type="button" class="button btn btn-custon-three btn-primary add-to-cart"
                                data-id="{{ $product->id }}"
                                style="width: 100%; font-size: 20px">
                            Add to cart
                        </button>
                    </div>

                </div>

            </div>
            <div class="clearfix"></div>
        </div>
    </div>

    <div class="featured-section expand-product-content" id="expand-product-content">
        <div class="container">
            <h4 class="label-product-content">Product details of {{ $product->product_description }}</h4>
            <div class="sop-body-product-content" style="height: auto !important;">
                <div class="col-sm-4">
                    <div class="summary">
                        <div class="score"><span class="score-average">{{ $avgRating }}</span><span
                                class="score-max">/{{ MAX_RATING }}</span></div>
                        <div class="jsRatingUser disabled"></div>
                        <div class="count">{{ $countRating }} Ratings</div>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="jsRatingUserDetail">
                        <div class="jsRatingUserDetail5 disabled"></div><span>{{ App\Helpers\Helper::getCountRatingByProductIdAndPoint($product->id, RATING_POINT[5]) }}</span>
                        <div class="jsRatingUserDetail4 disabled"></div><span>{{ App\Helpers\Helper::getCountRatingByProductIdAndPoint($product->id, RATING_POINT[4]) }}</span>
                        <div class="jsRatingUserDetail3 disabled"></div><span>{{ App\Helpers\Helper::getCountRatingByProductIdAndPoint($product->id, RATING_POINT[3]) }}</span>
                        <div class="jsRatingUserDetail2 disabled"></div><span>{{ App\Helpers\Helper::getCountRatingByProductIdAndPoint($product->id, RATING_POINT[2]) }}</span>
                        <div class="jsRatingUserDetail1 disabled"></div><span>{{ App\Helpers\Helper::getCountRatingByProductIdAndPoint($product->id, RATING_POINT[1]) }}</span>
                    </div>
                </div>
                <div class="col-sm-4">
                    <div class="sop-main-question">
                        <div class="title__question text-center">You have problems need advice?</div>

                        <div class="btn-show__form-question text-center">
                            <button class="btn btn-custon-three btn-primary btnShowFormQuestion" {{ !$user ? 'disabled' : '' }}>Send question</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment-form sop__comment_form">
                <form action="" class="comment_form__client">
                    <div class="col-sm-8 pull-left">
                        <div class="product-rating">
                            <div>How much do you rate this product ?</div>
                            <input type="hidden" class="product_id" name="product_id" value="{{ $product->id }}">
                            <div class="jsRatingComment {{ !$user ? 'disabled' : '' }}"></div>
                        </div>
                        <div class="comment-content-text">
                            <textarea name="comment_contents" id="comment_contents"
                                      placeholder="Please leave a review, a comment..." rows="5"></textarea>
                        </div>
{{--                        <div class="comment-name-and-email">--}}
{{--                            <input class="form-group" type="text" name="name" id="name" placeholder="Họ và Tên...">--}}
{{--                            <input class="form-group" type="text" name="phone" id="phone" placeholder="Số siện thoại">--}}
{{--                            <input class="form-group" type="email" name="email" id="email" placeholder="Email">--}}
{{--                        </div>--}}
                    </div>
                    <div class="col-sm-4 comment-btn">
                        <button type="submit" class="btn btn-custon-three btn-success" id="btnSendComment">
                            <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Send
                        </button>
                        <button id="closeCommentForm" class="btn btn-custon-three btn-danger">
                            <i class="fa fa-remove" aria-hidden="true"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
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
                <div class="form-question">
                    <form action="">
                        <textarea rows="4" cols="50" placeholder="Describe yourself here..."></textarea>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- //top products -->
    @if(isset($products) && count($products) > 3)
        @php
            $arrayRandom = App\Helpers\Helper::randomArrayKey($products);
        @endphp
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
                        @foreach($products as $key => $product)
                            @if(in_array($product->id, $arrayRandom))
                                <li>
                                    <div class="w3l-specilamk">
                                        <div class="speioffer-agile">
                                            @if(isset($product->product_image) && $product->product_image !== '0' && file_exists(FILE_PATH_PRODUCT . $product->product_image))
                                                <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($product->product_description)]) }}">
                                                    <img class="image-product"
                                                         src="{{ FILE_PATH_PRODUCT . $product->product_image }}"
                                                         alt="{{ $product->product_image }}">
                                                </a>
                                            @else
                                                <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($product->product_description)]) }}">
                                                    <img class="image-product" src="{{ FILE_PATH_PRODUCT_THUMP }}"
                                                         alt="{{ $product->product_image }}">
                                                </a>
                                            @endif
                                        </div>
                                        <div class="product-name-w3l">
                                            <h4>
                                                <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($product->product_description)]) }}">{!!  $product->product_description !!}</a>
                                            </h4>
                                            <div class="w3l-pricehkj text-center">
                                            <span class="item_price">
                                                {{ App\Helpers\Helper::loadMoney($product->product_promotion > 0 ? $product->product_promotion : $product->product_price) }}
                                            </span>
                                                @if(!empty($product->product_promotion) && $product->product_promotion > 0)
                                                    <del>{{ App\Helpers\Helper::loadMoney($product->product_price) }}</del>
                                                @endif
                                            </div>
                                            <div
                                                class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                                <button type="button"
                                                        class="button btn btn-custon-three btn-primary add-to-cart"
                                                        data-id="{{ $product->id }}"
                                                        {{--                                                                onclick="window.location.href = '{{ route(FRONT_ADD_CART, ['id' => $product->id]) }}'"--}}
                                                        style="width: 100%; font-size: 20px">
                                                    Add to cart
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            @endif
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    @endif
    <!-- //special offers -->
@endsection

@section('jsCustom')
    <script src="frontend/assets/js/cart.js"></script><!-- js-files -->

    <!-- imagezoom -->
    <script src="frontend/assets/js/imagezoom.js"></script>
    <script src="frontend/assets/js/detail.js"></script>
    <script src="frontend/assets/js/stars.min.js"></script>
    <script>
        $(document).ready(function () {

            const MAX_RATE = 5;
            const MIN_RATE = 1;

            $('.jsRatingComment').stars({
                stars: 5,
                value: {{ $avgRating }},
                click: function (index) {
                    let productId = parseInt($('.product_id').val());

                    if (index >= MIN_RATE && index <= MAX_RATE) {
                        $.ajax({
                            url: '/updateRating',
                            dataType: 'JSON',
                            type: 'POST',
                            data: {
                                productId: productId,
                                point: index
                            },
                            success: function (data) {

                            },
                            error: function (data) {

                            }
                        });
                    }
                }
            });

            $('.jsRating').stars({
                stars: 5,
                value: {{ $ratePoint }},
            });

            $('.jsRatingDetail').stars({
                stars: 5
            });
            $('.jsRatingUser').stars({
                stars: 5,
                value : {{ $avgRating }}
            });

            for (let i = MAX_RATE; i >= MIN_RATE; i--) {
                $('.jsRatingUserDetail' + i).css({
                    'display' : 'inline-block',
                    'white-space' : 'nowrap',
                    'margin-right' : '10px',
                });

                $('.jsRatingUserDetail' + i).stars({
                    stars: 5,
                    value : i,
                });
            }
        });
    </script>
@endsection
