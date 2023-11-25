@extends('admin.layouts.main')
@section('title', 'Emporium')
@section('function_title', 'Produtos')
@section('content')

    @include('admin.components._title')
    @include('admin.components._filters_product_list')
    @include('admin.components._products_list')

@endsection
