<!-- Header -->

<header class="header">

    <!-- Top Bar -->

    <div class="top_bar">
        <div class="container">
            <div class="row">
                <div class="col d-flex flex-row">
                    <div class="top_bar_contact_item">
                        <div class="top_bar_icon"><img src="frontend/images/phone.png" alt=""></div>
                        012 345 6789
                    </div>
                    <div class="top_bar_contact_item">
                        <div class="top_bar_icon"><img src="frontend/images/mail.png" alt=""></div>
                        <a href="mailto:store.online.232@gmail.com">store.online.232@gmail.com</a></div>
                    <div class="top_bar_content ml-auto">
{{--                        <div class="top_bar_menu">--}}
{{--                            <ul class="standard_dropdown top_bar_dropdown">--}}
{{--                                <li>--}}
{{--                                    <a href="#">English<i class="fas fa-chevron-down"></i></a>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">Italian</a></li>--}}
{{--                                        <li><a href="#">Spanish</a></li>--}}
{{--                                        <li><a href="#">Japanese</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                                <li>--}}
{{--                                    <a href="#">$ US dollar<i class="fas fa-chevron-down"></i></a>--}}
{{--                                    <ul>--}}
{{--                                        <li><a href="#">EUR Euro</a></li>--}}
{{--                                        <li><a href="#">GBP British Pound</a></li>--}}
{{--                                        <li><a href="#">JPY Japanese Yen</a></li>--}}
{{--                                    </ul>--}}
{{--                                </li>--}}
{{--                            </ul>--}}
{{--                        </div>--}}
                        @if(Auth::check())
                        <div class="top_bar_user">
{{--                            <div class="user_icon"><img src="frontend/images/user.svg" alt=""></div>--}}
                            <div class="nav-user">
                                <a class="nav-link dropdown-toggle" href="#" id="navBarDropdownAccount" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fa fa-user-o" aria-hidden="true"></i>
                                    {{ Auth::user()->name }}'s account
                                </a>
                                <div class="dropdown-menu" aria-labelledby="navBarDropdownAccount">
                                    <a class="dropdown-item" href="#">Manage my account</a>
                                    <a class="dropdown-item" href="{{ route(FRONT_MY_ORDERS, Auth::user()->id) }}">My orders</a>
                                    <a class="dropdown-item" href="{{ route(FRONT_LOGOUT) }}">
                                        <i class="fa fa-sign-out dropdown-item-icon" aria-hidden="true"></i>Logout
                                    </a>
                                </div>
                            </div>
                        </div>
                        @else
                            <div class="top_bar_user">
                                <div class="user_icon"><i class="fa fa-user-o" aria-hidden="true"></i></div>
                                <div><a href="{{ route(FRONT_REGISTER) }}" style="text-transform: capitalize">sign up</a></div>
                                <div><a href="{{ route(FRONT_LOGIN) }}" style="text-transform: capitalize">login</a></div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Header Main -->

    <div class="header_main">
        <div class="container">
            <div class="row">

                <!-- Logo -->
                <div class="col-lg-2 col-sm-3 col-3 order-1">
                    <div class="logo_container">
                        <div class="logo">
                            <a href="{{route(FRONT_END_HOME_INDEX)}}"><img class="main-logo" src="backend/img/logo/store-online.png" alt=""/></a>
                        </div>
                    </div>
                </div>

                <!-- Search -->
                <div class="col-sm-5 col-lg-6 col-12 order-lg-2 order-2 text-lg-left text-right">
                    <div class="header_search">
                        <div class="header_search_content">
                            <div class="header_search_form_container">
                                <form action="#" class="header_search_form clearfix">
                                    <input type="search" required="required" class="header_search_input"
                                           placeholder="Search for products...">
{{--                                    <div class="custom_dropdown">--}}
{{--                                        <div class="custom_dropdown_list">--}}
{{--                                            <span class="custom_dropdown_placeholder clc">All Categories</span>--}}
{{--                                            <i class="fas fa-chevron-down"></i>--}}
{{--                                            <ul class="custom_list clc">--}}
{{--                                                <li><a class="clc" href="#">All Categories</a></li>--}}
{{--                                                <li><a class="clc" href="#">Computers</a></li>--}}
{{--                                                <li><a class="clc" href="#">Laptops</a></li>--}}
{{--                                                <li><a class="clc" href="#">Cameras</a></li>--}}
{{--                                                <li><a class="clc" href="#">Hardware</a></li>--}}
{{--                                                <li><a class="clc" href="#">Smartphones</a></li>--}}
{{--                                            </ul>--}}
{{--                                        </div>--}}
{{--                                    </div>--}}
                                    <button type="submit" class="header_search_button trans_300" value="Submit"><img
                                            src="frontend/images/search.png" alt=""></button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Wishlist -->
                <div class="col-sm-4 col-lg-4 col-9 order-lg-3 order-3 text-lg-left text-right">
                    <div class="wishlist_cart d-flex flex-row align-items-center justify-content-end">
                        <div class="wishlist d-flex flex-row align-items-center justify-content-end">
                            <div class="wishlist_icon"><img src="frontend/images/heart.png" alt=""></div>
                            <div class="wishlist_content">
                                <div class="wishlist_text"><a href="#">Wishlist</a></div>
{{--                                <div class="wishlist_count">115</div>--}}
                            </div>
                        </div>

                        <!-- Cart -->
                        <div class="cart">
                            <div class="cart_container d-flex flex-row align-items-center justify-content-end">
                                <div class="cart_icon">
                                    <button class="list-cart" onclick="window.location.href = '{{ route(FRONT_CART_INDEX) }}'">
                                        <img src="frontend/images/cart.png" alt="">
                                        <div class="cart_count"><span>{{ $countCart }}</span></div>
                                    </button>
                                </div>
                                <div class="cart_content">
                                    <div class="cart_text"><a href="{{ route(FRONT_CART_INDEX) }}">Cart</a></div>
{{--                                    <div class="cart_price">$85</div>--}}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('frontend.layouts.menu')

    <!-- Menu -->

    <div class="page_menu">
        <div class="container">
            <div class="row">
                <div class="col">

                    <div class="page_menu_content">

                        <div class="page_menu_search">
                            <form action="#">
                                <input type="search" required="required" class="page_menu_search_input"
                                       placeholder="Search for products...">
                            </form>
                        </div>
                        <ul class="page_menu_nav">
                            <li class="page_menu_item has-children">
                                <a href="#">Language<i class="fa fa-angle-down"></i></a>
                                <ul class="page_menu_selection">
                                    <li><a href="#">English<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Italian<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Spanish<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Japanese<i class="fa fa-angle-down"></i></a></li>
                                </ul>
                            </li>
                            <li class="page_menu_item has-children">
                                <a href="#">Currency<i class="fa fa-angle-down"></i></a>
                                <ul class="page_menu_selection">
                                    <li><a href="#">US Dollar<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">EUR Euro<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">GBP British Pound<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">JPY Japanese Yen<i class="fa fa-angle-down"></i></a></li>
                                </ul>
                            </li>
                            <li class="page_menu_item">
                                <a href="#">Home<i class="fa fa-angle-down"></i></a>
                            </li>
                            <li class="page_menu_item has-children">
                                <a href="#">Super Deals<i class="fa fa-angle-down"></i></a>
                                <ul class="page_menu_selection">
                                    <li><a href="#">Super Deals<i class="fa fa-angle-down"></i></a></li>
                                    <li class="page_menu_item has-children">
                                        <a href="#">Menu Item<i class="fa fa-angle-down"></i></a>
                                        <ul class="page_menu_selection">
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                            <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                        </ul>
                                    </li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                </ul>
                            </li>
                            <li class="page_menu_item has-children">
                                <a href="#">Featured Brands<i class="fa fa-angle-down"></i></a>
                                <ul class="page_menu_selection">
                                    <li><a href="#">Featured Brands<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                </ul>
                            </li>
                            <li class="page_menu_item has-children">
                                <a href="#">Trending Styles<i class="fa fa-angle-down"></i></a>
                                <ul class="page_menu_selection">
                                    <li><a href="#">Trending Styles<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                    <li><a href="#">Menu Item<i class="fa fa-angle-down"></i></a></li>
                                </ul>
                            </li>
                            <li class="page_menu_item"><a href="blog.html">blog<i class="fa fa-angle-down"></i></a></li>
                            <li class="page_menu_item"><a href="contact.html">contact<i
                                        class="fa fa-angle-down"></i></a></li>
                        </ul>

                        <div class="menu_contact">
                            <div class="menu_contact_item">
                                <div class="menu_contact_icon"><img src="frontend/images/phone_white.png" alt=""></div>
                                +38 068 005 3570
                            </div>
                            <div class="menu_contact_item">
                                <div class="menu_contact_icon"><img src="frontend/images/mail_white.png" alt=""></div>
                                <a href="mailto:fastsales@gmail.com">fastsales@gmail.com</a></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</header>
