<!-- product left -->
{{--@dd(request()->url())--}}
@php
    $route = FRONT_PRODUCT_LIST;
    if (isset($is_page_search) && $is_page_search) {
    $route = FRONT_LOAD_DATA_SEARCH;
    }
    if (isset($slug)) {
        $searchParams = ['slug' => $slug];
    }
    if (isset($params)) {
       $searchParams = $params;
    }
    if (isset($_GET['rating'])) {
       unset($_GET['rating']);
    }
    $searchParams = array_merge($searchParams, $_GET);
@endphp
<input type="hidden" class="description" value="{{ isset($slug) ? $slug : '' }}">
<div class="side-bar col-sm-12">
    <!-- price range -->
    <div class="range">
        <h3 class="agileits-sear-head">Price range</h3>
        <ul class="dropdown-menu6">
            <li>
{{--                <div id="slider-range"></div>--}}
{{--                <input type="text" id="amount" style="border: 0; color: #ffffff; font-weight: normal;"/>--}}
                <div class="main__filter__price">
                    <div class="box-filter__price">
{{--                        <form action="{{ route($route, $searchParams) }}" method="GET">--}}
                            <input type="number" min="0" class="filter__price filter__price__min" placeholder="Min" value="" pattern="[0-9]*">
                            <div class="dash__gray">-</div>
                            <input type="number" min="0" class="filter__price filter__price__max" placeholder="Max" value="" pattern="[0-9]*">
                            <input type="hidden" name="price" class="filter__price-value">
                            <button type="button" class="ant-btn btn-search__by__price"
                                    data-href="{{ request()->fullUrl() }}">
                                <i class="fa fa-caret-right" aria-hidden="true"></i>
                            </button>
{{--                        </form>--}}
                    </div>
                </div>
            </li>
        </ul>
    </div>
    <div class="left-side">
        <h3 class="agileits-sear-head">Discount</h3>
        <ul>
            @foreach(DISCOUNT_FILTER as $index => $filter)
                <li>
                    <input type="checkbox" class="jsCheckBox" id="{{ $filter }}" name="{{ DISCOUNT }}"
                           value="{{ $filter }}" data-href="{{ request()->fullUrl() }}">
                    <label for="{{ $filter }}" class="label__span">{{ $filter . ' or More' }}</label>
                </li>
            @endforeach
        </ul>
    </div>
    <!-- Color Family -->
    @foreach(ATTRIBUTE_FILTER as $key => $attribute)
        @php
            $attributes = \App\Helpers\Helper::getAttributeFilter($arrayProductId, $key);
        @endphp
        @if(count($attributes))
            <div class="left-side">
                <h3 class="agileits-sear-head">{{ $attribute }}</h3>
                <ul>
                    @foreach($attributes as $index => $filter)
                        <li>
                            <input type="checkbox" class="jsCheckBox" id="{{ $filter }}" name="{{ $attribute }}"
                                   value="{{ $filter }}" data-href="{{ request()->fullUrl() }}">
                            <label for="{{ $filter }}" class="label__span">{{ $filter }}</label>
                        </li>
                    @endforeach
                </ul>
            </div>
        @endif
    @endforeach
    <div class="customer-rev left-side">
        <h3 class="agileits-sear-head">Rating</h3>
        <ul>
            <li>
                <a class="filter__rating" href="{{ route($route, array_merge(['rating' => 5], $searchParams)) }}"
                   data-rating="5">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <label>5.0</label>
                </a>
            </li>
            <li>
                <a class="filter__rating" href="{{ route($route, array_merge(['rating' => 4], $searchParams)) }}"
                   data-rating="4">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <label>4.0</label>
                </a>
            </li>
            <li>
                <a class="filter__rating" href="{{ route($route, array_merge(['rating' => 3.5], $searchParams)) }}"
                   data-rating="3.5">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <label>3.5</label>
                </a>
            </li>
            <li>
                <a class="filter__rating" href="{{ route($route, array_merge(['rating' => 3], $searchParams)) }}"
                   data-rating="3">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <label>3.0</label>
                </a>
            </li>
            <li>
                <a class="filter__rating" href="{{ route($route, array_merge(['rating' => 2.5], $searchParams)) }}"
                   data-rating="2.5">
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star" aria-hidden="true"></i>
                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <i class="fa fa-star-o" aria-hidden="true"></i>
                    <label>2.5</label>
                </a>
            </li>
        </ul>
    </div>
</div>
<!-- //product left -->
