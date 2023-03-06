@extends('ecommerce.layouts.main')
@section('title', 'Emporium')
@section('content')
    @include('ecommerce.components._imageBanner')
    @include('ecommerce.components._productsList')
    @include ("ecommerce.layouts.footer")

@endsection
