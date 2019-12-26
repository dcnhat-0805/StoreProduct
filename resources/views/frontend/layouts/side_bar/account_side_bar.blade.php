<div class="col-md-3">
    @if(Auth::check())
        <div class="sop-playground-nav">
            <div class="member-info">
                <p><span>Hello,&nbsp;</span><span id="sop_current_logon_user_name">{{ Auth::user()->name }}</span></p>
            </div>
            <ul class="nav-container">
                <li class="item" id="Manage-My-Account" data-spm-anchor-id="a2o4n.order_list.0.i1.4f515d0a0VTrig">
                    <a href="" data-spm="Manage-My-Account"><span>Manage My Account</span></a>
                    <ul class="item-container">
                        <li id="My-profile" class="sub">
                            <a href="{{ route(FRONT_SHOW_EDIT_EMAIL) }}" data-spm="change-email">Change Email</a>
                        </li>
                        <li id="Address-book" class="sub">
                            <a href="{{ route(FRONT_SHOW_EDIT_PASSWORD) }}" data-spm="change-password">Change
                                Password</a>
                        </li>
                    </ul>
                </li>
                <li class="item" id="My-Orders">
                    <a class="active"
                       href="{{ route(FRONT_MY_ORDERS, ['sop' => convertStringToUrl(Auth::user()->name)]) }}"
                       data-spm="My-Orders"><span>My Orders</span></a>
                </li>
            </ul>
        </div>
    @endif
</div>
