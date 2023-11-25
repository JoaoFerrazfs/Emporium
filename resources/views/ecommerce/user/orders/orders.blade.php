@extends('ecommerce.layouts.main')
@section('title', 'Emporium')
@section('content')
    <div class="d-flex align-items-center justify-content-center order-page-container">
        <div class="row mt-5 mb-5">
            <div class="col-12">
                <h2 class="text-center">Meus pedidos <span class="badge bg-secondary">{{$orders->count()}}</span></h2>
            </div>
            <hr>
            @foreach($orders as $key => $order)
                <div class="col-md-6 col-lg-4 mt-3">
                    <div class="card shadow first-card">
                        <div class="card-body">
                            <h5 class="card-title">Pedido: {{$order->id}}</h5>
                            <p class="card-text"><strong>Status:</strong> {{ $order->status }}</p>
                            <p class="card-text"><strong>Data da compra:</strong> {{$order->created_at->format('d-m-Y')}}</p>
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal{{$order->id}}">
                                Visualizar produto
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Modal -->
                <div class="modal fade" id="exampleModal{{ $order->id }}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-dialog-sm ">
                        <div class="modal-content ">
                            <div class="modal-header">
                                <h1 class="modal-title fs-5" id="exampleModalLabel">Produtos no pedido</h1>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                @foreach(json_decode($order->cart->products) as $product)
                                    <div class="fw-bold">{{$product->name}}</div>
                                    <div class="row mt-2">
                                        <div class="col-md-12">
                                            <table class="table table-bordered text-center table-sm">
                                                <thead>
                                                <tr>
                                                    <th scope="col">Preço</th>
                                                    <th scope="col">Quant</th>
                                                    <th scope="col">Ações</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                <tr>
                                                    <td>R$ {{ $product->price }}</td>
                                                    <td>{{ $product->quantity }}</td>
                                                    <td><a class="btn btn-secondary btn-sm" href="{{ route('product.page',['id' => $product->id]) }}">Visualizar Produto</td>
                                                </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                    </div>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            <div class="text-start">
                <a href="{{ route('home')}}" class="btn btn-secondary">Voltar</a>
            </div>
        </div>
    </div>
@endsection
