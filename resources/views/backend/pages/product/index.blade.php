@php
    use App\Models\ProductType;
    $params = $_GET;
    unset($params['sort']);
    unset($params['desc']);

    $user = Auth::guard('admins')->user();
@endphp
@extends('backend.layouts.app')
@section('title', 'List product')
@section('titleMenu', 'Product')
@section('cssCustom')
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/form/all-type-forms.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/normalize.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/demo.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/component.css') }}" />
    <!-- summernote CSS
		============================================ -->
    <link rel="stylesheet" href="{{ App\Helpers\Helper::asset('backend/css/summernote/summernote.css') }}">
@endsection
@section('content')
    <div class="sparkline13-list">
        @if ($user->can('viewProductType', ProductType::class))
            <div class="sparkline13-hd">
                <div class="main-sparkline13-hd">
                    <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Product</h1>
                </div>
            </div>
            <div class="sparkline13-graph">
                <div class="datatable-dashv1-list custom-datatable-overright">
                    <div id="toolbar">
                        <!-- Button to Open the Add Modal -->
                        <button id="addProductType" class="btn btn-custon-three btn-default" type="button"
                                onclick="window.location.href = '{{ route(ADMIN_PRODUCT_ADD_INDEX) }}'"
                                title="Add new product"><i class="fa fa-plus"></i> Register
                        </button>
                        <!-- Button to Open the Delete Modal -->
                        <button id="removeProductType" class="btn btn-custon-three btn-danger"
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
                            <th data-field="product_category_name" data-editable="true">Product category name</th>
                            <th data-field="product_type_name" data-editable="true">Product type name</th>
                            <th data-field="name" data-editable="true">Name</th>
                            <th data-field="created_at" data-editable="true">Created date</th>
                            <th data-field="status" data-editable="true">Status</th>
                            <th data-field="action">Action</th>
                        </tr>
                        </thead>
                        <tbody class="list-category">
{{--                        @if($productTypes)--}}
{{--                            @foreach($productTypes as $productType)--}}
{{--                                <tr id="category-{{$productType->id}}" data-id="{{ $productType->id }}">--}}
{{--                                    <td></td>--}}
{{--                                    <td class="text-center">{{$productType->id}}</td>--}}
{{--                                    <td class="">{{$productType->category->category_name}}</td>--}}
{{--                                    <td class="">{{$productType->productcategory->product_category_name}}</td>--}}
{{--                                    <td class="">{{$productType->product_type_name}}</td>--}}
{{--                                    <td class="text-center">{{$productType->created_at}}</td>--}}
{{--                                    <td class="text-center">@if($productType->product_type_status == 1) Display @else Not display @endif</td>--}}
{{--                                    <td class="datatable-ct text-center">--}}
{{--                                        <button data-toggle="modal" title="Edit {{$productType->product_type_name}}" class="pd-setting-ed"--}}
{{--                                                data-original-title="Edit" data-target="#edit"--}}
{{--                                                data-id="{{$productType->id}}" data-name="{{$productType->product_type_name}}"--}}
{{--                                                data-status="{{$productType->product_type_status}}"--}}
{{--                                                data-category="{{$productType->category->id}}"--}}
{{--                                                data-product_category="{{$productType->productCategory->id}}"--}}
{{--                                                data-url="{{route(ADMIN_PRODUCT_TYPE_EDIT, ['id' => $productType->id])}}" type="button">--}}
{{--                                            <i class="fa fa-pencil-square-o" aria-hidden="true"></i>--}}
{{--                                        </button>--}}
{{--                                        <button data-toggle="modal" title="Delete {{$productType->product_type_name}}" class="pd-setting-ed"--}}
{{--                                                data-id="{{$productType->id}}" data-url="{{route(ADMIN_PRODUCT_TYPE_DELETE, ['id' => $productType->id])}}"--}}
{{--                                                data-original-title="Trash" data-target="#delete" type="button">--}}
{{--                                            <i class="fa fa-trash-o" aria-hidden="true"></i>--}}
{{--                                        </button>--}}
{{--                                    </td>--}}
{{--                                </tr>--}}
{{--                            @endforeach--}}
{{--                        @endif--}}
                        </tbody>
                    </table>

                    <!-- Pagination -->
{{--                    <div class="pagination-wrapper header" style="margin-top: 20px;">--}}
{{--                        <nav class="nav-pagination store-unit clearfix" aria-label="Page navigation">--}}
{{--                            <span class="info">{{ $productTypes->currentPage() }} / {{ $productTypes->lastPage() }} pages（total of {{ $productTypes->total() }}）</span>--}}
{{--                            <ul class="pull-right">--}}
{{--                                <li> {{ $productTypes->appends($_GET)->links('backend.pagination') }}</li>--}}
{{--                            </ul>--}}
{{--                        </nav>--}}
{{--                    </div>--}}
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
                            <form role="form" method="GET" id="formSearch" action="{{ route(ADMIN_PRODUCT_TYPE_INDEX) }}">
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
                                                <input type="text" readonly class="form-control jsDatepcker" name="created_at" value="{{ request()->get('created_at') }}" >
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Category</label>
                                                {{
                                                    Form::select('category_id', $category, request()->get('category_id'),
                                                    [
                                                        'class' => 'form-control category-id'
                                                    ])
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Product category</label>
                                                {{
                                                    Form::select('product_category_id', $productCategories, request()->get('product_category_id'),
                                                    [
                                                        'class' => 'form-control',
                                                        'id' => 'productCategoryId'
                                                    ])
                                                }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="checkbox" class="i-checks" name="status[]" value="1" {{ App\Helpers\Helper::setCheckedForm('status', 1, 'checked') }}>
                                                <label for="status" style="margin-right: 20px;">Display</label>
                                                <input type="checkbox" class="i-checks"  name="status[]" value="0" {{ App\Helpers\Helper::setCheckedForm('status', 0, 'checked') }}>
                                                <label for="status">Not display</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-custon-three btn-success" id="btnSearch"><i
                                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal" id="btnClear" onclick="window.location.href = '{{route(ADMIN_PRODUCT_TYPE_INDEX)}}'">
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
        <div class="modal-dialog" role="document" style="min-width: 70%;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Add Product Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>

                <div class="tinymce-area mg-b-15">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                <div class="tinymce-single responsive-mg-b-30">
                                    <div class="alert-title">
                                        <h2>Basic Summernote WYSIWYG editor</h2>
                                        <p>The fastest way to get Summernote WYSIWYG editor is powerfull JavaScript plugin. you can easily maintance typography system.</p>
                                    </div>
                                    <div id="summernote1">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route(ADMIN_PRODUCT_ADD) }}" id="addProduct" enctype="multipart/form-data" method="POST">
                    <div class="modal-body">
                        <div class="row" style="margin: 5px">
                            <div class="col-lg-12">
                                @csrf
                                <div class="box-body">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="category_id" class="required after">Category</label>
                                                    {{
                                                        Form::select('category_id', $category, NULL,
                                                        [
                                                            'class' => 'form-control category-id'
                                                        ])
                                                    }}
                                                    <div class="error error-category-id hidden"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="product_category_id" class="required after">Product category</label>
                                                    {{
                                                        Form::select('product_category_id', $productCategories, NULL,
                                                        [
                                                            'class' => 'form-control product-category-id'
                                                        ])
                                                    }}
                                                    <div class="error error-product-category-id hidden"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="product_type_id" class="required after">Product type</label>
                                                    {{
                                                        Form::select('product_type_id', $productTypes, NULL,
                                                        [
                                                            'class' => 'form-control product-type-id'
                                                        ])
                                                    }}
                                                    <div class="error error-product-type-id hidden"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="name" class="required after">Product name</label>
                                                    <input type="text" class="form-control product-name" name="product_name"
                                                           placeholder="Product type Name ....">
                                                    <div class="error error-product-name hidden"></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="product_image" class="required after">Product images</label>

                                                    <div class="box">
                                                        <input type="file" name="product_image" id="product_image" class="jsUploadFile inputUpload" data-multiple-caption="{count} files selected" />
                                                        <label for="product_image">
                                                            <figure>
                                                                <img src="backend/assets/file_input.svg" alt="">
                                                            </figure>
                                                            <span></span>
                                                        </label>
                                                        <div class="error error-product-type-name hidden"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
                                                    <label for="product_image" class="">Image attached to the product</label>
                                                    <div class="box">
                                                        <input type="file" name="image_list[]" id="image_list" class="jsUploadFileMultiple inputUpload" data-multiple-caption="{count} files selected" multiple />
                                                        <label for="image_list">
                                                            <figure>
                                                                <img src="backend/assets/file_input.svg" alt="">
                                                            </figure>
                                                            <span></span>
                                                        </label>
                                                        <div class="error error-product-type-name hidden"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name" class="required after">Description product</label>
                                                <textarea name="product_description" class="product-description" id="descriptionProduct"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name" class="required after">Contents product</label>
                                                <textarea name="product_content" class="product-content" id="contentProduct"></textarea>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name" class="required after">Price product</label>
                                                <input type="text" class="form-control" name="product_price" placeholder="Price product ...">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <label for="name">Promotional product </label>
                                                <input type="text" class="form-control" name="product_promotional" placeholder="Promotional product ...">
                                            </div>
                                        </div>
                                    </div>
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="form-group">
                                                    <label for="status" class="required after">Status</label>
                                                    <select class="form-control product-status" name="product_status">
                                                        <option value="1" class="display">Display</option>
                                                        <option value="0" class="not-display">Not Display</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!-- /.box-body -->
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                    <button type="submit" class="btn btn-custon-three btn-success add-category" id="btnAddProduct"><i
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
    <!-- Edit Modal-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Edit Product Type
                        &raquo; <span class="title"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="editProductType">
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
                                            {{
                                                Form::select('category_id', $category, NULL,
                                                [
                                                    'class' => 'form-control category-id'
                                                ])
                                            }}
                                            <div class="error error-category-id hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="product_category_id" class="required after">Product category</label>
                                            {{
                                                Form::select('product_category_id', $productCategories, NULL,
                                                [
                                                    'class' => 'form-control product-category-id'
                                                ])
                                            }}
                                            <div class="error error-product-category-id hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="required after">Product type name</label>
                                            <input type="text" class="form-control product-type-name" name="product_type_name"
                                                   placeholder="Product type Name ....">
                                            <div class="error error-product-type-name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <select class="form-control product-type-status" name="product_type_status">
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
                    <button type="button" class="btn btn-custon-three btn-success" id="btnUpdateProductType"><i
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
                        <h5 class="modal-title" id="exampleModalLabel" style="line-height: 70px; text-align: center">Do you want to delete product type?</h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success" id="btnDeleteProductType"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
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
    <!-- summernote JS
		============================================ -->
    <script src="{{ App\Helpers\Helper::asset('backend/js/summernote/summernote.min.js') }}"></script>
    <script src="{{ App\Helpers\Helper::asset('backend/js/summernote/summernote-active.js') }}"></script>
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/product.js') }}"></script>
    @if ($user->cannot('updateProductType', ProductType::class))
        <script src="{{ App\Helpers\Helper::asset('backend/js/backend/disabled_checkbox.js') }}"></script>
    @endif
@endsection
