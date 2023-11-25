@extends('ecommerce.layouts.main')
@section('title', 'Emporium')
@section('content')
 @include('ecommerce.components._productPage')
@endsection
@section('script')
    @include("ecommerce.components._productPageScript")
@endsection










