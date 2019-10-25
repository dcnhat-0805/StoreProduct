<div class="header-top">
    <ul class="breadcrumb" id="hearderTop">
        <li class="breadcrumb_item">
            <a title="Home" href="{{ route(FRONT_END_HOME_INDEX) }}" class="breadcrumb_item_anchor">Home</a>
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </li>
        @if(isset($titleName) && $titleName['category_name'] !== '')
            <li class="breadcrumb_item">
                <a title="{{ isset($titleName['category_name']) ? $titleName['category_name'] : '' }}" class="breadcrumb_item_anchor">
                    {{ isset($titleName['category_name']) ? $titleName['category_name'] : '' }}
                </a>
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </li>
        @endif

        @if(isset($titleName) && $titleName['product_category_name'] !== '' && isset($titleName['product_type_name']) && $titleName['product_type_name'] !== '')
            <li class="breadcrumb_item">
                <a title="{{ isset($titleName['product_category_name']) ? $titleName['product_category_name'] : '' }}" href="{{ route(FRONT_PRODUCT_LIST, ['slug' => $titleName['product_category_slug']]) }}" class="breadcrumb_item_anchor">
                    {{ isset($titleName['product_category_name']) ? $titleName['product_category_name'] : '' }}
                </a>
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </li>
        @else
            <li class="breadcrumb_item">
                <span title="{{ $titleName['product_category_name'] }}" class="breadcrumb_item_anchor">
                    {{ $titleName['product_category_name'] }}
                </span>
            </li>
        @endif

        @if(isset($titleName) && $titleName['product_type_name'] !== '')
            <li class="breadcrumb_item">
                <span title="{{ isset($titleName['product_type_name']) ? $titleName['product_type_name'] : '' }}" class="breadcrumb_item_anchor">
                    {{ isset($titleName['product_type_name']) ? $titleName['product_type_name'] : '' }}
                </span>
            </li>
        @endif
    </ul>
</div>
