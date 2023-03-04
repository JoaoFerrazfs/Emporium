    <div class="table-container">
        <div class="card">
            <div class="card-content card-body ">
                <div class="table-responsive">
                    <table class="table mb-0">
                        <thead class="thead-dark">
                        <tr>
                            <th scope="col">Cod. Produto</th>
                            <th scope="col">Nome</th>
                            <th scope="col">Estoque</th>
                            <th scope="col">Valor</th>
                            <th scope="col">Status</th>
                            <th scope="col">Ação</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($products as $product )
                            <tr>
                                <td>{{$product->id}}</td>
                                <td>{{$product->name}}</td>
                                <td>{{$product->stock}}</td>
                                <td>{{$product->price}}</td>
                                <td>{{$product->status}}</td>
                                <td>
                                    <a href="editarProdutos/{{$product->id}}"
                                       class="btn btn-outline-light">Visualizar
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
