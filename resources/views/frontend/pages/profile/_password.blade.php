@extends('frontend.layouts.app')
@section('cssCustom')
    <link rel="stylesheet" href="backend/css/custom.css">
@endsection
@section('title')
    My Orders
@endsection
@section('content')
    @php
        $user = Auth::user();
        if (isset($user)) {
            $address = App\Helpers\Helper::getAddressByWardsId($user->address);
        }
    @endphp
    <div class="ads-grid box-order" style="margin-top: 20px">
        <div class="container" style="padding: 0;">
            <div class="row">
                <div class="col-sm-12">
                    @include('frontend.layouts.side_bar.account_side_bar')
                    <div class="col-md-9">
                        <div class="order-detail-lable" data-spm-anchor-id="">
                            <a>Manage My Account</a>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route(FRONT_EDIT_PASSWORD) }}" id="editPasswordForm" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="control-label required after" for="password" style="margin-top: 10px">Current Password</label>
                                        <input type="password" title="Password" placeholder="Please enter current password..."
                                               name="current_password_user" id="current_password_user" class="form-control" value="{{ old('current_password_user') }}">
                                        @include('frontend.layouts.message_error', ['name' => 'current_password_user'])
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label required after" for="password" style="margin-top: 10px">New Password</label>
                                        <input type="password" title="Password" placeholder="Please enter password..."
                                               name="password_user" id="password_user" class="form-control" value="{{ old('password_user') }}">
                                        @include('frontend.layouts.message_error', ['name' => 'password_user'])
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label required after" for="confirm_password">Confirm Password</label>
                                        <input type="password" title="Confirm Password" placeholder="Please enter confirm password..."
                                               name="confirm_password" id="confirm_password" class="form-control" value="{{ old('confirm_password') }}">
                                        @include('frontend.layouts.message_error', ['name' => 'confirm_password'])
                                    </div>
                                    <div class="form-footer" style="margin-top: 70px">
                                        <button class="btn btn-custon-three btn-primary btn-block btn-login">Update</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
    <script src="frontend/assets/js/profile.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\EditPasswordRequest', '#editPasswordForm') !!}
@endsection
