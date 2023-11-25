<div class="container mt-4">
    <div class="row">
        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <img src="{{'/img/products/'. $product->image}}" class="card-img-top img-fluid" alt="singleminded">
                </div>
            </div>

            <div class="card mt-4">
                <div class="card-body d-flex justify-content-between">
                    <div>
                        <h2 class="unit-product">Un</h2>
                    </div>
                    <div>
                        <h2 class="price-product"> R$ {{ $product->price }} </h2>
                    </div>
                </div>
            </div>

        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-body">
                    <p class="card-text"> Código do produto: {{ $product->id }}</p>
                    <h2 class="card-title">{{$product->name}}</h2>
                    <p class="card-text">{{ $product->description }}</p>
                    <h2 class="card-title">Ingredientes</h2>
                    <p class="card-text">{{ $product->ingredients}}</p>
                </div>
            </div>
        </div>

        <div class="card mt-4">
            <div class="card-body">
                <div class="buttons">
                    <a id="addToCart" href="{{route('cart')}}" class="btn btn-secondary btn-lg btn-add-to-cart">Adicionar ao carrinho</a>
                    <a id="buy" href="{{route('freight')}}" class="btn btn-secondary btn-lg btn-buy">Comprar</a>
                </div>
            </div>

            <div class="d-flex justify-content-start mb-2">
                <a href="{{route('products.list')}}" class="btn btn-secondary text-truncate text-sm">Voltar</a>
            </div>
        </div>

    </div>


    </div>
