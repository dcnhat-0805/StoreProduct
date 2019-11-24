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
                    @include('frontend.layouts.side_bar.acount_side_bar')
                    <div class="col-md-9">
                        <div class="order-detail-lable" data-spm-anchor-id="">
                            <a>Manage My Account</a>
                        </div>
                        <div class="panel-body">
                            <form action="{{ route(FRONT_EDIT_PROFILE) }}" id="editProfileForm" method="POST">
                                @csrf
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <div class="col-sm-12">
                                    <div class="flash-message">
                                        @foreach (['danger', 'warning', 'success', 'info', 'error'] as $msg)
                                            @if(Session::has($msg))
                                                <div class="alert alert-{{ $msg }}">
                                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"
                                                            onclick="this.parentElement.style.display='none';"
                                                            style="font-size: 1rem;line-height: 13px;">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                    <li>
                                                        {!! Session::get($msg) !!}
                                                    </li>
                                                </div>
                                            @endif
                                        @endforeach
                                    </div>

                                    <div class="form-group">
                                        <label class="control-label required after" for="name">Name</label>
                                        {{ Form::text('name', $user->name ? $user->name : old('name'), [
                                            'id' => 'name',
                                            'class' => 'form-control',
                                            'title' => 'Name',
                                            'placeholder' => 'Please enter name...'
                                        ]) }}
                                        @include('frontend.layouts.message_error', ['name' => 'name'])
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="email">Email</label>
                                        <span class="lable-title lable-title-email"><a href="{{ route(FRONT_SHOW_EDIT_EMAIL) }}">Edit</a></span>
                                        {{ Form::text('email', $user->email ? $user->email : old('email'), [
                                            'id' => 'email',
                                            'class' => 'form-control',
                                            'type' => 'email',
                                            'title' => 'Email',
                                            'placeholder' => 'Please enter email...',
                                            'readonly' => true,
                                            'disabled' => true,
                                        ]) }}
                                        @include('frontend.layouts.message_error', ['name' => 'email'])
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="password">Password</label>
                                        <span class="lable-title lable-title-email"><a href="{{ route(FRONT_SHOW_EDIT_PASSWORD) }}">Edit</a></span>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label required after" for="phone">Phone number</label>
                                        {{ Form::text('phone', $user->phone ? $user->phone : old('phone'), [
                                            'id' => 'phone',
                                            'class' => 'form-control',
                                            'type' => 'tel',
                                            'title' => 'Phone',
                                            'placeholder' => 'Please enter phone...'
                                        ]) }}
                                        @include('frontend.layouts.message_error', ['name' => 'phone'])
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address">Address</label>
                                        <div class="form-address">
                                            <div class="col-sm-4 city" style="padding: 0;">
                                                {{
                                                    Form::select('city', $cities, isset($address->cityId) ? $address->cityId : old('city'),
                                                    [
                                                        'class' => 'form-control jsSelectCity address-user-checkout'
                                                    ])
                                                }}
                                            </div>
                                            <div class="col-sm-4 district" style="padding: 0;">
                                                {{
                                                    Form::select('district', $districts, isset($address->districtId) ? $address->districtId : old('district'),
                                                    [
                                                        'class' => 'form-control jsSelectDistrict address-user-checkout'
                                                    ])
                                                }}
                                            </div>
                                            <div class="col-sm-4 wards" style="padding: 0;">
                                                {{
                                                    Form::select('wards', $wards, isset($address->wardsId) ? $address->wardsId : old('wards'),
                                                    [
                                                        'class' => 'form-control jsSelectWards address-user-checkout'
                                                    ])
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address">Birthday</label>
                                        <div class="form-address">
                                            <div class="col-sm-4 birthday_year" style="padding: 0;">
                                                <select class="form-control account-profile-edit__birthday__year" id="birthday_year" name="birthday_year" >
                                                    <option value="">Year</option>
                                                    @for($y = date('Y') - GROWN_YEAR; $y >= date('Y') - YEAR; $y--)
                                                        <option value="{{ $y }}" {{ isset($user->birthday) && date('Y', strtotime($user->birthday)) == $y ? 'selected' : '' }}>{{ $y }}</option>
                                                    @endfor
                                                </select>

                                            </div>
                                            <div class="col-sm-4 birthday_month" style="padding: 0;">
                                                {{
                                                    Form::select('birthday_month', OPTION_MONTH, isset($user->birthday) ? date('m', strtotime($user->birthday)) : old('birthday_month'),
                                                    [
                                                        'class' => 'form-control account-profile-edit__birthday__month',
                                                        'id' => 'birthday_month'
                                                    ])
                                                }}
                                            </div>
                                            <div class="col-sm-4 birthday_day" style="padding: 0;">
                                                {{
                                                    Form::select('birthday_day', OPTION_DAY, isset($user->birthday) ? date('d', strtotime($user->birthday)) : old('birthday_day'),
                                                    [
                                                        'class' => 'form-control account-profile-edit__birthday__day',
                                                        'id' => 'birthday_day'
                                                    ])
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label class="control-label" for="address">Gender</label>
                                        <div class="form-address">
                                            <div class="col-sm-4 birthday_year" style="padding: 0;">
                                                {{
                                                    Form::select('gender', OPTION_GENDER, isset($user->gender) ? $user->gender : old('gender'),
                                                    [
                                                        'class' => 'form-control account-profile-edit__gender',
                                                        'id' => 'gender'
                                                    ])
                                                }}
                                            </div>
                                        </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\EditProfileRequest', '#editProfileForm') !!}
@endsection
