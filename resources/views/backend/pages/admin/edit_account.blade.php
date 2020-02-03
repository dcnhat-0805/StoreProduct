@extends('backend.layouts.app')
@section('title', 'Edit account')
@section('titleMenu', 'Edit account')
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
                <form role="form" method="post" id="editAccount" action="{{ route(ADMIN_ACCOUNT_UPDATE) }}">
                    @csrf
                    <div class="box-body">
                        <div class="row">
                            <div class="form-group">
                                <label for="name">ID</label>
                                <input type="text" class="form-control" name="id" readonly="readonly" value="{{ $user->id }}" disabled>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="name" class="required after">Name</label>
                                <input type="text" class="form-control admin-name" name="name" value="{{ $user->name }}" placeholder="Name ....">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group edit__account">
                                <label for="email" class="">Email</label>
                                <span class="label__title__edit"><a href="{{ route(ADMIN_ACCOUNT_EDIT_EMAIL) }}">Edit</a></span>
                                <input type="email" class="form-control admin-email"
                                       name="email" value="{{ $user->email }}" readonly disabled placeholder="Email ....">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group edit__account">
                                <label for="password" class="">Password</label>
                                <span class="label__title__edit"><a href="{{ route(ADMIN_ACCOUNT_EDIT_PASSWORD) }}">Edit</a></span>
                                <input type="password" class="form-control admin-password"
                                       name="password"  readonly disabled value="11111111" placeholder="Password ....">
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="role" class="required after">Permission</label>
                                <div class="permission">
                                    {{
                                        Form::select('role', PERMISSION, $user->role ? $user->role : request()->get('role'),
                                        [
                                            'class' => 'form-control admin-permission jsSelectPermission',
                                        ])
                                    }}
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="form-group">
                                <label for="status" class="required after">Status</label>
                                <div class="admin-status">
                                    <div class="jsRadio pull-left">
                                        <input type="radio" value="1" name="admin_status" {{ $user->admin_status == 1 || old('admin_status') == 1 ? 'checked' : '' }}>
                                        <label><i></i> Display </label>
                                    </div>
                                    <div class="jsRadio pull-left">
                                        <input type="radio" value="0" name="admin_status" {{ $user->admin_status == 0 || (old('admin_status') == 0 && old('admin_status') != null) ? 'checked' : '' }}>
                                        <label><i></i> Not display </label>
                                    </div>
                                </div>
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
    {!! JsValidator::formRequest('App\Http\Requests\AccountEditRequest', '#editAccount') !!}
@endsection
