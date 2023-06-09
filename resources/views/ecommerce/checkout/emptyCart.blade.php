@extends('ecommerce.layouts.main')
@section('title', 'Emporium')

@section('content')
    <div class="cart-page-container">
        <div class="card">
            <div class="card-header">
                <h2 class="card-title">Seu carrinho ainda está vazio</h2>
            </div>
            <div class="card-body">
                <div class="image-container">
                    <div class="image-wrapper">
                        <img src="/img/commons/emptyCart2.webp" alt="Card image cap" class="img-fluid">
                    </div>
                    <div class="image-wrapper hidden-on-mobile">
                        <img src="/img/commons/emptyCart.webp" alt="Card image cap" class="img-fluid">
                    </div>
                    <div class="image-wrapper hidden-on-mobile">
                        <img src="/img/commons/emptyCart3.webp" alt="Card image cap" class="img-fluid">
                    </div>
                </div>
                <h4 class="mt-5 hidden-on-mobile">
                    Não há nada melhor do que uma guloseima fresquinha e deliciosa para satisfazer seu paladar, não
                    deixe de experimentar nossas opções!
                </h4>

                <div class="text-center mt-5">
                    <a type="button" href="{{route('home')}}" class="btn btn-outline-primary">
                        Voltar para página de produtos
                    </a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')
@endsection



