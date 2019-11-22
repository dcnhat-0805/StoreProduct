@extends('frontend.layouts.app')
@section('title')
    {{ $slug }}
@endsection
@section('cssCustom')
@endsection
@section('content')
    @include('frontend.layouts.header_top', [
        'titleName' => isset($titleName) && $titleName ? $titleName : null,
        'namePage' => null,
    ])

    @include('frontend.layouts.banner')


    @include('frontend.layouts.logo')

    <!-- top Products -->
    <div class="ads-grid">
        <div class="container">
            <!-- tittle heading -->
            <h3 class="tittle-w3l">{{ App\Helpers\Helper::getTitleName($titleName ?? null) }}

                <span class="heading-style">
					<i></i>
					<i></i>
					<i></i>
				</span>
            </h3>
            <div class="row">
                <div class="col-sm-3">
                    @include('frontend.layouts.side_bar.side_bar_left')
                </div>
                <div class="col-sm-9">
                        <div class="col-sm-12">
                            <div class="product-header-left col-sm-6">
                                <span class="float-left col-sm-12">{{ count($products) }} items found for "{{ App\Helpers\Helper::getTitleName($titleName ?? null) }}"</span>
                            </div>
                            <div class="product-header-left col-sm-6">
                                <div class="col-sm-6">
                                    <span style="position:absolute; right: 0;">Sort By:</span>
                                </div>
                                <div class="float-right col-sm-6">
                                    <select name="" class="form-control form-group">
                                        <option value="">Popularity</option>
                                        <option value="">Price low to high</option>
                                        <option value="">Price high to low</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <hr class="hr-border">
                    @if(count($products))
                        <!-- product right -->
                        <div class="agileinfo-ads-display col-sm-12 w3l-rightpro">
                            <div class="wrapper">
                                <!-- first section -->
                                <div class="product-sec1">
                                    @foreach($products as $product)
                                        <div class="col-xs-4 product-men">
                                            <div class="men-pro-item simpleCart_shelfItem">
                                                <div class="men-thumb-item">
                                                    @if(isset($product->product_image) && $product->product_image !== '0' && file_exists(FILE_PATH_PRODUCT . $product->product_image))
                                                        <img class="image-product" src="{{ FILE_PATH_PRODUCT . $product->product_image }}" alt="">
                                                        <div class="men-cart-pro">
                                                            <div class="inner-men-cart-pro">
                                                                <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($product->product_description)]) }}" class="link-product-add-cart">Quick View</a>
                                                            </div>
                                                        </div>
                                                    @else
                                                        <img class="image-product" src="{{ FILE_PATH_PRODUCT_THUMP }}" alt="">
                                                        <div class="men-cart-pro">
                                                            <div class="inner-men-cart-pro">
                                                                <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($product->product_description)]) }}" class="link-product-add-cart">Quick View</a>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($product->product_option == NEWS)
                                                        <span class="product-new-top">New</span>
                                                    @endif
                                                </div>
                                                <div class="item-info-product ">
                                                    <h4>
                                                        <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($product->product_description)]) }}">
                                                            <p>{!!  $product->product_description !!}</p>
                                                        </a>
                                                    </h4>
                                                    <div class="info-product-price">
                                                        <span class="item_price">
                                                            {{ App\Helpers\Helper::loadMoney($product->product_promotion > 0 ? $product->product_promotion : $product->product_price) }}
                                                        </span>
                                                        @if(!empty($product->product_promotion) && $product->product_promotion > 0)
                                                            <del>{{ App\Helpers\Helper::loadMoney($product->product_price) }}</del>
                                                        @endif
                                                    </div>
                                                    <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                                        <button type="button" class="button btn btn-custon-three btn-primary add-to-cart" data-id="{{ $product->id }}"
{{--                                                                onclick="window.location.href = '{{ route(FRONT_ADD_CART, ['id' => $product->id]) }}'"--}}
                                                                style="width: 100%; font-size: 20px">
                                                            Add to cart
                                                        </button>
                                                    </div>

                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="not-data text-center">
                            <span>Search No Result</span>
                            <br>
                            <span>We're sorry. We cannot find any matches for your search term.</span>
                        </div>
                    @endif

                    @if(count($products))
                        <!-- Pagination -->
                        <div class="pagination-wrapper clearfix" style="margin-top: 20px;">
                            <nav class="nav-pagination store-unit clearfix" aria-label="Page navigation">
                                <span class="info">{{ $products->currentPage() }} / {{ $products->lastPage() }} pages</span>
                                <ul class="pull-right">
                                    <li> {{ $products->appends($_GET)->links('backend.pagination') }}</li>
                                </ul>
                            </nav>
                        </div>
                        <!--/ Pagination -->
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- //top products -->
    <!-- special offers -->
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
                                                    <img class="image-product" src="{{ FILE_PATH_PRODUCT . $product->product_image }}" alt="{{ $product->product_image }}">
                                                </a>
                                            @else
                                                <a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($product->product_description)]) }}">
                                                    <img class="image-product" src="{{ FILE_PATH_PRODUCT_THUMP }}" alt="{{ $product->product_image }}">
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
                                            <div class="snipcart-details top_brand_home_details item_add single-item hvr-outline-out">
                                                <button type="button" class="button btn btn-custon-three btn-primary add-to-cart" data-id="{{ $product->id }}"
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
    <script src="frontend/assets/js/cart.js"></script>
@endsection
