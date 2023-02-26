@extends('admin.layouts.main')
@section('title', 'Emporium')
@section('function_title', 'Produtos')

@section('first_botton', 'Listar Produtos')
@section('first_botton_link',  route('admin.products.list') )

@section('second_botton', 'Cadastrar')
@section('second_botton_link',  route('admin.products.create') )

@section('content')

    @include('admin.components._title')
    @include('admin.components._home_bottons')

@endsection
