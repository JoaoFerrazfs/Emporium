<div class="table-container">
    <div class="card">
            <div class="table-responsive">
                <table class="table mb-0">
                    <thead class="thead-dark">
                    <tr>
                        <th scope="col">Nº Pedido</th>
                        <th scope="col">Cliente</th>
                        <th scope="col">Valor</th>
                        <th scope="col">Data do Pedido</th>
                        <th scope="col">Status</th>
                        <th scope="col">Ações</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach ($orders as $order )
                        <tr>
                            <td>{{$order->id}}</td>
                            <td>{{$order->user->name}}</td>
                            <td>R$ {{$order->cart->total}}</td>
                            <td>{{date_create($order->created_at)->format('d/m/Y')}}</td>
                            <td>{{$order->status}}</td>
                            <td>
                                <a href= "{{route('admin.show.order',['id' => $order->id ])}}"
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
