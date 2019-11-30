<?php
    use App\Models\User;

    $user = Auth::guard('admins')->user();
?>
@extends('backend.layouts.app')
@section('title', 'List customer')
@section('titleMenu', 'customer')
@section('cssCustom')
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
    <style>
        .form-group select {
            margin-bottom: 15px;
            width: 99%;
        }
    </style>
@endsection
@section('content')
    <div class="sparkline13-list">
        @if ($user->can('viewCustomer', User::class))
            <div class="sparkline13-hd">
                <div class="main-sparkline13-hd">
                    <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Customer</h1>
                </div>
            </div>
            <div class="sparkline13-graph">
            <div class="datatable-dashv1-list custom-datatable-overright">
                <div id="toolbar">
                    <!-- Button to Open the Delete Modal -->
                    <button id="removeCustomer" class="btn btn-custon-three btn-danger"
                            data-toggle="modal" data-target="#delete" data-id="all">
                        <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Delete
                    </button>
                </div>
                <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true"
                       data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true"
                       data-show-toggle="true" data-resizable="true" data-cookie="true"
                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                       data-toolbar="#toolbar">
                    <thead>
                    <tr>
                        <th data-field="state" data-checkbox="true"></th>
                        <th data-field="id">ID</th>
                        <th data-field="name" data-editable="true">Name</th>
                        <th data-field="email" data-editable="true">Email</th>
                        <th data-field="birthday" data-editable="true">Birthday</th>
                        <th data-field="phone" data-editable="true">Phone</th>
                        <th data-field="address" data-editable="true">Address</th>
                        <th data-field="created_at" data-editable="true">Created at</th>
                        <th data-field="status" data-editable="true">Status</th>
                        <th data-field="action">Action</th>
                    </tr>
                    </thead>
                    <tbody class="list-category">
                    @if($users)
                        @foreach($users as $user)
                            <tr id="admin-{{$user->id}}">
                                <td></td>
                                <td class="text-center">{{ $user->id }}</td>
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td>{{ date('Y/m/d', strtotime($user->birthday)) }}</td>
                                <td>{{ $user->phone }}</td>
                                <td>{{ $user->address_user }}</td>
                                <td class="text-center">{{ date('Y/m/d H:i:s', strtotime($user->created_at)) }}</td>
                                <td class="text-center">@if($user->status == 1) Active @else Not active @endif</td>
                                <td class="datatable-ct text-center">
                                    <button data-toggle="modal" title="Detail {{ $user->name }}" class="pd-setting-ed"
                                            data-original-title="Edit" data-target="#detail" data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}"
                                            data-email="{{ $user->email }}"
                                            data-phone="{{ $user->phone }}"
                                            data-city="{{ $user->cityId }}"
                                            data-district="{{ $user->districtId }}"
                                            data-wards="{{ $user->address }}"
                                            data-year="{{ date('Y', strtotime($user->birthday)) }}"
                                            data-month="{{ date('m', strtotime($user->birthday)) }}"
                                            data-day="{{ date('d', strtotime($user->birthday)) }}"
                                            data-gender="{{ $user->gender }}"
                                            data-status="{{ $user->status }}" type="button">
                                        <i class="fa fa-eye" aria-hidden="true"></i></button>
                                    <button data-toggle="modal" title="Delete {{ $user->name }}" class="pd-setting-ed"
                                            data-original-title="Trash" data-target="#delete" data-id="{{ $user->id }}" type="button"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination-wrapper header" style="margin-top: 20px;">
                    <nav class="nav-pagination store-unit clearfix" aria-label="Page navigation">
                        <span class="info">{{ $users->currentPage() }} / {{ $users->lastPage() }} pages（total of {{ $users->total() }}）</span>
                        <ul class="pull-right">
                            <li> {{ $users->appends($_GET)->links('backend.pagination') }}</li>
                        </ul>
                    </nav>
                </div>
                <!--/ Pagination -->
            </div>
        </div>
        @else
            @include('backend.permission')
        @endif
    </div>
    <!-- Search Modal-->
    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Search</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="GET" id="formSearch" action="{{ route(ADMIN_INDEX) }}">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Keyword</label>
                                                <input type="text" class="form-control" name="keyword" value="{{ request()->get('keyword') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Created at</label>
                                                <input type="text" readonly class="form-control jsDatepicker" name="created_at" value="{{ request()->get('created_at') }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Permission</label>
                                                <div class="permission">
                                                    {{
                                                        Form::select('role', PERMISSION, request()->get('role'),
                                                        [
                                                            'class' => 'form-control jsSelectPermission'
                                                        ])
                                                    }}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="status" class="required after">Status</label>
                                                <div class="status">
                                                    <input type="checkbox" class="jsCheckBox" id="display" name="status[]" value="{{ DISPLAY }}" {{ App\Helpers\Helper::setCheckedForm('status', DISPLAY, 'checked') }}>
                                                    <label for="display" class="label__status">Display</label>
                                                    <input type="checkbox" class="jsCheckBox" id="not__display" name="status[]" value="{{ NOT_DISPLAY }}" {{ App\Helpers\Helper::setCheckedForm('status', NOT_DISPLAY, 'checked') }}>
                                                    <label for="not__display" class="label__status">Not display</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-custon-three btn-success" id="btnSearch"><i
                                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal" id="btnClear" onclick="window.location.href = '{{route(ADMIN_INDEX)}}'">
                                        <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal-->
    <div class="modal fade" id="detail" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Detail customer</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <form action="{{ route(FRONT_STORE) }}" id="register_form" method="POST">
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="control-label" for="name">Id</label>
                                    {{ Form::text('id', old('id'), [
                                        'id' => 'name',
                                        'class' => 'form-control',
                                        'readonly' => true,
                                        'disabled' => true,
                                    ]) }}
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="name">Name</label>
                                    {{ Form::text('name', old('name'), [
                                        'id' => 'name',
                                        'class' => 'form-control',
                                        'title' => 'Name',
                                        'readonly' => true,
                                        'disabled' => true,
                                    ]) }}
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="email">Email</label>
                                    {{ Form::text('email', old('email'), [
                                        'id' => 'email',
                                        'class' => 'form-control',
                                        'type' => 'email',
                                        'title' => 'Email',
                                        'readonly' => true,
                                        'disabled' => true,
                                    ]) }}
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="phone">Phone number</label>
                                    {{ Form::text('phone', old('phone'), [
                                        'id' => 'phone',
                                        'class' => 'form-control',
                                        'type' => 'tel',
                                        'title' => 'Phone',
                                        'readonly' => true,
                                        'disabled' => true,
                                    ]) }}
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="address">Address</label>
                                    <div class="form-address">
                                        <div class="col-sm-4 city" style="padding: 0 !important;">
                                            {{
                                                Form::select('city', $cities, old('city'),
                                                [
                                                    'class' => 'form-control jsSelectCity',
                                                    'readonly' => true,
                                                    'disabled' => true,
                                                ])
                                            }}
                                        </div>
                                        <div class="col-sm-4 district" style="padding: 0 !important;">
                                            {{
                                                Form::select('district', $districts, old('district'),
                                                [
                                                    'class' => 'form-control jsSelectDistrict',
                                                    'readonly' => true,
                                                    'disabled' => true,
                                                ])
                                            }}
                                        </div>
                                        <div class="col-sm-4 wards" style="padding: 0 !important;">
                                            {{
                                                Form::select('wards', $wards, old('wards'),
                                                [
                                                    'class' => 'form-control jsSelectWards',
                                                    'readonly' => true,
                                                    'disabled' => true,
                                                ])
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="address">Birthday</label>
                                    <div class="form-address">
                                        <div class="col-sm-4 birthday_year" style="padding: 0;">
                                            <select class="form-control account-profile-edit__birthday__year" id="birthday_year" name="birthday_year" readonly disabled>
                                                <option value="">Year</option>
                                                @for($y = date('Y') - GROWN_YEAR; $y >= date('Y') - YEAR; $y--)
                                                    <option value="{{ $y }}">{{ $y }}</option>
                                                @endfor
                                            </select>

                                        </div>
                                        <div class="col-sm-4 birthday_month" style="padding: 0;">
                                            {{
                                                Form::select('birthday_month', OPTION_MONTH, old('birthday_month'),
                                                [
                                                    'class' => 'form-control account-profile-edit__birthday__month',
                                                    'id' => 'birthday_month',
                                                    'readonly' => true,
                                                    'disabled' => true,
                                                ])
                                            }}
                                        </div>
                                        <div class="col-sm-4 birthday_day" style="padding: 0;">
                                            {{
                                                Form::select('birthday_day', OPTION_DAY, old('birthday_day'),
                                                [
                                                    'class' => 'form-control account-profile-edit__birthday__day',
                                                    'id' => 'birthday_day',
                                                    'readonly' => true,
                                                    'disabled' => true,
                                                ])
                                            }}
                                        </div>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="control-label" for="address">Gender</label>
                                    {{
                                        Form::select('gender', OPTION_GENDER, old('gender'),
                                        [
                                            'class' => 'form-control account-profile-edit__gender',
                                            'id' => 'gender',
                                            'readonly' => true,
                                            'disabled' => true,
                                        ])
                                    }}
                                </div>
                                <div class="form-group">
                                    <label for="status" class="required after">Status</label>
                                    <div class="admin-status">
                                        <div class="jsRadio pull-left">
                                            <input type="radio" value="1" id="active" name="status" readonly disabled>
                                            <label for="display" class="label__radio"><i></i> Active </label>
                                        </div>
                                        <div class="jsRadio pull-left">
                                            <input type="radio" value="0" id="not__display" name="status" readonly disabled>
                                            <label for="not__active" class="label__radio"><i></i> Not active </label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal">
                        <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- delete Modal-->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="min-height: 70px;">
                        <input type="hidden" name="id" id="customer_id">
                        <h5 class="modal-title" id="exampleModalLabel" style="line-height: 70px; text-align: center">Do you want to delete the customer ?</h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success btn__delete__customer"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
                    <button class="btn btn-custon-three btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times edu-danger-error" aria-hidden="true"></i> No</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
    <script src="{{ \App\Helpers\Helper::asset('backend/js/backend/customer.js') }}"></script>
    <script src="{{ \App\Helpers\Helper::asset('backend/js/backend/disabled_button_submit.js') }}"></script>
{{--    {!! JsValidator::formRequest('App\Http\Requests\AdminRequest', '#create_admin') !!}--}}
{{--    {!! JsValidator::formRequest('App\Http\Requests\AdminRequest', '#edit_admin') !!}--}}
@endsection
@section('cssCustom')
@endsection
