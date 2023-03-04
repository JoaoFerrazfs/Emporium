@extends('admin.layouts.main')
@section('title', 'Emporium')
@section('function_title', 'Produtos')
@section('action_route', route('admin.products.create'))

@section('content')

    @include('admin.components._title')
    @include('admin.components._product_form')


@endsection


