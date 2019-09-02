<?php
    use App\Models\Admin;

    $user = Auth::guard('admins')->user();
    $admin = Admin::class;
?>
<div class="left-sidebar-pro">
    <nav id="sidebar" class="">
        <div class="sidebar-header">
            <a href="{{route(ADMIN_DASHBOARD)}}"><img class="main-logo" src="backend/img/logo/store-online.png" alt=""/></a>
            {{--            <strong><a href="index.html"><img src="backend/img/logo/logosn.png" alt=""/></a></strong>--}}
        </div>
        <div class="left-custom-menu-adp-wrap comment-scrollbar">
            <nav class="sidebar-nav left-sidebar-menu-pro">
                <ul class="metismenu" id="menu1">
                    <li class="active">
                        <a title="Landing Page" href="{{route(ADMIN_DASHBOARD)}}" aria-expanded="false"><span
                                class="educate-icon educate-home icon-wrap sub-icon-mg" aria-hidden="true"></span>
                            <span class="mini-click-non">Dashboard</span></a>
                    </li>
{{--                    <li>--}}
{{--                        <a class="has-arrow" href="all-professors.html" aria-expanded="false"><span--}}
{{--                                class="educate-icon educate-professor icon-wrap"></span> <span class="mini-click-non">Professors</span></a>--}}
{{--                        <ul class="submenu-angle" aria-expanded="false">--}}
{{--                            <li><a title="All Professors" href="all-professors.html"><span class="mini-sub-pro">All Professors</span></a>--}}
{{--                            </li>--}}
{{--                            <li><a title="Add Professor" href="add-professor.html"><span class="mini-sub-pro">Add Professor</span></a>--}}
{{--                            </li>--}}
{{--                            <li><a title="Edit Professor" href="edit-professor.html"><span class="mini-sub-pro">Edit Professor</span></a>--}}
{{--                            </li>--}}
{{--                            <li><a title="Professor Profile" href="professor-profile.html"><span class="mini-sub-pro">Professor Profile</span></a>--}}
{{--                            </li>--}}
{{--                        </ul>--}}
{{--                    </li>--}}
                    <?php
                        $isShowpages = in_array(request()->route()->getPrefix(), ['admin/category']);
                    ?>
                    <li class=" {{ $isShowpages ? 'active' : '' }} ">
                        <a class="has-arrow" href="#" aria-expanded="false"><span
                                class="educate-icon educate-pages icon-wrap"></span> <span
                                class="mini-click-non">Pages</span></a>
                        <ul class="submenu-angle {{ $isShowpages ? 'in show' : '' }}" aria-expanded="false">
                            <li class="{{request()->route()->getPrefix() == 'admin/category' ? 'active' : ''}}"><a title="Login" href="{{route(ADMIN_CATEGORY_INDEX)}}"><span class="mini-sub-pro">Category</span></a></li>
                        </ul>
                    </li>
                    <?php
                        $isShowUser = in_array(request()->route()->uri(), ['admin/list']);
                    ?>
                    <li class=" {{ $isShowUser ? 'active' : '' }} ">
                        <a class="has-arrow" href="#" aria-expanded="false"><span
                                class="educate-icon educate-professor icon-wrap"></span> <span
                                class="mini-click-non">User</span></a>
                        <ul class="submenu-angle {{ $isShowUser ? 'in show' : '' }}" aria-expanded="false">
                            @if ($user->can('viewAdmin', $admin))
                                <li class="{{request()->route()->uri() == 'admin/list' ? 'active' : ''}}"><a title="Login" href="{{route(ADMIN_INDEX)}}"><span class="mini-sub-pro">Admin</span></a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </nav>
        </div>
    </nav>
</div>
