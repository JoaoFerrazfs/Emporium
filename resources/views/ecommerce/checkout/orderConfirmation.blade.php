@extends('ecommerce.layouts.main')
@section('title', 'Emporium')

@section('content')
    @include('ecommerce.components._formOrder')
@endsection

@section('script')
    @include('ecommerce.components._formOrderScript')
@endsection

