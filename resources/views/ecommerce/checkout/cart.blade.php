@extends('ecommerce.layouts.main')
@section('title', 'Emporium')

@section('content')
    @include('ecommerce.components._formCart')
@endsection

@section('script')
    @include('ecommerce.components._formCartScript')
@endsection



