{{
    Form::select('product_category_id', $productCategory, NULL,
    [
        'class' => 'form-control product-category-id jsSelectProductCategory'
    ])
}}
<script type="text/javascript">
    $(document).ready(function () {
        $('.jsSelectProductCategory').chosen({width: "100%"});
    });
</script>
