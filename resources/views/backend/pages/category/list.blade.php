@php
    use App\Models\Category;
    $params = $_GET;
    unset($params['sort']);
    unset($params['desc']);

    $user = Auth::guard('admins')->user();
@endphp
@extends('backend.layouts.app')
@section('title', 'List category')
@section('titleMenu', 'Category')
@section('cssCustom')
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
@endsection
@section('content')
    <div class="sparkline13-list">
        @if ($user->can('viewCategory', Category::class))
        <div class="sparkline13-hd">
            <div class="main-sparkline13-hd">
                <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Category</h1>
            </div>
        </div>
        <div class="sparkline13-graph">
            <div class="datatable-dashv1-list custom-datatable-overright">
                <div id="toolbar">
                    <!-- Button to Open the Add Modal -->
                    <button id="addCategory" class="btn btn-custon-three btn-default" data-toggle="modal" data-target="#add" type="button"
                            title="Add new category"><i class="fa fa-plus"></i> Register
                    </button>
                    <!-- Button to Open the Delete Modal -->
                    <button id="remove" class="btn btn-custon-three btn-danger"
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
                        <th data-field="order" data-editable="true">Order</th>
                        <th data-field="created_at" data-editable="true">Created date</th>
                        <th data-field="status" data-editable="true">Status</th>
                        <th data-field="action">Action</th>
                    </tr>
                    </thead>
                    <tbody class="list-category">
                    @if($category)
                        @foreach($category as $cate)
                            <tr id="category-{{$cate->id}}" data-id="{{ $cate->id }}">
                                <td></td>
                                <td class="text-center">{{$cate->id}}</td>
                                <td class="">{{$cate->category_name}}</td>
                                <td class="text-center">{{$cate->category_order}}</td>
                                <td class="text-center">{{$cate->created_at}}</td>
                                <td class="text-center">@if($cate->category_status == 1) Display @else Not display @endif</td>
                                <td class="datatable-ct text-center">
                                    <button data-toggle="modal" title="Edit {{$cate->category_name}}" class="pd-setting-ed"
                                            data-original-title="Edit" data-target="#edit"
                                            data-id="{{$cate->id}}" data-name="{{$cate->category_name}}"
                                            data-order="{{$cate->category_order}}" data-status="{{$cate->category_status}}"
                                            data-url="{{route(ADMIN_CATEGORY_EDIT, ['id' => $cate->id])}}"
                                            type="button">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    <button data-toggle="modal" title="Delete {{$cate->category_name}}" class="pd-setting-ed"
                                            data-id="{{$cate->id}}" data-url="{{route(ADMIN_CATEGORY_DELETE, ['id' => $cate->id])}}"
                                            data-original-title="Trash" data-target="#delete" type="button">
                                        <i class="fa fa-trash-o" aria-hidden="true"></i>
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
                        <span class="info">{{ $category->currentPage() }} / {{ $category->lastPage() }} pages（total of {{ $category->total() }}）</span>
                        <ul class="pull-right">
                            <li> {{ $category->appends($_GET)->links('backend.pagination') }}</li>
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
                            <form role="form" method="GET" id="formSearch" action="{{ route(ADMIN_CATEGORY_INDEX) }}">
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
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Created at</label>
                                                <input type="text" readonly class="form-control jsDatepcker" name="created_at" value="{{ request()->get('created_at') }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="status" class="required after">Status</label>
                                                <div class="status">
                                                    <div class="jsCheckBox pull-left">
                                                        <input type="checkbox" name="status[]" value="1" {{ App\Helpers\Helper::setCheckedForm('status', 1, 'checked') }}>
                                                        <label><i></i> Display </label>
                                                    </div>
                                                    <div class="jsCheckBox pull-left">
                                                        <input type="checkbox"  name="status[]" value="0" {{ App\Helpers\Helper::setCheckedForm('status', 0, 'checked') }}>
                                                        <label><i></i> Not display </label>
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
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal" id="btnClear" onclick="window.location.href = '{{route(ADMIN_CATEGORY_INDEX)}}'">
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
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Add Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="createCategory">
                                <input type="hidden" name="submit">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="required after">Category Name</label>
                                            <input type="text" class="form-control category-name" name="category_name"
                                                   placeholder="Category Name ....">
                                            <div class="error error_category_name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="order" class="">Order</label>
                                            <input type="number" class="form-control category-order"
                                                   name="category_order" min="0"
                                                   placeholder="Category Order ....">
                                            <div class="error error_category_order hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <div class="category-status">
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="1" name="category_status" checked {{ old('category_status') ? 'checked' : '' }}>
                                                    <label><i></i> Display </label>
                                                </div>
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="0" name="category_status" {{ old('category_status') == 0 && old('category_status') != null ? 'checked' : '' }}>
                                                    <label><i></i> Not display </label>
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
                    <button type="button" class="btn btn-custon-three btn-success add-category" id="btnAddCategory"><i
                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Add
                    </button>
                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal"><i
                            class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
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
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Edit Category
                        &raquo; <span class="title"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="editCategory">
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
                                            <label for="name" class="required after">Category Name</label>
                                            <input type="text" class="form-control category-name" name="category_name"
                                                   placeholder="Category Name ....">
                                            <div class="error error_category_name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="order" class="">Order</label>
                                            <input type="number" class="form-control category-order"
                                                   name="category_order"
                                                   placeholder="Category Order ...." min="0" value="0">
                                            <div class="error error_category_order hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <div class="category-status">
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="1" name="category_status" {{ old('category_status') ? 'checked' : '' }}>
                                                    <label><i></i> Display </label>
                                                </div>
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="0" name="category_status" {{ old('category_status') == 0 && old('category_status') != null ? 'checked' : '' }}>
                                                    <label><i></i> Not display </label>
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
                    <button type="button" class="btn btn-custon-three btn-success" id="btnUpdateCategory"><i
                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Update
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
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="min-height: 70px;">
                        <input type="hidden" name="id" id="categoryId">
                        <input type="hidden" id="urlDelete">
                        <h5 class="modal-title" id="exampleModalLabel" style="line-height: 70px; text-align: center">Do you want to delete category?</h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success" id="btnDeleteCategory"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
                    <button class="btn btn-custon-three btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times edu-danger-error" aria-hidden="true"></i> No</button>
                    <div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/category.js') }}"></script>
    @if ($user->cannot('updateCategory', Category::class))
        <script src="{{ App\Helpers\Helper::asset('backend/js/backend/disabled_checkbox.js') }}"></script>
    @endif
@endsection
