<div class="order-{{ $order->order_code }} box-info-order">
    <div class="row order-body">
        <div class="rootBody_{{ $order->order_code }} page-root">
            @if(!empty($order->orderDetail))
                @foreach($order->orderDetail as $key => $orderDetail)
                    @php
                        $options = unserialize($orderDetail->options);
                    @endphp
                    <div class="order-detail-{{ $key }}">
                        <div class="col-sm-8">
                            <div class="order-image col-sm-2">
                                @if(isset($options['image']) && $options['image'] !== '0' && file_exists('/backend/images/uploads/product/' . $options['image']))
                                    <img src="/backend/images/uploads/product/{{ $options['image'] }}" alt="" class="image-detail">
                                @else
                                    <img src="{{ FILE_PATH_PRODUCT_THUMP }}" alt="" class="image-detail">
                                @endif
                            </div>
                            <div class="order-name col-sm-10">
                                <div class="title name">
                                    <a>{{ $options['description'] }}</a>
                                </div>
                                <div class="title info">
                                    <p class="text desc light-gray">{{ date('m', strtotime($order->created_at)) }} Months Invoice</p>
                                </div>
                                @if($options['color'])
                                    <div data-color="{{ $options['color'] }}"
                                         style="background-color: {{ $options['color'] }};"
                                         class="attribute-item size-item size"></div>
                                @endif
                                @if($options['size'])
                                    <div data-size="{{ $options['size'] }}"
                                         style="background-color: #fff;"
                                         class="attribute-item size-item size">{{ $options['size'] }}</div>
                                @endif
                                @if($options['storage'])
                                    <div data-storage="{{ $options['storage'] }}"
                                         style="background-color: #fff;"
                                         class="attribute-item size-item size">{{ $options['storage'] }}</div>
                                @endif
                                @if($options['material'])
                                    <div data-material="{{ $cart->options->material }}"
                                         style="background-color: #fff;"
                                         class="attribute-item size-item size">{{ $options['material'] }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="order-total">
                                <span class="detail-info-total-value item_price">{{ App\Helpers\Helper::loadMoney($orderDetail->amount) }}</span>
                            </div>
                        </div>
                        <div class="col-sm-2">
                            <div class="order-quantity">
                                <span class="detail-info-total-title">Qty:&nbsp;</span>
                                <span class="detail-info-total-value">{{ $orderDetail->quantity }}</span>
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</div>
