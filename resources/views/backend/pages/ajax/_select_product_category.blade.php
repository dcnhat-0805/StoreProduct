{{
    Form::select('product_category_id', $productCategory, old('product_category_id'),
    [
        'class' => 'form-control product-category-id jsSelectProductCategory'
    ])
}}
<script type="text/javascript">
    $(document).ready(function () {
        $('.jsSelectProductCategory').chosen({width: "100%"});
    });
</script>
