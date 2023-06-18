<div class="table-container">
    <div class="card">
        <div class="accordion" id="accordionExample">
            <div class="accordion-item">

                <h2 class="accordion-header">
                    <button class="accordion-button" type="button" data-bs-toggle="collapse"
                            data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            <strong>  Dados do Cliente: </strong> {{$order->user->name}}
                    </button>
                </h2>

                <div id="collapseOne" class="accordion-collapse collapse show " data-bs-parent="#accordionExample">

                    <div class="accordion-body row">
                        <div class="col-3">
                            <strong> Cidade:</strong> {{$order->city}}
                        </div>
                        <div class="col-3">
                            <strong>Bairro: </strong> {{$order->neighborhood}}
                        </div>
                        <div class="col-3">
                            <strong>Rua: </strong> {{$order->street}}
                        </div>
                        <div class="col-3">
                            <strong>Nº: </strong> {{$order->number}}
                        </div>
                        <div class="col-6 mt-4">
                            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Detalhes do cliente</button>
                        </div>
                        <div class="col-6 mt-4">
                            <strong>Status do pedido:</strong> {{$order->status}}
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="table-responsive">
            <table class="table mb-0">
                <thead class="thead-dark">
                <tr>
                    <th scope="col">Cod.Produto</th>
                    <th scope="col">Nome</th>
                    <th scope="col">Valor</th>
                    <th scope="col">Ações</th>
                </tr>
                </thead>
                <tbody>
                @foreach(json_decode($order->cart->products) as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->name}}</td>
                        <td>R$ {{$product->price}}</td>
                        <td>
                            <a href="{{route('admin.products.edit', ['id' => $product->id])}}" class="btn btn-info card-content-btn">Detalhes do Produto</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div class="ml-50 mt-5">
            <a href="{{route('admin.products')}}" type="submit" class="btn btn-primary me-1 mb-1">Voltar</a>
        </div>
    </div>

    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Dados do cliente</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group">
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Nome</div>
                                {{ $order->user->name }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Email</div>
                                {{ $order->user->email }}
                            </div>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-start">
                            <div class="ms-2 me-auto">
                                <div class="fw-bold">Telefone</div>
                                {{ $order->user->phone }}
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

</div>
