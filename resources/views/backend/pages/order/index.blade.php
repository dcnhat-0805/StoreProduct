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
                            <th data-field="category_name" data-editable="true">Order Name</th>
                            <th data-field="product_category_name" data-editable="true">Order Email</th>
                            <th data-field="product_type_name" data-editable="true">Order Phone</th>
                            <th data-field="name" data-editable="true">Order total</th>
                            <th data-field="created_at" data-editable="true">Created date</th>
                            <th data-field="status" data-editable="true">Status</th>
                            <th data-field="action">Action</th>
                        </tr>
                        </thead>
                        <tbody class="list-category">
                        @if($orders)
                            @foreach($orders as $order)
                                <tr id="category-{{ $order->id }}" data-id="{{ $order->id }}">
                                    <td></td>
                                    <td class="text-center">{{ $order->id }}</td>
                                    <td class="">{{ $order->order_name }}</td>
                                    <td class="">{{ $order->order_email }}</td>
                                    <td class="">{{ $order->order_phone }}</td>
                                    <td class="">{{ App\Helpers\Helper::loadMoney($order->order_monney) }}</td>
                                    <td class="text-center">{{ $order->created_at }}</td>
                                    <td class="text-center">{{ App\Helpers\Helper::loadStatusOrder($order->order_status) }}</td>
                                    <td class="datatable-ct text-center">
                                        <button data-toggle="modal" title="Detail {{ $order->order_code }}" class="pd-setting-ed"
                                                data-original-title="Edit" data-target="#detailOrder"
                                                data-id="{{ $order->id }}"
                                                data-code="{{ $order->order_code }}"
                                                data-name="Order detail by {{ $order->order_name }}" type="button">
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
                            <form role="form" method="GET" id="formSearch" action="{{ route(ADMIN_PRODUCT_INDEX) }}">
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
                                                <input type="checkbox" class="i-checks" name="status[]" value="1" {{ App\Helpers\Helper::setCheckedForm('status', 1, 'checked') }}>
                                                <label for="status" style="margin-right: 20px;">Display</label>
                                                <input type="checkbox" class="i-checks"  name="status[]" value="0" {{ App\Helpers\Helper::setCheckedForm('status', 0, 'checked') }}>
                                                <label for="status">Not display</label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-custon-three btn-success" id="btnSearch"><i
                                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal" id="btnClear" onclick="window.location.href = '{{route(ADMIN_PRODUCT_INDEX)}}'">
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
                            <form role="form" method="GET" id="formSearch" action="{{ route(ADMIN_PRODUCT_INDEX) }}">
                                <div class="box-body sop__box-order__detail">
                                </div><!-- /.box-body -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-custon-three btn-success" id="btnSearch"><i
                                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal">
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
    <!-- delete Modal-->
    <div class="modal fade" id="delete" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                        <input type="hidden" name="id" id="productId">
                        <input type="hidden" id="urlDelete">
                        <h5 class="modal-title" id="exampleModalLabel" style="line-height: 70px; text-align: center">Do you want to delete product ?</h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success" id="btnDeleteProduct"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
                    <button class="btn btn-custon-three btn-danger" type="button" data-dismiss="modal"><i class="fa fa-times edu-danger-error" aria-hidden="true"></i> No</button>
                    <div>
                    </div>
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
