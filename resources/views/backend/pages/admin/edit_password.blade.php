@extends('backend.layouts.app')
@section('title', 'Edit password')
@section('titleMenu', 'Edit password')
@section('cssCustom')
    <style>
        .form__button {
            margin-top: 30px;
            float: right;
        }
        .edit__account {
            position: relative;
        }
        .label__title__edit {
            border-left: 1px solid #000;
            font-size: 14px;
            text-align: center;
            position: absolute;
            padding: 0 6px;
            margin-left: 6px;
            top: 0px;
            text-transform: uppercase;
        }
        .invalid-feedback {
            margin-top: .25rem;
            font-size: .875rem;
            color: #dc3545;
        }
    </style>
@endsection
@section('content')
    <div class="sparkline13-list">
        <div class="row" style="margin: 5px">
            <div class="col-lg-12">
                @if (count($errors))
                    @foreach($errors->all() as $message)
                        <div class="error error" style="color: red">{{$message}}</div>
                    @endforeach
                @endif
                <form role="form" method="post" id="editPasswordAccount" action="{{ route(ADMIN_ACCOUNT_UPDATE_PASSWORD) }}">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group edit__account">
                                <label for="password" class="required after">Current Password</label>
                                <input type="password" class="form-control current-password"
                                       name="current_password" placeholder="Current password ....">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group edit__account">
                                <label for="password" class="required after">New Password</label>
                                <input type="password" class="form-control admin__password"
                                       name="password" placeholder="Password ....">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group edit__account">
                                <label for="password" class="required after">Confirm Password</label>
                                <input type="password" class="form-control confirm__password"
                                       name="confirm_password" placeholder="Confirm password ....">
                            </div>
                        </div>
                    </div><!-- /.box-body -->
                    <div class="form__button">
                        <button class="btn btn-custon-three btn-success btn__edit__account">
                            <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Update
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
    <script type="text/javascript" src="{{ asset('vendor/jsvalidation/js/jsvalidation.js')}}"></script>
    {!! JsValidator::formRequest('App\Http\Requests\AccountEditPasswordRequest', '#editPasswordAccount') !!}
@endsection
