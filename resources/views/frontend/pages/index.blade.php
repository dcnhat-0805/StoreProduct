@extends('frontend.layouts.app')
@section('title')
    Home
@endsection
@section('content')
    <!-- Banner -->

    <div class="banner">
        <div class="banner_background"></div>
        <div class="container fill_height">
            <div class="row fill_height">
                <div class="banner_product_image"><img src="frontend/images/banner_product.png" alt=""></div>
                <div class="col-lg-5 offset-lg-4 fill_height">
                    <div class="banner_content">
                        <h1 class="banner_text">new era of smartphones</h1>
                        <div class="banner_price"><span>$530</span>$460</div>
                        <div class="banner_product_name">Apple Iphone 6s</div>
                        <div class="button banner_button"><a href="#">Shop Now</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Popular Categories -->

    <div class="popular_categories">
        <div class="container">
            <div class="row">
                <div class="col-lg-3">
                    <div class="popular_categories_content">
                        <div class="popular_categories_title">Popular Categories</div>
                        <div class="popular_categories_slider_nav">
                            <div class="popular_categories_prev popular_categories_nav"><i class="fas fa-angle-left ml-auto"></i></div>
                            <div class="popular_categories_next popular_categories_nav"><i class="fas fa-angle-right ml-auto"></i></div>
                        </div>
                        <div class="popular_categories_link"><a href="#">full catalog</a></div>
                    </div>
                </div>

                <!-- Popular Categories Slider -->

                <div class="col-lg-9">
                    <div class="popular_categories_slider_container">
                        <div class="owl-carousel owl-theme popular_categories_slider">

                            <!-- Popular Categories Item -->
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="frontend/images/popular_1.png" alt=""></div>
                                    <div class="popular_category_text">Smartphones & Tablets</div>
                                </div>
                            </div>

                            <!-- Popular Categories Item -->
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="frontend/images/popular_2.png" alt=""></div>
                                    <div class="popular_category_text">Computers & Laptops</div>
                                </div>
                            </div>

                            <!-- Popular Categories Item -->
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="frontend/images/popular_3.png" alt=""></div>
                                    <div class="popular_category_text">Gadgets</div>
                                </div>
                            </div>

                            <!-- Popular Categories Item -->
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="frontend/images/popular_4.png" alt=""></div>
                                    <div class="popular_category_text">Video Games & Consoles</div>
                                </div>
                            </div>

                            <!-- Popular Categories Item -->
                            <div class="owl-item">
                                <div class="popular_category d-flex flex-column align-items-center justify-content-center">
                                    <div class="popular_category_image"><img src="frontend/images/popular_5.png" alt=""></div>
                                    <div class="popular_category_text">Accessories</div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hot New Arrivals -->

    @if(count($products))
    <div class="new_arrivals">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="tabbed_container">
                        <div class="tabs clearfix tabs-right">
                            <div class="new_arrivals_title">SUGGESTIONS TODAY</div>
                            <ul class="clearfix">

                                @if(count($products['best']))
                                    <li class="active">BEST</li>
                                @endif
                                @if(count($products['news']))
                                        <li>NEW</li>
                                @endif
                                @if(count($products['hot']))
                                        <li>HOT</li>
                                @endif
                            </ul>
                            <div class="tabs_line"><span></span></div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12" style="z-index:1;">

                                <!-- Product Panel -->
                                @if(count($products['best']))
                                    <div class="product_panel panel active">
                                        <div class="arrivals_slider slider">

                                            <!-- Slider Item -->
                                            @foreach($products['best'] as $key => $productBest)
                                                <div class="arrivals_slider_item sop__arrivals__{{ $key }}">
                                                    <div class="border_active"></div>
                                                    <div class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                                    <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                                        @if(isset($productBest->product_image) && $productBest->product_image !== '0' && file_exists(FILE_PATH_PRODUCT . $productBest->product_image))
                                                            <img src="{{ FILE_PATH_PRODUCT . $productBest->product_image }}"alt="">
                                                        @else
                                                            <img src="{{ FILE_PATH_PRODUCT_THUMP }}" alt="" >
                                                        @endif
                                                    </div>
                                                    <div class="product_content">
                                                        <div class="product_price">{{ \App\Helpers\Helper::loadMoney($productBest->product_promotion ? $productBest->product_promotion : $productBest->product_price) }}</div>
                                                        <div class="product_name"><div><a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($productBest->product_description)]) }}">{{ $productBest->product_description }}</a></div></div>
                                                        <div class="product_extras">
                                                            <button class="product_cart_button add-to-cart" data-id="{{ $productBest->id }}">Add to Cart</button>
                                                        </div>
                                                    </div>
                                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                                    <ul class="product_marks">
                                                        <li class="product_mark product_discount">-25%</li>
                                                        <li class="product_mark product_new">best</li>
                                                    </ul>
                                                </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="arrivals_slider_dots_cover"></div>
                                    </div>
                                @endif
                                @if(count($products['news']))
                                    <div class="product_panel panel {{ !count($products['best']) ? 'active' : ''}}">
                                        <div class="arrivals_slider slider">

                                            <!-- Slider Item -->
                                            @foreach($products['news'] as $key => $productNew)
                                                <div class="arrivals_slider_item sop__arrivals__{{ $key }}">
                                                    <div class="border_active"></div>
                                                    <div class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                                    <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                                        @if(isset($productNew->product_image) && $productNew->product_image !== '0' && file_exists(FILE_PATH_PRODUCT . $productNew->product_image))
                                                            <img src="{{ FILE_PATH_PRODUCT . $productNew->product_image }}"alt="">
                                                        @else
                                                            <img src="{{ FILE_PATH_PRODUCT_THUMP }}" alt="" >
                                                        @endif
                                                    </div>
                                                    <div class="product_content">
                                                        <div class="product_price">{{ \App\Helpers\Helper::loadMoney($productNew->product_promotion ? $productNew->product_promotion : $productNew->product_price) }}</div>
                                                        <div class="product_name"><div><a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($productNew->product_description)]) }}">{{ $productNew->product_description }}</a></div></div>
                                                        <div class="product_extras">
                                                            <button class="product_cart_button add-to-cart" data-id="{{ $productNew->id }}">Add to Cart</button>
                                                        </div>
                                                    </div>
                                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                                    <ul class="product_marks">
                                                        <li class="product_mark product_discount">-25%</li>
                                                        <li class="product_mark product_new">new</li>
                                                    </ul>
                                                </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="arrivals_slider_dots_cover"></div>
                                    </div>
                                @endif
                                @if(count($products['hot']))
                                    <div class="product_panel panel {{ !count($products['best']) && !count($products['news']) ? 'active' : ''}}">
                                        <div class="arrivals_slider slider">

                                            <!-- Slider Item -->
                                            @foreach($products['hot'] as $key => $productHot)
                                                <div class="arrivals_slider_item sop__arrivals__{{ $key }}">
                                                    <div class="border_active"></div>
                                                    <div class="product_item is_new d-flex flex-column align-items-center justify-content-center text-center">
                                                    <div class="product_image d-flex flex-column align-items-center justify-content-center">
                                                        @if(isset($productHot->product_image) && $productHot->product_image !== '0' && file_exists(FILE_PATH_PRODUCT . $productHot->product_image))
                                                            <img src="{{ FILE_PATH_PRODUCT . $productHot->product_image }}"alt="">
                                                        @else
                                                            <img src="{{ FILE_PATH_PRODUCT_THUMP }}" alt="" >
                                                        @endif
                                                    </div>
                                                    <div class="product_content">
                                                        <div class="product_price">{{ \App\Helpers\Helper::loadMoney($productHot->product_promotion ? $productHot->product_promotion : $productHot->product_price) }}</div>
                                                        <div class="product_name"><div><a href="{{ route(FRONT_PRODUCT_DETAIL, ['description' => convertStringToUrl($productHot->product_description)]) }}">{{ $productHot->product_description }}</a></div></div>
                                                        <div class="product_extras">
                                                            <button class="product_cart_button add-to-cart" data-id="{{ $productHot->id }}">Add to Cart</button>
                                                        </div>
                                                    </div>
                                                    <div class="product_fav"><i class="fas fa-heart"></i></div>
                                                    <ul class="product_marks">
                                                        <li class="product_mark product_discount">-25%</li>
                                                        <li class="product_mark product_new">Hot</li>
                                                    </ul>
                                                </div>
                                                </div>
                                            @endforeach
                                        </div>
                                        <div class="arrivals_slider_dots_cover"></div>
                                    </div>
                                @endif

                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Best Sellers -->

{{--    <div class="best_sellers">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col">--}}
{{--                    <div class="tabbed_container">--}}
{{--                        <div class="tabs clearfix tabs-right">--}}
{{--                            <div class="new_arrivals_title">Hot Best Sellers</div>--}}
{{--                            <ul class="clearfix">--}}
{{--                                <li class="active">Top 20</li>--}}
{{--                                <li>Audio & Video</li>--}}
{{--                                <li>Laptops & Computers</li>--}}
{{--                            </ul>--}}
{{--                            <div class="tabs_line"><span></span></div>--}}
{{--                        </div>--}}

{{--                        <div class="bestsellers_panel panel active">--}}

{{--                            <!-- Best Sellers Slider -->--}}

{{--                            <div class="bestsellers_slider slider">--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_1.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_2.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Samsung J730F...</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_3.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Nomi Black White</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_4.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Samsung Charm Gold</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_5.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Beoplay H7</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_6.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Huawei MediaPad T3</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_1.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_2.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_3.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_4.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_5.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_6.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="bestsellers_panel panel">--}}

{{--                            <!-- Best Sellers Slider -->--}}

{{--                            <div class="bestsellers_slider slider">--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_1.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_2.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_3.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_4.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_5.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_6.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_1.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_2.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_3.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_4.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_5.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_6.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}

{{--                        <div class="bestsellers_panel panel">--}}

{{--                            <!-- Best Sellers Slider -->--}}

{{--                            <div class="bestsellers_slider slider">--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_1.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_2.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_3.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_4.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_5.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_6.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_1.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_2.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_3.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_4.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item discount">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_5.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                                <!-- Best Sellers Item -->--}}
{{--                                <div class="bestsellers_item">--}}
{{--                                    <div class="bestsellers_item_container d-flex flex-row align-items-center justify-content-start">--}}
{{--                                        <div class="bestsellers_image"><img src="frontend/images/best_6.png" alt=""></div>--}}
{{--                                        <div class="bestsellers_content">--}}
{{--                                            <div class="bestsellers_category"><a href="#">Headphones</a></div>--}}
{{--                                            <div class="bestsellers_name"><a href="product.html">Xiaomi Redmi Note 4</a></div>--}}
{{--                                            <div class="rating_r rating_r_4 bestsellers_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="bestsellers_price discount">$225<span>$300</span></div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <div class="bestsellers_fav active"><i class="fas fa-heart"></i></div>--}}
{{--                                    <ul class="bestsellers_marks">--}}
{{--                                        <li class="bestsellers_mark bestsellers_discount">-25%</li>--}}
{{--                                        <li class="bestsellers_mark bestsellers_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                </div>--}}

{{--                            </div>--}}
{{--                        </div>--}}
{{--                    </div>--}}

{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <!-- Trends -->--}}

{{--    <div class="trends">--}}
{{--        <div class="trends_background"></div>--}}
{{--        <div class="trends_overlay"></div>--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}

{{--                <!-- Trends Content -->--}}
{{--                <div class="col-lg-3">--}}
{{--                    <div class="trends_container">--}}
{{--                        <h2 class="trends_title">Trends 2018</h2>--}}
{{--                        <div class="trends_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing Donec et.</p></div>--}}
{{--                        <div class="trends_slider_nav">--}}
{{--                            <div class="trends_prev trends_nav"><i class="fas fa-angle-left ml-auto"></i></div>--}}
{{--                            <div class="trends_next trends_nav"><i class="fas fa-angle-right ml-auto"></i></div>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--                <!-- Trends Slider -->--}}
{{--                <div class="col-lg-9">--}}
{{--                    <div class="trends_slider_container">--}}

{{--                        <!-- Trends Slider -->--}}

{{--                        <div class="owl-carousel owl-theme trends_slider">--}}

{{--                            <!-- Trends Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="trends_item is_new">--}}
{{--                                    <div class="trends_image d-flex flex-column align-items-center justify-content-center"><img src="frontend/images/trends_1.jpg" alt=""></div>--}}
{{--                                    <div class="trends_content">--}}
{{--                                        <div class="trends_category"><a href="#">Smartphones</a></div>--}}
{{--                                        <div class="trends_info clearfix">--}}
{{--                                            <div class="trends_name"><a href="product.html">Jump White</a></div>--}}
{{--                                            <div class="trends_price">$379</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <ul class="trends_marks">--}}
{{--                                        <li class="trends_mark trends_discount">-25%</li>--}}
{{--                                        <li class="trends_mark trends_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                    <div class="trends_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Trends Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="trends_item">--}}
{{--                                    <div class="trends_image d-flex flex-column align-items-center justify-content-center"><img src="frontend/images/trends_2.jpg" alt=""></div>--}}
{{--                                    <div class="trends_content">--}}
{{--                                        <div class="trends_category"><a href="#">Smartphones</a></div>--}}
{{--                                        <div class="trends_info clearfix">--}}
{{--                                            <div class="trends_name"><a href="product.html">Samsung Charm...</a></div>--}}
{{--                                            <div class="trends_price">$379</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <ul class="trends_marks">--}}
{{--                                        <li class="trends_mark trends_discount">-25%</li>--}}
{{--                                        <li class="trends_mark trends_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                    <div class="trends_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Trends Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="trends_item is_new">--}}
{{--                                    <div class="trends_image d-flex flex-column align-items-center justify-content-center"><img src="frontend/images/trends_3.jpg" alt=""></div>--}}
{{--                                    <div class="trends_content">--}}
{{--                                        <div class="trends_category"><a href="#">Smartphones</a></div>--}}
{{--                                        <div class="trends_info clearfix">--}}
{{--                                            <div class="trends_name"><a href="product.html">DJI Phantom 3...</a></div>--}}
{{--                                            <div class="trends_price">$379</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <ul class="trends_marks">--}}
{{--                                        <li class="trends_mark trends_discount">-25%</li>--}}
{{--                                        <li class="trends_mark trends_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                    <div class="trends_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Trends Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="trends_item is_new">--}}
{{--                                    <div class="trends_image d-flex flex-column align-items-center justify-content-center"><img src="frontend/images/trends_1.jpg" alt=""></div>--}}
{{--                                    <div class="trends_content">--}}
{{--                                        <div class="trends_category"><a href="#">Smartphones</a></div>--}}
{{--                                        <div class="trends_info clearfix">--}}
{{--                                            <div class="trends_name"><a href="product.html">Jump White</a></div>--}}
{{--                                            <div class="trends_price">$379</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <ul class="trends_marks">--}}
{{--                                        <li class="trends_mark trends_discount">-25%</li>--}}
{{--                                        <li class="trends_mark trends_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                    <div class="trends_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Trends Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="trends_item">--}}
{{--                                    <div class="trends_image d-flex flex-column align-items-center justify-content-center"><img src="frontend/images/trends_2.jpg" alt=""></div>--}}
{{--                                    <div class="trends_content">--}}
{{--                                        <div class="trends_category"><a href="#">Smartphones</a></div>--}}
{{--                                        <div class="trends_info clearfix">--}}
{{--                                            <div class="trends_name"><a href="product.html">Jump White</a></div>--}}
{{--                                            <div class="trends_price">$379</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <ul class="trends_marks">--}}
{{--                                        <li class="trends_mark trends_discount">-25%</li>--}}
{{--                                        <li class="trends_mark trends_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                    <div class="trends_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Trends Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="trends_item is_new">--}}
{{--                                    <div class="trends_image d-flex flex-column align-items-center justify-content-center"><img src="frontend/images/trends_3.jpg" alt=""></div>--}}
{{--                                    <div class="trends_content">--}}
{{--                                        <div class="trends_category"><a href="#">Smartphones</a></div>--}}
{{--                                        <div class="trends_info clearfix">--}}
{{--                                            <div class="trends_name"><a href="product.html">Jump White</a></div>--}}
{{--                                            <div class="trends_price">$379</div>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
{{--                                    <ul class="trends_marks">--}}
{{--                                        <li class="trends_mark trends_discount">-25%</li>--}}
{{--                                        <li class="trends_mark trends_new">new</li>--}}
{{--                                    </ul>--}}
{{--                                    <div class="trends_fav"><i class="fas fa-heart"></i></div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}

{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}

{{--    <!-- Reviews -->--}}

{{--    <div class="reviews">--}}
{{--        <div class="container">--}}
{{--            <div class="row">--}}
{{--                <div class="col">--}}

{{--                    <div class="reviews_title_container">--}}
{{--                        <h3 class="reviews_title">Latest Reviews</h3>--}}
{{--                        <div class="reviews_all ml-auto"><a href="#">view all <span>reviews</span></a></div>--}}
{{--                    </div>--}}

{{--                    <div class="reviews_slider_container">--}}

{{--                        <!-- Reviews Slider -->--}}
{{--                        <div class="owl-carousel owl-theme reviews_slider">--}}

{{--                            <!-- Reviews Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="review d-flex flex-row align-items-start justify-content-start">--}}
{{--                                    <div><div class="review_image"><img src="frontend/images/review_1.jpg" alt=""></div></div>--}}
{{--                                    <div class="review_content">--}}
{{--                                        <div class="review_name">Roberto Sanchez</div>--}}
{{--                                        <div class="review_rating_container">--}}
{{--                                            <div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="review_time">2 day ago</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Reviews Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="review d-flex flex-row align-items-start justify-content-start">--}}
{{--                                    <div><div class="review_image"><img src="frontend/images/review_2.jpg" alt=""></div></div>--}}
{{--                                    <div class="review_content">--}}
{{--                                        <div class="review_name">Brandon Flowers</div>--}}
{{--                                        <div class="review_rating_container">--}}
{{--                                            <div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="review_time">2 day ago</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Reviews Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="review d-flex flex-row align-items-start justify-content-start">--}}
{{--                                    <div><div class="review_image"><img src="frontend/images/review_3.jpg" alt=""></div></div>--}}
{{--                                    <div class="review_content">--}}
{{--                                        <div class="review_name">Emilia Clarke</div>--}}
{{--                                        <div class="review_rating_container">--}}
{{--                                            <div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="review_time">2 day ago</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Reviews Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="review d-flex flex-row align-items-start justify-content-start">--}}
{{--                                    <div><div class="review_image"><img src="frontend/images/review_1.jpg" alt=""></div></div>--}}
{{--                                    <div class="review_content">--}}
{{--                                        <div class="review_name">Roberto Sanchez</div>--}}
{{--                                        <div class="review_rating_container">--}}
{{--                                            <div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="review_time">2 day ago</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Reviews Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="review d-flex flex-row align-items-start justify-content-start">--}}
{{--                                    <div><div class="review_image"><img src="frontend/images/review_2.jpg" alt=""></div></div>--}}
{{--                                    <div class="review_content">--}}
{{--                                        <div class="review_name">Brandon Flowers</div>--}}
{{--                                        <div class="review_rating_container">--}}
{{--                                            <div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="review_time">2 day ago</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                            <!-- Reviews Slider Item -->--}}
{{--                            <div class="owl-item">--}}
{{--                                <div class="review d-flex flex-row align-items-start justify-content-start">--}}
{{--                                    <div><div class="review_image"><img src="frontend/images/review_3.jpg" alt=""></div></div>--}}
{{--                                    <div class="review_content">--}}
{{--                                        <div class="review_name">Emilia Clarke</div>--}}
{{--                                        <div class="review_rating_container">--}}
{{--                                            <div class="rating_r rating_r_4 review_rating"><i></i><i></i><i></i><i></i><i></i></div>--}}
{{--                                            <div class="review_time">2 day ago</div>--}}
{{--                                        </div>--}}
{{--                                        <div class="review_text"><p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Maecenas fermentum laoreet.</p></div>--}}
{{--                                    </div>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                        <div class="reviews_dots"></div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
@endsection
@section('jsCustom')
    <script src="frontend/assets/js/cart.js"></script>
@endsection
