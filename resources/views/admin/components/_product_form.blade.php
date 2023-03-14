<div class="form-container">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form method="POST" action=@yield("action_route") class="form"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Nome</label>
                                        <input type="text" id="name" class="form-control" name="name" value="{{$product->name ?? null}}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Descrição</label>
                                        <input type="text" id="description" class="form-control" name="description" value="{{$product->description ?? null}}" required >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Ingredientes</label>
                                        <input type="text" id="ingredients" class="form-control" name="ingredients" value="{{$product->ingredients ?? null}}" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Estoque</label>
                                        <input type="number" id="stock" class="form-control" name="stock" value="{{$product->stock ?? null}}" required >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Validade</label>
                                        <input type="date" id="validate" class="form-control" name="validate" value="{{$product->validate ?? null}}" required >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Preço</label>
                                        <input type="text" id="price" class="form-control" name="price" value="{{$product->price ?? null}}" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Imagem</label>
                                        <input type="file" id="image" class="form-control" name="image" value="{{$product->image ?? null}}" >
                                    </div>
                                </div>

                                @if($product->image ?? false)

                                    <img class="image-product-edit" src="{{ '/img/products/'. $product->image  }}"
                                         alt="{{  $product->name  }}">

                                @endif

                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" id="status" name="status" class="form-check-input"
                                            @if(($product->status ?? false) == "disponivel" ) checked="" @endif>
                                        <label for="checkbox3">Disponível</label>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="ml-50 mt-5 ">
                        <a href="{{route('admin.products')}}" type="submit" class="btn btn-primary  me-1 mb-1">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
