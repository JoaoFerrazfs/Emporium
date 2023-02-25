@extends('admin.layouts.main')
@section('title', 'Emporium')
@section('content')

@include('admin.components._sidebar')
@section('function_title', 'Produtos');
@include('admin.components._title')
@section('first_botton', 'Listar Produtos');
@section('second_botton', 'Cadastrar');
@include('admin.components._home_bottons')





@endsection
