@php
    $total = 0;
@endphp

<div class="cart-page-container" id="basic-table">
    <div class="card">

        <div class="card-header">
            <h4 class="card-title">Confirmar pedido</h4>
        </div>

        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        <div class="card-header">
                            <h4 class="card-title">Produtos</h4>
                        </div>
                        <tr>
                            <th class="text-bold-500">Codigo</th>
                            <th class="text-bold-500">Nome</th>
                            <th class="text-bold-500">Quantidade</th>
                            <th class="text-bold-500">Preço</th>

                        </tr>
                        @foreach($preparedOrder['completeCartItems'] as $key => $item)
                            <tr>
                                <td class="text-bold-500">{{ $item['id'] }}</td>
                                <td class="text-bold-500">{{ $item['name'] }}</td>
                                <td class="text-bold-500">{{ $item['quantity'] }}</td>
                                <td class="text-bold-500"> R$ {{ $item['price'] * $item['quantity']  }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>

                    @if (!$preparedOrder['pickUpInStore'])
                    <hr>
                    <table class="table">
                        <tbody>
                        <div class="card-header">
                            <h4 class="card-title">Endereço</h4>
                        </div>
                        <tr>
                            <th class="text-bold-500">CEP</th>
                            <th class="text-bold-500">Cidade</th>
                            <th class="text-bold-500">Bairro</th>
                            <th class="text-bold-500">Rua</th>
                            <th class="text-bold-500">Numero</th>

                        </tr>
                        @foreach($preparedOrder['completeCartItems'] as $key => $item)
                            <tr>
                                <td class="text-bold-500">{{ $preparedOrder['zipCode'] }}</td>
                                <td class="text-bold-500">{{ $preparedOrder['city'] }}</td>
                                <td class="text-bold-500">{{ $preparedOrder['neighborhood'] }}</td>
                                <td class="text-bold-500">{{ $preparedOrder['street'] }}</td>
                                <td class="text-bold-500">{{ $preparedOrder['number'] }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    @else
                            <div class="alert alert-Order-confirmation">
                                <h4 class="alert-heading">Retirada em loja</h4>
                                <p>Os pedidos podem ser retirados em até 2hrs após a confirmação do pagamento</p>
                            </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-light" role="alert">
        <h4 class="alert-heading">Valor total:</h4>
        <p class="total-value"> R$ {{$preparedOrder['total']}}</p>
        <hr>
        <a href="{{ route('process.order')}}" id="orderConfirmation" class="btn btn btn-secondary">Realizar pagamento</a>

    </div>

    <a href="{{ route('freight')}}" class="btn btn btn-secondary">Voltar</a>

</div>
