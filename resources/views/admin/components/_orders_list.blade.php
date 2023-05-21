<div class="table-container">
    <div class="card">
        <div class="card-content card-body ">
            <div class="container-order-header">
                <p>{{ $order->user->name }}</p>
                <p class="mx-5">Data do Pedido {{ $order->created_at   }}</p>
                <p class="mx-5">Valor tota R$ {{ $order->cart->total  }}</p>
            </div>
            <hr>

            <div class="container-order-header">
                <p>Entrega:</p>
                @if($order->pickUpInStore)
                    <p class="mx-5">Retirada em loja</p>
                @else
                    <p class="mx-5">{{$order->getFullAddress()}}</p>

                @endif
            </div>

            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Cod. Produto</th>
                        <th scope="col">Nome</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach (json_decode($order->cart->products) as $product )
                        <tr>
                            <td>{{$product->id}}</td>
                            <td>{{$product->name}}</td>
                            <td>{{$product->price}}</td>
                            <td>
                                <a href="editarProdutos/{{$product->id}}"
                                   class="btn btn-info card-content-btn ">Detalhes
                                </a>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="ml-50 mt-5 ">
                <a href="{{route('admin.products')}}" type="submit" class="btn btn-primary  me-1 mb-1">Voltar</a>
            </div>
        </div>
    </div>
</div>
