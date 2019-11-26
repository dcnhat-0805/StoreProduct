@extends('frontend.layouts.app')
@section('cssCustom')
    <link rel="stylesheet" href="backend/css/custom.css">
@endsection
@section('title')
    Register
@endsection
@section('content')
    <div class="row col-sm-12">
        <div class="col-sm-10" style="margin: 35px auto;">
            <div class="row text-center m-b-md custom-login">
                <div class="col-sm-8" style="padding-bottom: 20px;">
                    <h3 class="text-left">Create your StoreOnline Account</h3>
                </div>
                <div class="col">
                    <span class="float-right">Already member? <a href="{{ route(FRONT_LOGIN) }}">Login</a> here.</span>
                </div>
            </div>
            <div class="login-form">
                <div class="hpanel">
                    <div class="panel-body">
                        <form action="{{ route(FRONT_STORE) }}" id="register_form" method="POST">
                            <div class="col-sm-8">
                                @csrf

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
                                    {{ Form::text('name', old('name'), [
                                        'id' => 'name',
                                        'class' => 'form-control',
                                        'title' => 'Name',
                                        'placeholder' => 'Please enter name...'
                                    ]) }}
                                    @include('frontend.layouts.message_error', ['name' => 'name'])
                                </div>
                                <div class="form-group">
                                    <label class="control-label required after" for="email">Email</label>
                                    {{ Form::text('email', old('email'), [
                                        'id' => 'email',
                                        'class' => 'form-control',
                                        'type' => 'email',
                                        'title' => 'Email',
                                        'placeholder' => 'Please enter email...'
                                    ]) }}
                                    @include('frontend.layouts.message_error', ['name' => 'email'])
                                </div>
                                <div class="form-group">
                                    <label class="control-label required after" for="phone">Phone number</label>
                                    {{ Form::text('phone', old('phone'), [
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
                                        <div class="col-sm-4 city" style="padding: 0 !important;">
                                            {{
                                                Form::select('city', $cities, old('city'),
                                                [
                                                    'class' => 'form-control jsSelectCity'
                                                ])
                                            }}
                                        </div>
                                        <div class="col-sm-4 district" style="padding: 0 !important;">
                                            {{
                                                Form::select('district', $districts, old('district'),
                                                [
                                                    'class' => 'form-control jsSelectDistrict'
                                                ])
                                            }}
                                        </div>
                                        <div class="col-sm-4 wards" style="padding: 0 !important;">
                                            {{
                                                Form::select('wards', $wards, old('wards'),
                                                [
                                                    'class' => 'form-control jsSelectWards'
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
                                    {{
                                        Form::select('gender', OPTION_GENDER, isset($user->gender) ? $user->gender : old('gender'),
                                        [
                                            'class' => 'form-control account-profile-edit__gender',
                                            'id' => 'gender'
                                        ])
                                    }}
                                </div>
                                <div class="form-group">
                                    <label class="control-label required after" for="password" style="margin-top: 10px">Password</label>
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
                                <div class="forget-password">
                                    <a class="forget-password float-right" href="{{ route(FRONT_FORGET_PASSWORD) }}">Forgot password ?</a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="checkbox login-checkbox">
                                    <label>
                                        <input type="checkbox" class="jsCheckBox" name="all_mail" checked> I want to receive exclusive offers and promotions from StoreOnline.
                                    </label>
                                </div>
                                <button class="btn btn-custon-three btn-primary btn-block btn-login">Sign up</button>
                                <div>
                                    By clicking "SIGN UP" I agree to <a href="">StoreOnline Privacy Policy</a>
                                </div>
                                <span>Or, login with</span>
                                <a type="button" class="btn btn-custon-three btn-primary btn-block btn-login"
                                   href="socialite/login/facebook">
                                    <i class="fa fa-facebook" aria-hidden="true"></i> Facebook</a>
                                <a type="button" class="btn btn-custon-three btn-danger btn-block btn-login"
                                   href="socialite/login/google">
                                    <i class="fa fa-google-plus" aria-hidden="true"></i> Google
                                </a>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('jsCustom')
    <script src="frontend/assets/js/register_user.js"></script>
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\RegisterUserRequest', '#register_form') !!}
@endsection
