@extends('frontend.layouts.app')
@section('cssCustom')
@endsection
@section('content')
    <div class="row col-sm-12">
        <div class="col-sm-10" style="margin: 0 auto;">
            <div class="row text-center m-b-md custom-login">
                <div class="col-sm-8">
                    <h3>Welcome to StoreOnline! Please login.</h3>
                </div>
                <div class="col">
                    <span class="float-right">New member? <a href="{{ route(FRONT_REGISTER) }}">Register</a> here.</span>
                </div>
            </div>
            <div class="login-form">
                <div class="hpanel">
                    <div class="panel-body">
                        <form action="{{ route(FRONT_END_LOGIN) }}" method="POST">
                            <div class="col-sm-8">
                                @csrf

                                <div class="form-group">
                                    <label class="control-label" for="email">Email</label>
                                    {{ Form::text('email', old('email'), [
                                        'id' => 'email',
                                        'class' => 'form-control',
                                        'type' => 'email',
                                        'autofocus' => 'autofocus',
                                        'title' => 'Email',
                                        'placeholder' => 'Please enter email...'
                                    ]) }}
                                    @include('frontend.layouts.message_error', ['name' => 'email'])
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="password">Password</label>
                                    <input type="password" title="Password" placeholder="Please enter password..."
                                           name="password" id="password" class="form-control" value="{{ old('password') }}">
                                    @include('frontend.layouts.message_error', ['name' => 'password'])
                                </div>
                                <div class="checkbox login-checkbox">
                                    <label>
                                        <input type="checkbox" class="jsCheckBox" name="remember_token" {{ old('remember_token') ? 'checked' : '' }}> Remember me
                                    </label>

                                    <a class="forget-password float-right" href="{{ route(FRONT_FORGET_PASSWORD) }}">Forgot password ?</a>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <button class="btn btn-custon-three btn-primary btn-block btn-login">Login</button>
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
@endsection
