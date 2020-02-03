@extends('frontend.layouts.app')
@section('cssCustom')
@endsection
@section('content')
    <div class="row col-sm-12">
        <div class="col-sm-10" style="margin: 0 auto;">
            <div class="row text-center m-b-md custom-login">
                <div class="col-sm-12">
                    <h3>Forgot your password?</h3>
                </div>
            </div>
            <div class="forget-password-form">
                <!-- Step 1 -->
                <div class="step step-1 show">
                    <div class="content">
                        <form method="POST" class="mb-55" onsubmit="return false;" id="forgetPasswordForm">
                            <p class="info mb-35">
                                If you forget the password needed to access Store Online®,
                                Please enter the account you would like to reset your password and continue with the Next button.
                            </p>

                            <div class="form-group mb-55">
                                <label for="email" class="required after">Email address</label>
                                {{ Form::text('email', null, [
                                    'class' => 'form-control simple',
                                    'id' => 'email',
                                    'type' => 'email',
                                    'autofocus' => 'autofocus',
                                ]) }}
                                <div class="error error_email hidden"></div>
                            </div>

                            <div class="submit-group col-sm-12">
                                <button type="button" class="btn btn-custon-three btn-primary next" id="submit-email" style="display: block; margin: 0 auto;">Next</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ Step 1 -->

                <!-- Step 2 -->
                <div class="step step-2 hidden">
                    <div class="content">
                        <form method="post" action="#" class="mb-40" id="updatePasswordForm">
                            <p class="info mb-0" style="color: #0b0b0b">An email with an authentication code has been sent to the registered email address.</p>
                            <p class="info xsmall mb-30" style="color: #0b0b0b">If this screen is not closed, enter the verification code written in the email text, set a new password and continue with the Next button.</p>

                            <div class="form-group mb-10">
                                <label for="auth-key" class="required after">Verification codes</label>
                                <input type="text" id="auth_key" name="auth_key" class="form-control simple" autofocus>
                                <div class="error error_auth_key hidden"></div>
                            </div>

                            <div class="form-group">
                                <label for="new-password" class="required after">New password</label>
                                <input type="password" id="new_password" name="new_password" class="form-control simple">
                                <div class="error error_new_password hidden"></div>
                            </div>
                            <div class="form-group">
                                <label for="confirm-password" class="required after">Confirm new password</label>
                                <input type="password" id="confirm_password" name="confirm_password" class="form-control simple">
                                <div class="error error_confirm_password hidden"></div>
                            </div>

                            <!-- ボタンエリア -->
                            <div class="submit-group">
                                <button type="button" class="btn btn-custon-three btn-primary next" id="submit-password" style="display: block; margin: 0 auto;">Next</button>
                                <p class="info xsmall mt-25 text-center" style="color: #0b0b0b">Please contact
                                    <a href="mailto:store.online.232@gmail.com" style="color: #0a6aa1; background-color: transparent; border-bottom: solid 1px #000000;">us</a>, if you could not receive the email.</p>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ Step 2 -->
                <!-- Page 3 -->
                <div class="step step-3 hidden">
                    <div class="content">
                        <form method="post" action="#" class="mb-50">
                            <p class="info text-center">Password reset is complete.</p>
                            <p class="info xsmall mb-40 text-center">Please continue with "Login".</p>

                            <!-- ボタンエリア -->
                            <div class="submit-group">
                                <button type="button" class="btn btn-custon-three btn-primary login" onclick="location.href='{{ route(ADMIN_SHOW_LOGIN) }}'" style="display: block; margin: 0 auto;">Login</button>
                            </div>
                        </form>
                    </div>
                </div>
                <!--/ Page 3 -->
            </div>
        </div>
    </div>
@endsection

@section('jsCustom')
    <script src="frontend/assets/js/forget_password.js"></script>
@endsection
