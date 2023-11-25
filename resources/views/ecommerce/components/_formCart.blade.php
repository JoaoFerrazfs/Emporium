@php
    $total = 0;
@endphp

<div class="cart-page-container" id="basic-table">
    <div class="card">

        <div class="card-header">
            <h4 class="card-title">Carrinho</h4>
        </div>

        <div class="card-content">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table">
                        <tbody>
                        @foreach($cart as $key => $item)
                            <tr>
                                <td class="text-bold-500"><img style="width: 100px"
                                                               src="{{ "/img/products/" . $item['image'] }}"></td>
                                <td class="text-bold-500">{{ $item['name'] }}</td>
                                <td> R$ {{ $item['price'] }}</td>
                                <td class="text-bold-500">
                                    <button id="delete-button-{{$item['id']}}" href="#" class="btn btn-danger"
                                            data-product-id={{$item['id']}}>Retirar
                                    </button>
                                </td>
                            </tr>
                        @endforeach

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="alert alert-light" role="alert">
        <h4 class="alert-heading">Valor total:</h4>
        <p class="total-value">R$ @php echo array_sum(array_column($cart, 'price')); @endphp</p>
        <hr>
        <a href="{{ route('freight')}}" class="btn btn btn-secondary">Continuar compra</a>

    </div>

    <a href="{{ route('home')}}" class="btn btn btn-secondary">Voltar</a>

</div>
