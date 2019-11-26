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
                            <form action="{{ route(FRONT_EDIT_EMAIL) }}" id="editEmailForm" method="POST">
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
                                        <label class="control-label required after" for="email">Email</label>
                                        {{ Form::text('email', $user->email ? $user->email : old('email'), [
                                            'id' => 'email',
                                            'class' => 'form-control',
                                            'type' => 'email',
                                            'title' => 'Email',
                                            'placeholder' => 'Please enter email...',
                                        ]) }}
                                        @include('frontend.layouts.message_error', ['name' => 'email'])
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
    {!! JsValidator::formRequest('App\Http\Requests\EditEmailRequest', '#editEmailForm') !!}
@endsection
