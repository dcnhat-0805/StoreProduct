{{
    Form::select('product_type_id', $productTypes, NULL,
    [
        'class' => 'form-control product-type-id jsSelectProductType'
    ])
}}
<script type="text/javascript">
    $(document).ready(function () {
        $('.jsSelectProductType').chosen({width: "100%"});
    });
</script>
