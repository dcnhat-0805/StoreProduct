<!-- Main Navigation -->

<nav class="main_nav">
    <div class="container" style="padding: 0 4px;">
        <div class="row">
            <div class="col" style="padding: 0">

                <div class="main_nav_content d-flex flex-row">

                    <!-- Categories Menu -->

                    <div class="cat_menu_container">
                        <div class="cat_menu_title d-flex flex-row align-items-center justify-content-start">
                            <div class="cat_burger"><span></span><span></span><span></span></div>
                            <div class="cat_menu_text">categories</div>
                        </div>

                        @if(count($categories))
                        <ul class="cat_menu" data-smp="cate">
                            @foreach($categories as $key => $category)
                                    <li class="{{ count($category->productCategory) ? 'hassubs' : '' }}" id="category_Lever_No{{ $key+1 }}">
                                        <a data-id="{{ $category->id }}" data-slug="{{ $category->category_slug }}">{{ $category->category_name }}<i class="fas fa-chevron-right"></i></a>
                                        @if(isset($category->productCategory) && count($category->productCategory))
                                            <ul data-smp="cate_{{ $key+1 }}">

                                                @foreach($category->productCategory as $index => $productCategory)
                                                <li class="{{ count($productCategory->productType) ? 'hassubs' : '' }}" data-cate="cate_{{ $key+1 }}_{{ $index+1 }}">
                                                    <a data-id="{{ $productCategory->id }}" data-slug="{{ $productCategory->product_category_slug }}"
                                                       href="{{ route(FRONT_PRODUCT_LIST, ['slug' => $productCategory->product_category_slug]) }}">
                                                        {{ $productCategory->product_category_name }}
                                                        <i class="fas fa-chevron-right"></i>
                                                    </a>
                                                    @if(isset($productCategory->productType) && count($productCategory->productType))
                                                        <ul data-smp="cate_{{ $key+2 }}">

                                                            @foreach($productCategory->productType as $type => $productType)
                                                                <li data-cate="cate_{{ $key+1 }}_{{ $index+1 }}.{{ $type+1 }}">
                                                                    <a data-id="{{ $productType->id }}" data-slug="{{ $productType->product_type_slug }}" href="{{ route(FRONT_PRODUCT_LIST, ['slug' => $productType->product_type_slug]) }}">
                                                                        {{ $productType->product_type_name }}<i class="fas fa-chevron-right"></i>
                                                                    </a>
                                                                </li>
                                                            @endforeach
                                                        </ul>
                                                    @endif
                                                </li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </li>
                                @endforeach
                        </ul>
                        @endif
                    </div>

                    <!-- Main Nav Menu -->

                    <div class="main_nav_menu ml-auto" style="padding-right: 25px">
                        <ul class="standard_dropdown main_nav_dropdown">
                            <li><a href="#">Home<i class="fas fa-chevron-down"></i></a></li>
{{--                            <li class="hassubs">--}}
{{--                                <a href="#">Super Deals<i class="fas fa-chevron-down"></i></a>--}}
{{--                                <ul>--}}
{{--                                    <li>--}}
{{--                                        <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>--}}
{{--                                        <ul>--}}
{{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                        </ul>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                            <li class="hassubs">--}}
{{--                                <a href="#">Featured Brands<i class="fas fa-chevron-down"></i></a>--}}
{{--                                <ul>--}}
{{--                                    <li>--}}
{{--                                        <a href="#">Menu Item<i class="fas fa-chevron-down"></i></a>--}}
{{--                                        <ul>--}}
{{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                            <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                        </ul>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                    <li><a href="#">Menu Item<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
{{--                            <li class="hassubs">--}}
{{--                                <a href="#">Pages<i class="fas fa-chevron-down"></i></a>--}}
{{--                                <ul>--}}
{{--                                    <li><a href="shop.html">Shop<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                    <li><a href="product.html">Product<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                    <li><a href="blog.html">Blog<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                    <li><a href="blog_single.html">Blog Post<i class="fas fa-chevron-down"></i></a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="regular.html">Regular Post<i class="fas fa-chevron-down"></i></a>--}}
{{--                                    </li>--}}
{{--                                    <li><a href="cart.html">Cart<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                    <li><a href="contact.html">Contact<i class="fas fa-chevron-down"></i></a></li>--}}
{{--                                </ul>--}}
{{--                            </li>--}}
                            <li><a href="#">New Product<i class="fas fa-chevron-down"></i></a></li>
                            <li><a href="#">Blog<i class="fas fa-chevron-down"></i></a></li>
                            <li><a href="#">Contact<i class="fas fa-chevron-down"></i></a></li>
                        </ul>
                    </div>

                    <!-- Menu Trigger -->

                    <div class="menu_trigger_container ml-auto">
                        <div class="menu_trigger d-flex flex-row align-items-center justify-content-end">
                            <div class="menu_burger">
                                <div class="menu_trigger_text">menu</div>
                                <div class="cat_burger menu_burger_inner"><span></span><span></span><span></span>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</nav>
