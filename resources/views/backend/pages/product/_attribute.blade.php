<div class="row">
    <div class="col-md-12">
        <div class="form-group">
            <label for="product_weight" class="">Product attributes</label>
            <div class="formAddProductAttribute">
                <div class="row">
                    <div class="col-sm-5 text-center">Product attribute name</div>
                    <div class="col-sm-5 text-center">Product attribute items name</div>
                    <div class="col-sm-2">Is filterable</div>
                </div>
                @if(count($product->product_attribute))
                    @foreach($product->product_attribute as $key => $attributes)
                        <div class="row jsProductAttribute ">
                            <div class="productAttribute">
                                <div class="col-sm-5">
                                    <input type="hidden" class="form-control"
                                           name="attributes[{{ $key }}][attribute_code]"
                                           placeholder="Example: Size or Color ..."
                                           value="{{ $attributes->attribute_code }}">
                                    {{
                                        Form::select('attributes[' . $key . '][attribute_name]', PRODUCT_ATTRIBUTE, $attributes->attribute_name,
                                        [
                                            'class' => 'form-control product-attribute'
                                        ])
                                    }}
                                </div>
                                <div class="col-sm-5">
                                    <input type="text" class="form-control"
                                           name="attributes[{{ $key }}][attribute_item_name]"
                                           placeholder="Example: M or L or XL ..."
                                           value="{{ $attributes->attribute_item_name }}">
                                </div>
                                <div class="col-sm-2">
                                    <div class="jsCheckBox pull-left">
                                        <input type="checkbox" name="attributes[{{ $key }}][is_filterable]"
                                               checked value="1" {{ $attributes->is_filterable === 1 ? 'checked' : '' }}>
                                        <label><i></i> </label>
                                    </div>
                                </div>
                            </div>
                            @if($key == (count($product->product_attribute) - 1))
                                <button class="btn btn-custon-three btn-default addProductAttribute" type="button"
                                        title="Add new product attribute"><i class="fa fa-plus"></i>
                                </button>
                            @endif
                        </div>
                    @endforeach
                @else
                    <div class="row jsProductAttribute ">
                        <div class="productAttribute">
                            <div class="col-sm-5">
                                {{
                                    Form::select('attributes[0][attribute_name]', PRODUCT_ATTRIBUTE, null,
                                    [
                                        'class' => 'form-control product-attribute'
                                    ])
                                }}
                            </div>
                            <div class="col-sm-5">
                                <input type="text" class="form-control" name="attributes[0][attribute_item_name]"
                                       placeholder="Example: M or L or XL ..." value="">
                            </div>
                            <div class="col-sm-2">
                                <div class="jsCheckBox pull-left">
                                    <input type="checkbox" name="attributes[0][is_filterable]" value="1" checked>
                                    <label><i></i> </label>
                                </div>
                            </div>
                            <button class="btn btn-custon-three btn-default addProductAttribute" type="button"
                                    title="Add new product attribute"><i class="fa fa-plus"></i>
                            </button>
                            <button class="btn btn-custon-three btn-default removeProductAttribute" type="button"
                                    title="Add new product attribute"><i class="fa fa-minus" aria-hidden="true"></i></i>
                            </button>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
