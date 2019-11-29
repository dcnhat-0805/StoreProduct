<?php
    use App\Models\Admin;

    $user = Auth::guard('admins')->user();
    $admin = Admin::class;
?>

<div class="left-sidebar-pro">
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href="{{ route(ADMIN_DASHBOARD) }}"><img class="main-logo" src="backend/img/logo/store-online.png" alt=""/></a>
            <strong><a href="{{ route(ADMIN_DASHBOARD) }}"><img src="backend/img/logo/store-online.png" alt=""/></a></strong>
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    <?php
                    $isShowDashboard = in_array(request()->route()->uri(), ['admin']);
                    ?>
                    <li class=" {{ $isShowDashboard ? 'active' : '' }} ">
                        <a title="Landing Page" href="{{route(ADMIN_DASHBOARD)}}" aria-expanded="false"><span
                            class="educate-icon educate-home icon-wrap sub-icon-mg" aria-hidden="true"></span>
                        <span class="mini-click-non">Dashboard</span></a>
                    </li>
                    <?php
                    $isShowPages = in_array(request()->route()->getPrefix(), ['admin/category', 'admin/product_category', 'admin/product_type', 'admin/product']);
                    ?>
                    <li>
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <span class="educate-icon educate-pages icon-wrap"></span>
                            <span class="mini-click-non">Pages</span>
                        </a>
                        <ul class="submenu-angle {{ $isShowPages ? 'show' : '' }}" aria-expanded="false">
                            <li class="{{request()->route()->getPrefix() == 'admin/category' ? 'active' : ''}}">
                                <a title="Category" href="{{route(ADMIN_CATEGORY_INDEX)}}" aria-expanded="false">
                                    <span class="mini-click-non">Category</span>
                                </a>
                            </li>

                            <li class="{{request()->route()->getPrefix() == 'admin/product_category' ? 'active' : ''}}">
                                <a title="Product category" href="{{route(ADMIN_PRODUCT_CATEGORY_INDEX)}}" aria-expanded="false">
                                    <span class="mini-click-non">Product Category</span>
                                </a>
                            </li>

                            <li class="{{request()->route()->getPrefix() == 'admin/product_type' ? 'active' : ''}}">
                                <a title="Product type" href="{{route(ADMIN_PRODUCT_TYPE_INDEX)}}" aria-expanded="false">
                                    <span class="mini-click-non">Product Type</span>
                                </a>
                            </li>

                            <li class="{{request()->route()->getPrefix() == 'admin/product' ? 'active' : ''}}">
                                <a title="Product" href="{{route(ADMIN_PRODUCT_INDEX)}}" aria-expanded="false">
                                    <span class="mini-sub-pro">Product</span>
                                </a>
                            </li>
                        </ul>
                    </li>

                    <?php
                        $isShowOrder = in_array(request()->route()->uri(), ['admin/order']);
                    ?>

                    <li class=" {{ $isShowOrder ? 'active' : '' }} ">
                        <a title="Landing Page" href="{{route(ADMIN_ORDER_INDEX)}}" aria-expanded="false"><span
                                class="educate-icon educate-course icon-wrap" aria-hidden="true"></span>
                            <span class="mini-click-non">Order</span></a>
                    </li>

                    @if ($user->can('viewComment', App\Models\Comment::class))
                        <?php
                            $isShowComment = in_array(request()->route()->uri(), ['admin/comment']);
                        ?>
                        <li class=" {{ $isShowComment ? 'active' : '' }} ">
                            <a title="Landing Page" href="{{route(ADMIN_COMMENT_INDEX)}}" aria-expanded="false"><span
                                    class="educate-icon educate-message icon-wrap" aria-hidden="true"></span>
                                <span class="mini-click-non">Comment</span></a>
                        </li>
                    @endif

                    <?php
                        $isShowUser = in_array(request()->route()->uri(), ['admin/list']);
                    ?>
                    <li id="removable">
                        <a class="has-arrow" href="#" aria-expanded="false">
                            <span class="educate-icon educate-professor icon-wrap"></span>
                            <span class="mini-click-non">User</span>
                        </a>
                        <ul class="submenu-angle {{ $isShowUser ? 'show' : '' }}" aria-expanded="false">
                            @if ($user->can('viewAdmin', $admin))
                                <li class="{{request()->route()->uri() == 'admin/list' ? 'active' : ''}}">
                                    <a title="Login" href="{{route(ADMIN_INDEX)}}">
                                        <span class="mini-sub-pro">Admin</span>
                                    </a>
                                </li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </nav>
</div>
