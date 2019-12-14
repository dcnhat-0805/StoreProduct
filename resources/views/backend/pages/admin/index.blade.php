<?php
    use App\Models\Admin;

    $user = Auth::guard('admins')->user();
?>
@extends('backend.layouts.app')
@section('title', 'List admin')
@section('titleMenu', 'admin')
@section('cssCustom')
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
@endsection
@section('content')
    <div class="sparkline13-list">
        @if ($user->can('viewAdmin', Admin::class))
            <div class="sparkline13-hd">
                <div class="main-sparkline13-hd">
                    <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Admin</h1>
                </div>
            </div>
            <div class="sparkline13-graph">
            <div class="datatable-dashv1-list custom-datatable-overright">
                <div id="toolbar">
                    <!-- Button to Open the Add Modal -->
                    <button id="addAdmin" class="btn btn-custon-three btn-default" data-toggle="modal" data-target="#add" type="button"
                            title="Add new admin"><i class="fa fa-plus"></i> Register
                    </button>
                    <!-- Button to Open the Delete Modal -->
                    <button id="removeAdmin" class="btn btn-custon-three btn-danger"
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
                        <th data-field="permission" data-editable="true">Permission</th>
                        <th data-field="created_at" data-editable="true">Created at</th>
                        <th data-field="status" data-editable="true">Status</th>
                        <th data-field="action">Action</th>
                    </tr>
                    </thead>
                    <tbody class="list-category">
                    @if($admins)
                        @foreach($admins as $ad)
                            <tr id="admin-{{$ad->id}}">
                                <td></td>
                                <td class="text-center">{{ $ad->id }}</td>
                                <td>{{ $ad->name }}</td>
                                <td>{{ $ad->email }}</td>
                                <td>{{ PERMISSION[$ad->role] }} ({{ $ad->role }})</td>
                                <td class="text-center">{{ $ad->created_at }}</td>
                                <td class="text-center">@if($ad->admin_status == 1) Active @else Not active @endif</td>
                                <td class="datatable-ct text-center">
                                    <button data-toggle="modal" title="Edit {{ $ad->name }}" class="pd-setting-ed"
                                            data-original-title="Edit" data-target="#edit" data-id="{{ $ad->id }}" data-name="{{ $ad->name }}"
                                            data-email="{{ $ad->email }}" data-permission="{{ $ad->role }}"
                                            data-url="{{route(ADMIN_EDIT, ['id' => $ad->id])}}" data-status="{{ $ad->admin_status }}" type="button">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    @if($ad->id != ADMIN)
                                        <button data-toggle="modal" title="Delete {{ $ad->name }}" class="pd-setting-ed"
                                                data-original-title="Trash" data-target="#delete" data-id="{{ $ad->id }}" type="button"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                        </button>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>

                <!-- Pagination -->
                <div class="pagination-wrapper header" style="margin-top: 20px;">
                    <nav class="nav-pagination store-unit clearfix" aria-label="Page navigation">
                        <span class="info">{{ $admins->currentPage() }} / {{ $admins->lastPage() }} pages（total of {{ $admins->total() }}）</span>
                        <ul class="pull-right">
                            <li> {{ $admins->appends($_GET)->links('backend.pagination') }}</li>
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
                                                    <label for="display" class="label__status">Active</label>
                                                    <input type="checkbox" class="jsCheckBox" id="not__display" name="status[]" value="{{ NOT_DISPLAY }}" {{ App\Helpers\Helper::setCheckedForm('status', NOT_DISPLAY, 'checked') }}>
                                                    <label for="not__display" class="label__status">Not active</label>
                                                    </div>
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
    <!-- Add Modal-->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Add Admin</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="createAdmin" action="{{route(ADMIN_ADD)}}">
                                <input type="hidden" name="submit">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="required after">Name</label>
                                            <input type="text" class="form-control admin-name" name="name" placeholder="Name ....">
                                            <div class="error error_name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="email" class="required after">Email</label>
                                            <input type="email" class="form-control admin-email"
                                                   name="email" placeholder="Email ....">
                                            <div class="error error_email hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="password" class="required after">Password</label>
                                            <input type="password" class="form-control admin-password"
                                                   name="password" placeholder="Password ....">
                                            <div class="error error_password hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="confirm password" class="required after">Confirm password</label>
                                            <input type="password" class="form-control confirm-password"
                                                   name="confirm_password" placeholder="Confirm password ....">
                                            <div class="error error_confirm_password hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="role" class="required after">Permission</label>
                                            <div class="permission">
                                                {{
                                                    Form::select('role', PERMISSION, request()->get('role'),
                                                    [
                                                        'class' => 'form-control admin-permission jsSelectPermission',
                                                        'id' => 'role'
                                                    ])
                                                }}
                                            </div>
                                            <div class="error error_role hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <div class="admin-status">
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="1" id="display" name="admin_status" checked {{ old('admin_status') ? 'checked' : '' }}>
                                                    <label for="display" class="label__radio"><i></i> Active </label>
                                                </div>
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="0" id="not__display" name="admin_status" {{ old('admin_status') == 0 && old('admin_status') != null ? 'checked' : '' }}>
                                                    <label for="not__display" class="label__radio"><i></i> Not active </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custon-three btn-success btn-add-admin">
                        <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Add
                    </button>
                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal">
                        <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Edit Modal-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Edit admin
                        &raquo; <span class="title"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="editAdmin">
                                <input type="hidden" name="submit">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name">ID</label>
                                            <input type="text" class="form-control" name="id" readonly="readonly" disabled>
                                            <input type="hidden" class="form-control" id="url_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="required after">Name</label>
                                            <input type="text" class="form-control admin-name" name="name" placeholder="Name ....">
                                            <div class="error error_name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="email" class="required after">Email</label>
                                            <input type="email" class="form-control admin-email"
                                                   name="email" placeholder="Email ....">
                                            <div class="error error_email hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="role" class="required after">Permission</label>
                                            <div class="permission">
                                                {{
                                                    Form::select('role', PERMISSION, request()->get('role'),
                                                    [
                                                        'class' => 'form-control admin-permission jsSelectPermission',
                                                    ])
                                                }}
                                            </div>
                                            <div class="error error_role hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <div class="admin-status">
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="1" id="display" name="admin_status" checked {{ old('admin_status') ? 'checked' : '' }}>
                                                    <label for="display" class="label__radio"><i></i> Active </label>
                                                </div>
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="0" id="not__display" name="admin_status" {{ old('admin_status') == 0 && old('admin_status') != null ? 'checked' : '' }}>
                                                    <label for="not__display" class="label__radio"><i></i> Not active </label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custon-three btn-success btn-edit-admin">
                        <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Update
                    </button>
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
                        <input type="hidden" name="id" id="admin_id">
                        <h5 class="modal-title" id="exampleModalLabel" style="line-height: 70px; text-align: center">Do you want to delete the administrator ?</h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success btn-delete-admin"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
                    <button class="btn btn-custon-three btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times edu-danger-error" aria-hidden="true"></i> No</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
    <script src="{{ \App\Helpers\Helper::asset('backend/js/backend/admin.js') }}"></script>
    <script src="{{ \App\Helpers\Helper::asset('backend/js/backend/disabled_button_submit.js') }}"></script>
{{--    {!! JsValidator::formRequest('App\Http\Requests\AdminRequest', '#create_admin') !!}--}}
{{--    {!! JsValidator::formRequest('App\Http\Requests\AdminRequest', '#edit_admin') !!}--}}
    @if ($user->cannot('updateAdmin', Admin::class))
        <script src="{{ App\Helpers\Helper::asset('backend/js/backend/disabled_checkbox.js') }}"></script>
    @endif
@endsection
@section('cssCustom')
@endsection
