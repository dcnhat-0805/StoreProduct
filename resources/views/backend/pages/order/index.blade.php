@php
    use App\Models\Order;
    $params = $_GET;
    unset($params['sort']);
    unset($params['desc']);

    $user = Auth::guard('admins')->user();
@endphp
@extends('backend.layouts.app')
@section('title', 'List order')
@section('titleMenu', 'Order')
@section('cssCustom')
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/form/all-type-forms.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/normalize.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/demo.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/component.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/order.css') }}" />
    <!-- summernote CSS
		============================================ -->
    <link rel="stylesheet" href="{{ App\Helpers\Helper::asset('backend/css/summernote/summernote.css') }}">
@endsection
@section('content')
    <div class="sparkline13-list">
        @if ($user->can('viewOrder', Order::class))
            <div class="sparkline13-hd">
                <div class="main-sparkline13-hd">
                    <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Order</h1>
                </div>
            </div>
            <div class="sparkline13-graph">
                <div class="datatable-dashv1-list custom-datatable-overright">
                    <div id="toolbar" class="hide">
                        <!-- Button to Open the Add Modal -->
                        <button id="addProductType" class="btn btn-custon-three btn-default" type="button"
                                onclick="window.location.href = '{{ route(ADMIN_PRODUCT_ADD_INDEX) }}'"
                                title="Add new product"><i class="fa fa-plus"></i> Register
                        </button>
                        <!-- Button to Open the Delete Modal -->
                        <button id="removeProduct" class="btn btn-custon-three btn-danger"
                                data-toggle="modal" data-target="#delete" data-id="all">
                            <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Delete
                        </button>
                    </div>
                    <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-sort="true" data-show-columns="true"
                           data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true"
                           data-show-toggle="true" data-resizable="true" data-cookie="true"
                           data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                           data-toolbar="#toolbar">
                        <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-field="id">ID</th>
                            <th data-field="order_name" data-editable="true">Order Name</th>
                            <th data-field="order_email" data-editable="true">Order Email</th>
                            <th data-field="order_phone" data-editable="true">Order Phone</th>
                            <th data-field="order_total" data-editable="true">Order total</th>
                            <th data-field="created_at" data-editable="true">Created date</th>
                            <th data-field="status" data-editable="true">Status</th>
                            <th data-field="action">Action</th>
                        </tr>
                        </thead>
                        <tbody class="list-category">
                        @if($orders)
                            @foreach($orders as $order)
                                <tr id="order-{{ $order->id }}" data-id="{{ $order->id }}">
                                    <td></td>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td class="">{{ $order->user_name ? $order->user_name : $order->order_name  }}</td>
                                    <td class="">{{ $order->user_email ? $order->user_email : $order->order_email }}</td>
                                    <td class="">{{ $order->order_phone }}</td>
                                    <td class="">{{ App\Helpers\Helper::loadMoney($order->order_monney) }}</td>
                                    <td class="text-center">{{ $order->created_at }}</td>
                                    <td class="text-center"><div class="order__status {{ App\Helpers\Helper::loadClassStatusOrder($order->order_status) }}">{{ App\Helpers\Helper::loadStatusOrder($order->order_status) }}</div></td>
                                    <td class="datatable-ct text-center">
                                        <button data-toggle="modal" title="Detail {{ $order->order_code }}" class="pd-setting-ed"
                                                data-original-title="Detail" data-target="#detailOrder"
                                                data-id="{{ $order->id }}"
                                                data-code="{{ $order->order_code }}"
                                                data-name="Order detail by {{ $order->order_name }}"
                                                data-status="{{ $order->order_status }}" type="button">
                                            <i class="fa fa-eye" aria-hidden="true"></i>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                        </tbody>
                    </table>

                    <!-- Pagination -->
                    <div class="pagination-wrapper header" style="margin-top: 20px;">
                        <nav class="nav-pagination store-unit clearfix" aria-label="Page navigation">
                            <span class="info">{{ $orders->currentPage() }} / {{ $orders->lastPage() }} pages（total of {{ $orders->total() }}）</span>
                            <ul class="pull-right">
                                <li> {{ $orders->appends($_GET)->links('backend.pagination') }}</li>
                            </ul>
                        </nav>
                    </div>
                    <!--/ Pagination -->
                </div>
            </div>
        @else
            @include('backend.permission')
        @endif
    </div>
    <!-- Search Modal-->
    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Search</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="GET" id="formSearch" action="{{ route(ADMIN_ORDER_INDEX) }}">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Keyword</label>
                                                <input type="text" class="form-control" name="keyword" value="{{ request()->get('keyword') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Created at</label>
                                                <input type="text" readonly class="form-control jsDatepicker" name="created_at" value="{{ request()->get('created_at') }}" >
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <input type="checkbox" class="jsCheckBox" id="pending" name="status[]" value="{{ PENDING }}" {{ App\Helpers\Helper::setCheckedForm('status', PENDING, 'checked') }}>
                                                <label for="pending" class="label__status">Pending</label>
                                                <input type="checkbox" class="jsCheckBox" id="delivery" name="status[]" value="{{ DELIVERY }}" {{ App\Helpers\Helper::setCheckedForm('status', DELIVERY, 'checked') }}>
                                                <label for="delivery" class="label__status">Delivery</label>
                                                <input type="checkbox" class="jsCheckBox" id="finish" name="status[]" value="{{ FINISH }}" {{ App\Helpers\Helper::setCheckedForm('status', FINISH, 'checked') }}>
                                                <label for="finish" class="label__status">Finish</label>
                                                <input type="checkbox" class="jsCheckBox" id="cancel" name="status[]" value="{{ CANCEL }}" {{ App\Helpers\Helper::setCheckedForm('status', CANCEL, 'checked') }}>
                                                <label for="cancel" class="label__status">Cancel</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-custon-three btn-success" id="btnSearch">
                                        <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal" id="btnClear" onclick="window.location.href = '{{route(ADMIN_ORDER_INDEX)}}'">
                                        <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Search Modal-->
    <div class="modal fade" id="detailOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal__order__title" style="text-transform: capitalize;">
                        <div class="detail-info" data-spm-anchor-id="">
                            <div class="pull-left detail-info-left">
                                <div>
                                    <p class="order-number"><span class="order__name"></span>&nbsp;<span class="order-code order__code"></span></p>
                                    <p class="text desc light-gray order__time"></p>
                                </div>
                            </div>
                        </div>
                    </h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <div class="box-body sop__box-order__detail">
                            </div><!-- /.box-body -->
                            <div class="modal-footer">
                                <button type="button" class="btn btn-custon-three btn-success btn__delivery" data-toggle="modal" data-target="#deliveryOrder">
                                    <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> <span class="txt__button">Apply</span>
                                </button>
                                <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal">
                                    <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Delivery Modal-->
    <div class="modal fade" id="deliveryOrder" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Confirmation</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form style="min-height: 70px;">
                        <input type="hidden" name="id" id="order__id">
                        <h5 class="modal-title text__confirm" id="exampleModalLabel" style="line-height: 70px; text-align: center">Do you want to delivery ?</h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success" id="btnDeliveryOrder"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
                    <button class="btn btn-custon-three btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times edu-danger-error" aria-hidden="true"></i> No</button>
                    <div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('jsCustom')
    <!-- summernote JS
		============================================ -->
    <script src="{{ App\Helpers\Helper::asset('backend/js/summernote/summernote.min.js') }}"></script>
    <script src="{{ App\Helpers\Helper::asset('backend/js/summernote/summernote-active.js') }}"></script>
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/order.js') }}"></script>
@endsection
