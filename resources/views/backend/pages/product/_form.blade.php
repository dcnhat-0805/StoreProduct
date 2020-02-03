@php
    $route = ADMIN_PRODUCT_ADD;
    if ($product->exists) {
        if (isset($is_page_edit) && $is_page_edit) {
            $route = [ADMIN_PRODUCT_UPDATE, $product->id];
        }
    }
    $user = Auth::guard('admins')->user();
@endphp
<div class="sparkline13-list">
    <div class="sparkline13-hd">
        <div class="main-sparkline13-hd">
            <h1 style="text-transform: capitalize;">@yield('headerBlade') <span class="table-project-n">Of</span>
                Product</h1>
        </div>
    </div>
    <div class="sparkline13-graph form-validation">
{{--        @include('backend.layouts.error')--}}

        {{ Form::model($product, ['route' => $route, 'role' => 'form', 'enctype' => 'multipart/form-data', 'id' => 'createProduct']) }}

            @if(isset($is_page_edit))
                <div class="row">
                    <div class="col-sm-12">
                        <div class="form-group">
                            <label for="product_name" class="">ID</label>
                            {{
                                Form::text('id', isset($product) && $product->id ? $product->id : null,
                                [
                                    'class' => 'form-control product-id',
                                    'readonly' => '',
                                    'disabled' => true
                                ])
                            }}
                        </div>
                    </div>
                </div>
            @endif
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="category_id" class="required after">Category</label>
                        <div class="category">
                            {{
                                Form::select('category_id', $category, isset($product) && $product->category_id ? $product->category_id : old('category_id'),
                                [
                                    'class' => 'form-control category-id jsSelectCategory'
                                ])
                            }}
                        </div>
                        <div
                            class="error error_category_id {{ !$errors->has('category_id') ? 'hidden' : '' }}">{{ $errors->has('category_id') ? $errors->first('category_id') : '' }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="product_category_id" class="required after">Product category</label>
                        <div class="productCategory">
                            {{
                                Form::select('product_category_id', $productCategories, isset($product) && $product->product_category_id ? $product->product_category_id : old('product_category_id'),
                                [
                                    'class' => 'form-control product-category-id jsSelectProductCategory',
                                ])
                            }}
                        </div>
                        <div
                            class="error error_product_category_id {{ !$errors->has('product_category_id') ? 'hidden' : '' }}">{{ !$errors->has('product_category_id') || $errors->has('category_id') ? '' : $errors->first('product_category_id') }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="product_type_id" class="">Product type</label>
                        <div class="productType">
                            {{
                                Form::select('product_type_id', $productTypes, isset($product) && $product->product_type_id ? $product->product_type_id : old('product_type_id'),
                                [
                                    'class' => 'form-control product-type-id jsSelectProductType',
                                ])
                            }}
                        </div>
                        <div
                            class="error error_product_type_id {{ !$errors->has('product_type_id') ? 'hidden' : '' }}">{{ !$errors->has('product_type_id') || $errors->has('category_id') || $errors->has('product_category_id') ? '' : $errors->first('product_type_id') }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="product_name" class="required after">Product name</label>
                        <input type="text" class="form-control product-name" name="product_name"
                               placeholder="Product type Name ...." value="{{ isset($product) && $product->product_name ? $product->product_name : old('product_name') }}">
                        <div class="error error_product_name {{ !$errors->has('product_name') ? 'hidden' : '' }}">{{ !$errors->has('product_name') ? '' : $errors->first('product_name') }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group" id="uploadProductImage">
                        <label for="product_image" class="required after">Product images</label>

                        <div class="dz-wrapper">
                            <div id="jsProductImage01" class="dropzone dz-clickable">
                                <div class="dz-default dz-message">
                                    <button type="button" class="btn btn-secondary image">
                                        <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                        <span>Select from folder</span>
                                    </button>
                                    <p class="info">Drag and drop files here <wbr>or select from folders</p>
                                </div>
                            </div>
                            <div id="jsProductImagePreviews01" class="dropzone previews ui-sortable"></div>
                        </div>
                        <div class="error error_product_image {{ !$errors->has('product_image') ? 'hidden' : '' }}">{{ !$errors->has('product_image') ? '' : $errors->first('product_image') }}</div>
                        {{ Form::hidden('dataImage01', isset($product) && $product->product_image ? $product->product_image : null, [
                                'id' => 'dataImage01',
                        ]) }}
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label for="product_image" class="">Image attached to the product</label>

                        <div class="dz-wrapper">
                            <div id="jsImageList01" class="dropzone dz-clickable">
                                <div class="dz-default dz-message">
                                    <button type="button" class="btn btn-secondary image">
                                        <i class="fa fa-cloud-download" aria-hidden="true"></i>
                                        <span>Select from folder</span>
                                    </button>
                                    <p class="info">Drag and drop files here <wbr>or select from folders</p>
                                </div>
                            </div>
                            <div id="jsImageListPreviews01" class="dropzone previews ui-sortable"></div>
                        </div>
                        <div class="error error_product_image_list hidden"></div>
                        {{ Form::hidden('dataImage02', isset($product) && $product->product_image_list ? $product->product_image_list : null, [
                                'id' => 'dataImage02',
                        ]) }}
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_description" class="required after">Description product</label>
                        <textarea name="product_description" class="product-description" id="">{!! isset($product) && $product->product_description ? $product->product_description : old('product_description') !!}</textarea>
                        <div class="error error_product_description {{ !$errors->has('product_description') ? 'hidden' : '' }}">{{ $errors->has('product_description') ? $errors->first('product_description') : '' }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_content" class="required after">Contents product</label>
                        <textarea name="product_content" class="product-content"
                                  id="contentProduct">{!! isset($product) && $product->product_content ? $product->product_content : old('product_content') !!}</textarea>
                        <div class="error error_product_content {{ !$errors->has('product_content') ? 'hidden' : '' }}">{{ $errors->has('product_content') ? $errors->first('product_content') : '' }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="product_option" class="">Product options</label>
                        <div class="product-options">
                            <div class="jsRadio pull-left">
                                <input type="radio" value="1" name="product_option"
                                        {{ (isset($product) && $product->product_option == 1) || (old('product_option') == 1) ? 'checked' : '' }}>
                                <label><i></i> Best </label>
                            </div>
                            <div class="jsRadio pull-left">
                                <input type="radio" value="2" name="product_option"
                                        {{ (isset($product) && $product->product_option == 2) || (old('product_option') == 2) ? 'checked' : '' }}>
                                <label><i></i> New </label>
                            </div>
                            <div class="jsRadio pull-left">
                                <input type="radio" value="3" name="product_option"
                                        {{ (isset($product) && $product->product_option == 3) || (old('product_option') == 3) ? 'checked' : '' }}>
                                <label><i></i> Hot </label>
                            </div>
                            <div class="jsRadio pull-left">
                                <input type="radio" value="4" name="product_option"
                                        {{ (isset($product) && $product->product_option == 4) || (old('product_option') == 4) ? 'checked' : '' }}>
                                <label><i></i> Promotion </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_price" class="required after">Price product</label>
                        <input type="number" class="form-control" name="product_price" placeholder="Price product ..."
                               value="{{ isset($product) && $product->product_price ? $product->product_price : old('product_price') }}" min="0">
                        <div class="error error_product_price {{ !$errors->has('product_price') ? 'hidden' : '' }}">{{ $errors->has('product_price') ? $errors->first('product_price') : '' }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_promotion" class="">Promotion product </label>
                        <input type="number" class="form-control" name="product_promotion"
                               placeholder="Promotional product ..." value="{{ isset($product) && $product->product_promotion ? $product->product_promotion : old('product_promotion') }}" min="0">
                        <div class="error error_product_promotion {{ !$errors->has('product_promotion') ? 'hidden' : '' }}">{{ $errors->has('product_promotion') ? $errors->first('product_promotion') : '' }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_quantity" class="required after">Product quantity</label>
                        <input type="number" class="form-control" name="product_quantity"
                               placeholder="Product quantity ..." value="{{ isset($product) && $product->product_quantity ? $product->product_quantity : old('product_quantity') }}">
                        <div class="error error_product_quantity {{ !$errors->has('product_quantity') ? 'hidden' : '' }}">{{ $errors->has('product_quantity') ? $errors->first('product_quantity') : '' }}</div>
                        <div class="jsCheckBox pull-left" style="margin: 10px 0">
                            <input type="checkbox" name="product_is_free_ship" value="1" checked {{ (isset($product) && $product->product_is_free_ship === 1 || old('product_is_free_ship')) ? 'checked' : '' }}>
                            <label><i></i> Is free shipping </label>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_meta_title" class="">Meta title</label>
                        <input type="text" class="form-control" name="product_meta_title"
                               placeholder="Meta title ..." value="{{ isset($product) && $product->product_meta_title ? $product->product_meta_title : old('product_meta_title') }}">
                        <div class="error error_product_meta_title {{ !$errors->has('product_meta_title') ? 'hidden' : '' }}">{{ $errors->has('product_meta_title') ? $errors->first('product_meta_title') : '' }}</div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="form-group">
                        <label for="product_meta_description" class="">Meta description</label>
                        <input type="text" class="form-control" name="product_meta_description"
                               placeholder="Meta description ..." value="{{ isset($product) && $product->product_meta_description ? $product->product_meta_description : old('product_meta_description') }}">
                        <div class="error error_product_meta_description {{ !$errors->has('product_meta_description') ? 'hidden' : '' }}">{{ $errors->has('product_meta_description') ? $errors->first('product_meta_description') : '' }}</div>
                    </div>
                </div>
            </div>

            <!-- Product attribute -->
            @include('backend.pages.product._attribute')

            <div class="row">
                <div class="col-sm-12">
                    <div class="form-group">
                        <label for="status" class="required after">Status</label>
                        <div class="product-status">
                            <div class="jsRadio pull-left">
                                <input type="radio" value="1" name="product_status"
                                       checked {{ (isset($product) && $product->product_status == 1) || old('product_status') ? 'checked' : '' }}>
                                <label><i></i> Display </label>
                            </div>
                            <div class="jsRadio pull-left">
                                <input type="radio" value="0"
                                       name="product_status" {{ (isset($product) && $product->product_status == 0 && $product->product_status != null) || (old('product_status') == 0 && old('product_status') != null) ? 'checked' : '' }}>
                                <label><i></i> Not display </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer form_footer">
                <input type="hidden" name="submit">
                @if(isset($is_page_register))
                <button type="submit" class="btn btn-custon-three btn-success add-category product" id="btnAddProduct"><i
                        class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Add
                </button>
                @else
                    <button type="submit" class="btn btn-custon-three btn-success product" id="btnUpdateProduct"><i
                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Update
                    </button>
                @endif
            </div>
        {{ Form::close() }}
    </div>
</div>
@section('jsCustom')
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/product.js') }}"></script>
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/product_register.js') }}"></script>
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/product_image_list.js') }}"></script>
    @if ($user->cannot('updateProductType', App\Models\ProductType::class))
        <script src="{{ App\Helpers\Helper::asset('backend/js/backend/disabled_checkbox.js') }}"></script>
    @endif
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/disabled_button_submit.js') }}"></script>
@endsection
