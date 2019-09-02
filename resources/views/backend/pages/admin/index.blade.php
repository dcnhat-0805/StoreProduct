<?php
    use App\Models\Admin;

    $user = Auth::guard('admins')->user();
    $admins = Admin::class;
?>
@extends('backend.layouts.app')
@section('title', 'List admin')
@section('titleMenu', 'admin')
@section('content')
    <div class="sparkline13-list">
        @if ($user->can('viewAdmin', $admins))
            <div class="sparkline13-hd">
                <div class="main-sparkline13-hd">
                    <h1>Danh sách <span class="table-project-n">các</span> quản trị viên</h1>
                </div>
            </div>
            <div class="sparkline13-graph">
            <div class="datatable-dashv1-list custom-datatable-overright">
                <div id="toolbar">
                    <!-- Button to Open the Add Modal -->
                    <button class="btn btn-default" data-toggle="modal" data-target="#add" type="button"
                            title="Add new category"><i class="fa fa-plus"></i></button>
                    <select class="form-control dt-tb hidden">
                        <option value="">Export Basic</option>
                        <option value="all">Export All</option>
                        <option value="selected">Export Selected</option>
                    </select>
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
                        <th data-field="status" data-editable="true">Status</th>
                        <th data-field="action">Action</th>
                    </tr>
                    </thead>
                    <tbody class="list-category">
                    @if($admin)
                        @foreach($admin as $ad)
                            <tr id="admin-{{$ad->id}}" data-id="{{$ad->id}}">
                                <td></td>
                                <td>{{$ad->id}}</td>
                                <td>{{$ad->name}}</td>
                                <td>{{$ad->email}}</td>
                                <td>{{$ad->admin_group_id}}</td>
                                <td>@if($ad->admin_status == 1) Display @else Not display @endif</td>
                                <td class="datatable-ct">
                                    <button data-toggle="modal" title="Edit {{$ad->category_name}}" class="pd-setting-ed"
                                            data-original-title="Edit" data-target="#edit" type="button">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    <button data-toggle="modal" title="Delete {{$ad->category_name}}" class="pd-setting-ed"
                                            data-original-title="Trash" data-target="#delete" type="button"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
        @else
            @include('backend.permission')
        @endif
    </div>
    <!-- Add Modal-->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Add Admin
                        &raquo; <span class="title"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="create-admin" action="{{route(ADMIN_ADD)}}">
                                @csrf
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input type="text" class="form-control admin-name" name="name" placeholder="Name ....">
                                            <div class="alert alert-danger error error-name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="email">Email</label>
                                            <input type="email" class="form-control admin-email"
                                                   name="email" placeholder="Email ....">
                                            <div class="alert alert-danger error error-email hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="password">Password</label>
                                            <input type="password" class="form-control admin-password"
                                                   name="password" placeholder="Password ....">
                                            <div class="alert alert-danger error error-password hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="confirm password">Confirm password</label>
                                            <input type="password" class="form-control confirm-password"
                                                   name="confirm_password" placeholder="Confirm password ....">
                                            <div class="alert alert-danger error error-confirm-password hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="admin_group_id">Permission</label>
                                            <select name="admin_group_id" id="admin_group_id" class="form-control admin-permission">
                                                @foreach($permission as $permission)
                                                    <option value="{{ $permission->id }}">{{$permission->permission_name}}</option>
                                                @endforeach
                                            </select>
                                            <div class="alert alert-danger error error-permission hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control admin-status" name="admin_status">
                                                <option value="1" class="display">Display</option>
                                                <option value="0" class="not-display">Not Display</option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="modal-footer">
                                    <button class="btn btn-custon-three btn-success btn-add-admin"><i
                                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Add
                                    </button>
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal"><i
                                            class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
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
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Edit Category
                        &raquo; <span class="title"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="create-category">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name">Category Name</label>
                                            <input type="text" class="form-control category-name" name="category_name"
                                                   placeholder="Category Name ...." maxlength="128">
                                            <div class="alert alert-danger error error-category-name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="order">Order</label>
                                            <input type="number" class="form-control category-order"
                                                   name="category_order"
                                                   placeholder="Category Order ...." min="0" maxlength="128" value="0">
                                            <div class="alert alert-danger error error-category-order hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status">Status</label>
                                            <select class="form-control caategory-status" name="category_status">
                                                <option value="1" class="display">Display</option>
                                                <option value="0" class="not-display">Not Display</option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custon-three btn-success add-category"><i
                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Add
                    </button>
                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal"><i
                            class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
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
                    <h5 class="modal-title" id="exampleModalLabel">Do you want to delete ?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body modal-delete">
                    <button type="button" class="btn btn-success del-Category">Yes</button>
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">No</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
{{--    <script src="{{ \App\Helpers\Helper::asset('backend/js/admin.js') }}"></script>--}}
    {!! JsValidator::formRequest('App\Http\Requests\AdminRequest', '#create-admin') !!}
@endsection
@section('cssCustom')
@endsection
