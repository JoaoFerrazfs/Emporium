@extends('ecommerce.layouts.main')
@section('title', 'Emporium')
@section('content')

    <div class="div-imagem">
        <img src="/img/banner.png" class="img-fluid" alt="...">

    </div>



    <section class="product_section layout_padding">
        <div class="container">
            <div class="heading_container heading_center">
                <h2> Produtos </h2>
            </div>
            <div class="row">
                @foreach($products as $product)
                    <div class="col-sm-6 col-lg-4">
                        <div class="box">
                            <div class="img-box">
                                <img src="{{'img/products/' . $product->image }}" alt="{{ $product->name }}">
                                <a href="" class="add_cart_btn">

                <span> Adicionar ao carrinho </span>
                                </a>
                            </div>
                            <div class="detail-box">
                                <h5>{{ $product->name }} </h5>
                                <div class="product_info">
                                    <h5>
                                        <span></span> {{ $product->price }}
                                    </h5>
                                </div>
                            </div>
                        </div>
                    </div>

                @endforeach

            </div>
        </div>
    </section>
@stop
