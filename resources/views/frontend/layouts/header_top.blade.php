<div class="header-top">
    <ul class="breadcrumb" id="hearderTop">
        <li class="breadcrumb_item">
            <a title="Home" href="{{ route(FRONT_END_HOME_INDEX) }}" class="breadcrumb_item_anchor">Home</a>
            <i class="fa fa-chevron-right" aria-hidden="true"></i>
        </li>
        @if(count($titleName) && $titleName['category_name'] !== '')
            <li class="breadcrumb_item">
                <a title="{{ count($titleName['category_name']) ? $titleName['category_name'] : '' }}" class="breadcrumb_item_anchor">
                    {{ count($titleName['category_name']) ? $titleName['category_name'] : '' }}
                </a>
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </li>
        @endif

        @if(count($titleName) && $titleName['product_category_name'] !== '' && count($titleName['product_type_name']) && $titleName['product_type_name'] !== '')
            <li class="breadcrumb_item">
                <a title="{{ $titleName['product_category_name'] }}" href="{{ route(FRONT_PRODUCT_LIST, ['slug' => $titleName['product_category_slug']]) }}" class="breadcrumb_item_anchor">
                    {{ $titleName['product_category_name'] }}
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

        @if(count($titleName) && $titleName['product_type_name'] !== '' && !$titleName['product_name'])
            <li class="breadcrumb_item">
                <span title="{{ $titleName['product_type_name'] }}" class="breadcrumb_item_anchor">
                    {{ $titleName['product_type_name'] }}
                </span>
            </li>
        @elseif(count($titleName) && $titleName['product_type_name'] !== '' && $titleName['product_name'])
            <li class="breadcrumb_item">
                <a title="{{ $titleName['product_type_name'] }}" href="{{ route(FRONT_PRODUCT_LIST, ['slug' => $titleName['product_type_slug']]) }}" class="breadcrumb_item_anchor">
                    {{ $titleName['product_type_name'] }}
                </a>
                <i class="fa fa-chevron-right" aria-hidden="true"></i>
            </li>
        @endif

        @if(count($titleName) && $titleName['product_name'] !== '')
            <li class="breadcrumb_item">
                <span title="{{ $titleName['product_name'] }}" class="breadcrumb_item_anchor">
                    {{ $titleName['product_name'] }}
                </span>
            </li>
        @endif

        @if(count($namePage) && $namePage !== '')
            <li class="breadcrumb_item">
                <span title="{{ $namePage }}" class="breadcrumb_item_anchor">
                    {{ $namePage }}
                </span>
            </li>
        @endif
    </ul>
</div>
