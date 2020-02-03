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
        $isRating = \App\Helpers\Helper::isRatingProduct($product->id, $user ? $user->id : null);
        $avgRating = $product->average_rating;
    @endphp

    @include('frontend.layouts.header_top', [
        'titleName' => isset($titleName) && $titleName ? $titleName : null,
        'namePage' => null,
    ])

{{--    @include('frontend.layouts.banner')--}}

{{--    @include('frontend.layouts.logo')--}}

    <!-- Detail Products -->
    <div class="banner-bootom-w3-agileits">
        <div class="container">
            <!-- //tittle heading -->
            <div class="col-md-5 single-right-left ">
                <div class="grid images_3_of_2">
                    <div class="jsFlexSlider">
                        <ul class="slides">
                            @if(isset($product->product_image) && $product->product_image !== '0')
                                <li data-thumb="{{ \App\Helpers\Helper::getUrlFile($product->product_image) }}">
                                    <div class="thumb-image">
                                        <img src="{{ \App\Helpers\Helper::getUrlFile($product->product_image) }}"
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
                                @if(isset($productImage->product_image_name) && $productImage->product_image_name !== '0')
                                    <li data-thumb="{{ \App\Helpers\Helper::getUrlFile($productImage->product_image_name) }}">
                                        <div class="thumb-image">
                                            <img src="{{ \App\Helpers\Helper::getUrlFile($productImage->product_image_name) }}"
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
                <div class="row col-sm-12 box-info__product">
                    @if(!empty($product->average_rating))
                    <div class="jsRating info__detail disabled"><span>{{ $avgRating }}</span></div>
                    <div class="info__detail"><span class="rating__info">{{ $product->count_rating }}</span> rating</div>
                    @else
                        <div class="info__detail">No reviews yet</div>
                    @endif
                    <div class="info__detail"><span class="sold__info">{{ $product->count_buy }}</span> sold</div>
                    <div class="info__detail"><span class="sold__info">{{ $product->exist }}</span> available</div>
                    <div class="info__detail"><span class="sold__info">{{ $product->count_view }}</span> view</div>
                </div>
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
                            <div class="label-attribute">Materials</div>
                            @foreach($materials as $key => $material)
                                <div data-material="{{ $material->attribute_item_name }}"
                                     style="background-color: #fff; width: auto; padding: 0 4px;"
                                     class="attribute-item material-item material">{{ $material->attribute_item_name }}</div>
                                @endforeach
                                </p>
                        </div>
                    @endif
                @endif

                <div class="product-single-w3l">
                    <div class="box__quantity">
                        <input type="hidden" class="product__quantity" value="{{ $product->exist }}">
                        <input class="jsQuantity1 quantity" type="text" name="quantity" id="jsQuantity1">
                    </div>
                </div>
                <div class="occasion-cart">
                    <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                        <button type="button" class="button btn btn-custon-three btn-primary add-to-cart"
                                data-id="{{ $product->id }}" {{ $product->exist == 0 ? 'disabled' : '' }}
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
            <div class="body-product-content">
                {!! $product->product_content !!}
            </div>

            <div class="expand-button-show">
                <button class="button btn btn-custon-three btn-primary btn-view-more">View More</button>
            </div>
        </div>
    </div>

    <div class="featured-section expand-product-content" id="expand-product-content">
        <div class="container">
            <h4 class="label-product-content">Ratings & Reviews of {{ $product->product_description }}</h4>
            <div class="sop-body-product-content" style="height: auto !important;">
                @if($avgRating)
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
                @endif
                <div class="col-sm-4">
                    <div class="sop-main-question">
                        <div class="title__question text-center">You have problems need advice?</div>

                        <div class="btn-show__form-question text-center">
                            <input type="hidden" class="product__id" value="{{ $product->id }}">
                            <button class="btn btn-custon-three btn-primary btnShowFormQuestion" {{ !$isRating ? 'disabled' : '' }}>Send comment</button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="comment-form sop__comment_form">
                <form class="comment_form__client" id="formSendComment" method="POST">
                    @csrf
                    <div class="col-sm-8 pull-left">
                        <div class="product-rating">
                            <div>How much do you rate this product ?</div>
                            <input type="hidden" class="product_id" name="product_id" value="{{ $product->id }}">
                            <div class="jsRatingComment {{ !$user ? 'disabled' : '' }}"></div>
                        </div>
                        <div class="comment-content-text">
                            <input type="hidden" name="rating">
                            <textarea name="comment_contents" id="comment_contents"
                                      placeholder="Please leave a review, a comment..." rows="5"></textarea>
                            <div class="error error_comment"></div>
                        </div>
{{--                        <div class="comment-name-and-email">--}}
{{--                            <input class="form-group" type="text" name="name" id="name" placeholder="Họ và Tên...">--}}
{{--                            <input class="form-group" type="text" name="phone" id="phone" placeholder="Số siện thoại">--}}
{{--                            <input class="form-group" type="email" name="email" id="email" placeholder="Email">--}}
{{--                        </div>--}}
                    </div>
                    <div class="col-sm-4 comment-btn">
                        <button class="btn btn-custon-three btn-success" id="btnSendComment">
                            <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Send
                        </button>
                        <button id="closeCommentForm" class="btn btn-custon-three btn-danger">
                            <i class="fa fa-remove" aria-hidden="true"></i> Cancel
                        </button>
                    </div>
                </form>
            </div>
            <!-- Comment -->
            <div class="list__comment"></div>
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
                <h3 class="tittle-w3l">Related products
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
                                            @if(isset($product->product_image) && $product->product_image !== '0')
                                                <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($product->product_description)]) }}">
                                                    <img class="image-product"
                                                         src="{{ \App\Helpers\Helper::getUrlFile($product->product_image) }}"
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
                                                        style="width: 100%; font-size: 20px" {{ $product->exist == 0 ? 'disabled' : '' }}>
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
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\CommentRequest', '#formSendComment') !!}
    <script>
        $(document).ready(function () {

            const MAX_RATE = 5;
            const MIN_RATE = 1;

            $('.jsRating').stars({
                stars: MAX_RATE,
                value: {{ $avgRating }},
            });

            $('.jsRatingComment').stars({
                stars: MAX_RATE,
                text: ["Very bad", "Unsatisfied", "Normal", "Satisfied", "Great"],
                value: {{ $ratePoint }},
                click: function (index) {
                    let productId = parseInt($('.product_id').val());
                    $('input[name=rating]').val(index);

                    // if (index >= MIN_RATE && index <= MAX_RATE) {
                    //     $.ajax({
                    //         url: '/updateRating',
                    //         dataType: 'JSON',
                    //         type: 'POST',
                    //         data: {
                    //             productId: productId,
                    //             point: index
                    //         },
                    //         success: function (data) {
                    //
                    //         },
                    //         error: function (data) {
                    //
                    //         }
                    //     });
                    // }
                }
            });

            $('.jsRatingDetail').stars({
                stars: 5
            });

            $('.jsRatingUser').stars({
                stars : MAX_RATE,
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

{{--            @if(!empty($comments))--}}
{{--                @for($i = 0; $i < count($comments); $i++)--}}
{{--                    $('.jsStarsComment' + {{ $i }}).stars({--}}
{{--                        stars : MAX_RATE,--}}
{{--                        value : {{ App\Helpers\Helper::getPointRatingByUserIdAndProductId($comments[$i]->user_id, $comments[$i]->product_id) }}--}}
{{--                    });--}}
{{--                @endfor--}}
{{--            @endif--}}
        });
    </script>
@endsection
