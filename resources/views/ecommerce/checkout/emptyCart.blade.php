@extends('ecommerce.layouts.main')
@section('title', 'Emporium')

@section('content')
    <div class="cart-page-container">
        <div class="card">

            <div class="card-header">
                <h4 class="card-title">Seu carrinho ainda esta vazio</h4>
            </div>

            <div class="card-body">
                <div class="cart-page-container-img">
                    <img src="/img/commons/emptyCart2.webp" alt="Card image cap">
                    <img src="/img/commons/emptyCart.webp" alt="Card image cap">
                    <img src="/img/commons/emptyCart3.webp" alt="Card image cap">
                </div>

                <h4>
                    Não há nada melhor do que uma guloseima fresquinha e deliciosa para satisfazer seu paladar, não
                    deixe de experimentar nossas opções!
                </h4>

            </div>
            <a type="button" href="{{route('home')}}" class="btn btn-outline-primary">
                Voltar para pagina de produtos
            </a>
        </div>
    </div>
@endsection

@section('script')
@endsection



