@extends('backend.layouts.app')
@section('title', 'List category')
@section('titleMenu', 'Category')
@section('content')
    <div class="sparkline13-list">
        <div class="sparkline13-hd">
            <div class="main-sparkline13-hd">
                <h1 style="text-transform: capitalize;">List <span class="table-project-n">Of</span> Category</h1>
            </div>
        </div>
        <div class="sparkline13-graph">
            <div class="datatable-dashv1-list custom-datatable-overright">
                <div id="toolbar">
                    <!-- Button to Open the Add Modal -->
                    <button class="btn btn-default" data-toggle="modal" data-target="#add" type="button"
                            title="Add new category"><i class="fa fa-plus"></i></button>
                    <select class="form-control dt-tb hidden">
                        <option value="">Export Basic</option>
                        <option value="all">Export All</option>
                        <option value="selected">Export Selected</option>
                    </select>
                </div>
                <table id="table" data-toggle="table" data-pagination="true" data-search="true" data-show-columns="true"
                       data-show-pagination-switch="true" data-show-refresh="true" data-key-events="true"
                       data-show-toggle="true" data-resizable="true" data-cookie="true"
                       data-cookie-id-table="saveId" data-show-export="true" data-click-to-select="true"
                       data-toolbar="#toolbar">
                    <thead>
                    <tr>
                        <th data-field="state" data-checkbox="true"></th>
                        <th data-field="id">ID</th>
                        <th data-field="name" data-editable="true">Name</th>
                        <th data-field="email" data-editable="true">Order</th>
                        <th data-field="phone" data-editable="true">Status</th>
                        <th data-field="action">Action</th>
                    </tr>
                    </thead>
                    <tbody class="list-category">
                    @if($category)
                        @foreach($category as $category)
                            <tr id="category-{{$category->id}}">
                                <td></td>
                                <td>{{$category->id}}</td>
                                <td>{{$category->category_name}}</td>
                                <td>{{$category->category_order}}</td>
                                <td>@if($category->category_status == 1) Display @else Not display @endif</td>
                                <td class="datatable-ct">
                                    <button data-toggle="modal" title="Edit {{$category->category_name}}" class="pd-setting-ed"
                                            data-original-title="Edit" data-target="#edit"
                                            data-id="{{$category->id}}" data-name="{{$category->category_name}}"
                                            data-order="{{$category->category_order}}" data-status="{{$category->category_status}}"
                                            data-url="{{route(ADMIN_CATEGORY_EDIT, ['id' => $category->id])}}"
                                            type="button">
                                        <i class="fa fa-pencil-square-o" aria-hidden="true"></i></button>
                                    <button data-toggle="modal" title="Delete {{$category->category_name}}" class="pd-setting-ed"
                                            data-id="{{$category->id}}" data-url="{{route(ADMIN_CATEGORY_DELETE, ['id' => $category->id])}}"
                                            data-original-title="Trash" data-target="#delete" type="button"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Add Modal-->
    <div class="modal fade" id="add" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Add Category</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="createCategory">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="required after">Category Name</label>
                                            <input type="text" class="form-control category-name" name="category_name"
                                                   placeholder="Category Name ....">
                                            <div class="error error-category-name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="order" class="required after">Order</label>
                                            <input type="number" class="form-control category-order"
                                                   name="category_order" min="0"
                                                   placeholder="Category Order ....">
                                            <div class="error error-category-order hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <select class="form-control caategory-status" name="category_status">
                                                <option value="1" class="display">Display</option>
                                                <option value="0" class="not-display">Not Display</option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custon-three btn-success add-category" id="btnAddCategory"><i
                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Add
                    </button>
                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal"><i
                            class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                    </button>
                </div>
            </div>
        </div>
    </div>
    <!-- Add Modal-->
    <div class="modal fade" id="edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document" style="min-width: 700px;">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel" style="text-transform: capitalize;">Edit Category
                        &raquo; <span class="title"></span></h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="row" style="margin: 5px">
                        <div class="col-lg-12">
                            <form role="form" method="post" id="editCategory">
                                <div class="box-body">
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name">ID</label>
                                            <input type="text" class="form-control" name="id" readonly="readonly" disabled>
                                            <input type="hidden" class="form-control" id="url_edit">
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="name" class="required after">Category Name</label>
                                            <input type="text" class="form-control category-name" name="category_name"
                                                   placeholder="Category Name ....">
                                            <div class="error error-category-name hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="order" class="required after">Order</label>
                                            <input type="number" class="form-control category-order"
                                                   name="category_order"
                                                   placeholder="Category Order ...." min="0" value="0">
                                            <div class="error error-category-order hidden"></div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="form-group">
                                            <label for="status" class="required after">Status</label>
                                            <select class="form-control category-status" name="category_status">
                                                <option value="1" class="display">Display</option>
                                                <option value="0" class="not-display">Not Display</option>
                                            </select>
                                        </div>
                                    </div>
                                </div><!-- /.box-body -->
                            </form>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-custon-three btn-success" id="btnUpdateCategory"><i
                            class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Update
                    </button>
                    <button type="button" class="btn btn-custon-three btn-danger" data-dismiss="modal"><i
                            class="fa fa-times edu-danger-error" aria-hidden="true"></i> Cancel
                    </button>
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
                        <input type="hidden" name="id" id="categoryId">
                        <input type="hidden" id="urlDelete">
                        <h5 class="modal-title" id="exampleModalLabel" style="line-height: 70px; text-align: center">Do you want to delete category?</h5>
                    </form>
                </div>
                <div class="modal-footer modal-delete">
                    <button type="button" class="btn btn-custon-three btn-success" id="btnDeleteCategory"><i class="fa fa-check edu-checked-pro" aria-hidden="true"></i> Yes</button>
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
    <script src="{{ \App\Helpers\Helper::asset('backend/js/category.js') }}"></script>
@endsection
