@php
    use App\Models\ProductType;
    $params = $_GET;
    unset($params['sort']);
    unset($params['desc']);

    $user = Auth::guard('admins')->user();
@endphp
@extends('backend.layouts.app')
@section('title', 'Create product')
@section('titleMenu', 'Create product')
@section('cssCustom')
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/form/all-type-forms.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/normalize.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/demo.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/component.css') }}" />
@endsection
@section('content')
    <div class="sparkline13-list">
        <div class="sparkline13-hd">
            <div class="main-sparkline13-hd">
                <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Product</h1>
            </div>
        </div>
        <div class="sparkline13-graph form-validation">
            @include('backend.layouts.error')
            <form action="{{ route(ADMIN_PRODUCT_ADD) }}" id="createProduct" enctype="multipart/form-data" method="POST">
                @csrf
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="category_id" class="required after">Category</label>
                            <div class="category">
                                {{
                                    Form::select('category_id', $category, old('category_id'),
                                    [
                                        'class' => 'form-control category-id jsSelectCategory'
                                    ])
                                }}
                            </div>
                            <div class="error error_category_id hidden"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="product_category_id" class="required after">Product category</label>
                            <div class="productCategory">
                                {{
                                    Form::select('product_category_id', $productCategories, old('product_category_id'),
                                    [
                                        'class' => 'form-control product-category-id jsSelectProductCategory'
                                    ])
                                }}
                            </div>
                            <div class="error error_product_category_id hidden"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="product_type_id" class="required after">Product type</label>
                            <div class="productType">
                                {{
                                    Form::select('product_type_id', $productTypes, old('product_type_id'),
                                    [
                                        'class' => 'form-control product-type-id jsSelectProductType'
                                    ])
                                }}
                            </div>
                            <div class="error error_product_type_id hidden"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="product_name" class="required after">Product name</label>
                            <input type="text" class="form-control product-name" name="product_name"
                                   placeholder="Product type Name ...." value="{{ old('product_name') }}">
                            <div class="error error_product_name hidden"></div>
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
                                <div class="error error_product_image hidden"></div>
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
                                <div class="error error_product_image_list hidden"></div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="product_description" class="required after">Description product</label>
                            <textarea name="product_description" class="product-description" id="descriptionProduct">{{ old('product_description') }}</textarea>
                            <div class="error error_product_description hidden"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="product_content" class="required after">Contents product</label>
                            <textarea name="product_content" class="product-content" id="contentProduct">{{ old('product_content') }}</textarea>
                            <div class="error error_product_content hidden"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="product_price" class="required after">Price product</label>
                            <input type="number" class="form-control" name="product_price" placeholder="Price product ..." value="{{ old('product_price') }}" min="0">
                            <div class="error error_product_price hidden"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label for="product_promotional" class="required after">Promotional product </label>
                            <input type="number" class="form-control" name="product_promotional" placeholder="Promotional product ..." value="{{ old('product_promotional') }}">
                            <div class="error error_product_promotional hidden"></div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="status" class="required after">Status</label>
                            <div class="product-status">
                                <div class="jsRadio pull-left">
                                    <input type="radio" value="1" name="product_status" checked {{ old('product_status') ? 'checked' : '' }}>
                                    <label><i></i> Display </label>
                                </div>
                                <div class="jsRadio pull-left">
                                    <input type="radio" value="0" name="product_status" {{ old('product_status') == 0 && old('product_status') != null ? 'checked' : '' }}>
                                    <label><i></i> Not display </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer form_footer">
                    <button type="button" class="btn btn-custon-three btn-success add-category" id="btnAddProduct"><i
                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Add
                    </button>
                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal"><i
                            class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
@section('jsCustom')
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/product.js') }}"></script>
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/product_register.js') }}"></script>
    @if ($user->cannot('updateProductType', ProductType::class))
        <script src="{{ App\Helpers\Helper::asset('backend/js/backend/disabled_checkbox.js') }}"></script>
    @endif
@endsection
