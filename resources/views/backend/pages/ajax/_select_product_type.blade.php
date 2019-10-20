{{
    Form::select('product_type_id', $productTypes, old('product_type_id'),
    [
        'class' => 'form-control product-type-id jsSelectProductType'
    ])
}}
<script type="text/javascript">
    $(document).ready(function () {
        $('.jsSelectProductType').chosen({width: "100%"});
    });
</script>
