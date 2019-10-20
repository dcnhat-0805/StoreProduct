@php
    use App\Models\ProductType;

    $user = Auth::guard('admins')->user();
@endphp
@extends('backend.layouts.app')
@section('title', 'Create product')
@section('titleMenu', 'Create product')
@section('headerBlade', 'Create')
@section('cssCustom')
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/colorpicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/datapicker/datepicker3.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/daterangepicker/daterangepicker.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/css/form/all-type-forms.css') }}"/>
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/normalize.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/demo.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ App\Helpers\Helper::asset('backend/assets/css/component.css') }}" />
@endsection
@section('content')
    @include('backend.pages.product._form', [
        'product' => $product,
        'is_page_register' => TRUE,
    ])
@endsection
