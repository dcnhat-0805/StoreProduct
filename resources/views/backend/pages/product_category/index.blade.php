@php
    use App\Models\ProductCategory;
    $params = $_GET;
    unset($params['sort']);
    unset($params['desc']);

    $user = Auth::guard('admins')->user();
@endphp
@extends('backend.layouts.app')
@section('title', 'List product category')
@section('titleMenu', 'Product Category')
@section('cssCustom')
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
@endsection
@section('content')
    <div class="sparkline13-list">
        @if ($user->can('viewProductCategory', ProductCategory::class))
        <div class="sparkline13-hd">
            <div class="main-sparkline13-hd">
                <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Product Category</h1>
            </div>
        </div>
        <div class="sparkline13-graph">
            <div class="datatable-dashv1-list custom-datatable-overright">
                <div id="toolbar">
                    <!-- Button to Open the Add Modal -->
                    <button id="addProductCategory" class="btn btn-custon-three btn-default" data-toggle="modal" data-target="#add" type="button"
                            title="Add new product category"><i class="fa fa-plus"></i> Register
                    </button>
                    <!-- Button to Open the Delete Modal -->
                    <button id="removeProductCategory" class="btn btn-custon-three btn-danger"
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
                        <th data-field="category_name" data-editable="true">Category name</th>
                        <th data-field="name" data-editable="true">Name</th>
                        <th data-field="created_at" data-editable="true">Created date</th>
                        <th data-field="status" data-editable="true">Status</th>
                        <th data-field="action">Action</th>
                    </tr>
                    </thead>
                    <tbody class="list-category">
                    @if($productCategories)
                        @foreach($productCategories as $productCategory)
                            <tr id="category-{{$productCategory->id}}" data-id="{{ $productCategory->id }}">
                                <td></td>
                                <td class="text-center">{{$productCategory->id}}</td>
                                <td class="">{{$productCategory->category->category_name}}</td>
                                <td class="">{{$productCategory->product_category_name}}</td>
                                <td class="text-center">{{$productCategory->created_at}}</td>
                                <td class="text-center">@if($productCategory->product_category_status == 1) Display @else Not display @endif</td>
                                <td class="datatable-ct text-center">
                                    <button data-toggle="modal" title="Edit {{$productCategory->product_category_name}}" class="pd-setting-ed"
                                            data-original-title="Edit" data-target="#edit"
                                            data-id="{{$productCategory->id}}" data-name="{{$productCategory->product_category_name}}"
                                            data-status="{{$productCategory->product_category_status}}"
                                            data-category="{{$productCategory->category->id}}"
                                            data-url="{{route(ADMIN_PRODUCT_CATEGORY_EDIT, ['id' => $productCategory->id])}}"
                                            type="button">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    <button data-toggle="modal" title="Delete {{$productCategory->product_category_name}}" class="pd-setting-ed"
                                            data-id="{{$productCategory->id}}" data-url="{{route(ADMIN_PRODUCT_CATEGORY_DELETE, ['id' => $productCategory->id])}}"
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
                        <span class="info">{{ $productCategories->currentPage() }} / {{ $productCategories->lastPage() }} pages（total of {{ $productCategories->total() }}）</span>
                        <ul class="pull-right">
                            <li> {{ $productCategories->appends($_GET)->links('backend.pagination') }}</li>
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
                            <form role="form" method="GET" id="formSearch" action="{{ route(ADMIN_PRODUCT_CATEGORY_INDEX) }}">
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
                                                <label for="name">Category</label>
                                                <div class="category">
                                                    {{
                                                        Form::select('category_id', $category, request()->get('category_id'),
                                                        [
                                                            'class' => 'form-control category-id jsSelectCategory'
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
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal" id="btnClear" onclick="window.location.href = '{{route(ADMIN_PRODUCT_CATEGORY_INDEX)}}'">
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
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Add Product Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="createProductCategory">
                                <input type="hidden" name="submit">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="category_id" class="required after">Category</label>
                                            <div class="category">
                                                {{
                                                    Form::select('category_id', $category, request()->get('category_id'),
                                                    [
                                                        'class' => 'form-control category-id jsSelectCategory'
                                                    ])
                                                }}
                                            </div>
                                            <div class="error error_category_id hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="required after">Product category name</label>
                                            <input type="text" class="form-control product-category-name" name="product_category_name"
                                                   placeholder="Product category Name ....">
                                            <div class="error error_product_category_name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <div class="product-category-status">
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="1" name="product_category_status" checked {{ old('product_category_status') ? 'checked' : '' }}>
                                                    <label><i></i> Display </label>
                                                </div>
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="0" name="product_category_status" {{ old('product_category_status') == 0 && old('product_category_status') != null ? 'checked' : '' }}>
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
                    <button type="button" class="btn btn-custon-three btn-success add-category" id="btnAddProductCategory"><i
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
                            <form role="form" method="post" id="editProductCategory">
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
                                            <label for="category_id" class="required after">Category</label>
                                            <div class="category">
                                                {{
                                                    Form::select('category_id', $category, request()->get('category_id'),
                                                    [
                                                        'class' => 'form-control category-id jsSelectCategory'
                                                    ])
                                                }}
                                            </div>
                                            <div class="error error_category-id hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="required after">Product category name</label>
                                            <input type="text" class="form-control product-category-name" name="product_category_name"
                                                   placeholder="Product category Name ....">
                                            <div class="error error_product_category_name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <div class="product-category-status">
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="1" name="product_category_status" {{ old('product_category_status') ? 'checked' : '' }}>
                                                    <label><i></i> Display </label>
                                                </div>
                                                <div class="jsRadio pull-left">
                                                    <input type="radio" value="0" name="product_category_status" {{ old('product_category_status') == 0 && old('product_category_status') != null ? 'checked' : '' }}>
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
                    <button type="button" class="btn btn-custon-three btn-success" id="btnUpdateProductCategory"><i
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
                        <input type="hidden" name="id" id="productCategoryId">
                        <input type="hidden" id="urlDelete">
                        <h5 class="modal-title" id="exampleModalLabel" style="line-height: 70px; text-align: center">Do you want to delete product category?</h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success" id="btnDeleteProductCategory"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
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
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/product_category.js') }}"></script>
    @if ($user->cannot('updateProductCategory', ProductCategory::class))
        <script src="{{ App\Helpers\Helper::asset('backend/js/backend/disabled_checkbox.js') }}"></script>
    @endif
@endsection
