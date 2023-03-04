@extends('admin.layouts.main')
@section('title', 'Emporium')
@section('function_title', 'Produtos')
@section('action_route', route('admin.products.update',["id" =>$product->id]))

@section('content')

    @include('admin.components._title')
    @include('admin.components._product_form')

@endsection


