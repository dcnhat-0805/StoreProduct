@php
    use App\Models\Comment;
    $params = $_GET;
    unset($params['sort']);
    unset($params['desc']);

    $user = Auth::guard('admins')->user();
@endphp
@extends('backend.layouts.app')
@section('title', 'List contact')
@section('titleMenu', 'Order')
@section('cssCustom')
    <link rel="stylesheet" type="text/css"
          href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
    <link rel="stylesheet" type="text/css"
          href="{{ App\Helpers\Helper::asset('backend/css/form/all-type-forms.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/normalize.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/demo.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/component.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/comment.css') }}" />
    <!-- summernote CSS
		============================================ -->
    <link rel="stylesheet" href="{{ App\Helpers\Helper::asset('backend/css/summernote/summernote.css') }}">
@endsection
@section('content')
    <div class="sparkline13-list">
        @if ($user->can('viewComment', Comment::class))
            <div class="sparkline13-hd">
                <div class="main-sparkline13-hd">
                    <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Contact</h1>
                </div>
            </div>
            <div class="sparkline13-graph">
                <div class="datatable-dashv1-list custom-datatable-overright">
                    <div id="toolbar" class="hide">
                        <!-- Button to Open the Add Modal -->
                        <button id="addProductType" class="btn btn-custon-three btn-default" type="button"
                                onclick="return false;"
                                title="Add new product"><i class="fa fa-plus"></i> Register
                        </button>
                        <!-- Button to Open the Delete Modal -->
                        <button id="removeProduct" class="btn btn-custon-three btn-danger"
                                data-toggle="modal" data-target="#delete" data-id="all">
                            <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Delete
                        </button>
                    </div>
                    <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-sort="true"
                           data-show-columns="true"
                           data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true"
                           data-show-toggle="true" data-resizable="true" data-cookie="true"
                           data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                           data-toolbar="#toolbar">
                        <thead>
                        <tr>
                            <th data-field="state" data-checkbox="true"></th>
                            <th data-field="id" class="hide">ID</th>
                            <th data-field="user_name" data-editable="true">User Name</th>
                            <th data-field="user_email" data-editable="true">User Email</th>
                            <th data-field="user_phone" data-editable="true">User Phone</th>
                            <th data-field="action">Action</th>
                        </tr>
                        </thead>
                        <tbody class="list-category">
                        @if($contacts)
                            @foreach($contacts as $contact)
                                @php
                                    $user = App\Models\User::showUser($contact->user_id);
                                @endphp
                                <tr id="contact-{{ $contact->user_id }}" data-id="{{ $contact->user_id }}">
                                    <td></td>
                                    <td class="text-center hide">{{ $contact->user_id }}</td>
                                    <td class="">{{ $contact->name }}</td>
                                    <td class="">{{ $contact->email }}</td>
                                    <td class="">{{ $contact->phone }}</td>
                                    <td class="datatable-ct text-center">
                                        <button data-toggle="modal" title="Reply {{ $contact->name }}"
                                                class="pd-setting-ed"
                                                data-original-title="Edit" data-target="#replyContact"
                                                data-user_id="{{ $contact->user_id }}" type="button">
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
                            <span class="info">{{ $contacts->currentPage() }} / {{ $contacts->lastPage() }} pages（total of {{ count($contacts) }}）</span>
                            <ul class="pull-right">
                                <li> {{ $contacts->appends($_GET)->links('backend.pagination') }}</li>
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
    <div class="modal fade" id="search" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
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
                            <form role="form" method="GET" id="formSearch" action="{{ route(ADMIN_CONTACT_INDEX) }}">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label for="name">Keyword</label>
                                                <input type="text" class="form-control" name="keyword"
                                                       value="{{ request()->get('keyword') }}">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label for="name">Created at</label>
                                                <input type="text" readonly class="form-control jsDatepicker"
                                                       name="created_at" value="{{ request()->get('created_at') }}">
                                            </div>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-custon-three btn-success"
                                            id="btnSearch">
                                        <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Search
                                    </button>
                                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal"
                                            id="btnClear"
                                            onclick="window.location.href = '{{route(ADMIN_CONTACT_INDEX)}}'">
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
    <div class="modal fade" id="replyContact" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
         aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modal__comment__title" style="text-transform: capitalize;">Reply comment
                        <span class="title__name"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row sop__box-comment" style="margin: 5px">
                        <!-- comment -->
                    </div>
                </div>
                <div class="modal-footer">
                    <form action="" class="form__rep__contact">
                        <div class="col-sm-9">
                            <div class="chat__message clearfix">
                                <input type="hidden" class="user__id" name="user_id">
                                <textarea name="message" class="contact__reply" placeholder="Type your message" rows="3"></textarea>
                                <div class="error error__contact_reply">Please enter reply contact.</div>
                            </div>
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="btn btn-custon-three btn-success btn__reply-contact">
                                <i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Reply
                            </button>
                            <button type="button" class="btn btn-custon-three btn-danger btn__cancel__contact" data-dismiss="modal">
                                <i class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                            </button>
                        </div>
                    </form>
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
    <script src="{{ App\Helpers\Helper::asset('backend/js/backend/contact.js') }}"></script>
@endsection
