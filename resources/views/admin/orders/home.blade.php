@extends('admin.layouts.main')
@section('title', 'Emporium')
@section('function_title', 'Pedidos')

@section('products',  'active' )

@section('content')
    @include('admin.components._title')
    @include('admin.components._orders_list')
@endsection
