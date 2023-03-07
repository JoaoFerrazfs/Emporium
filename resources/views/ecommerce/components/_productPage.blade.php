<div class="product-page-container">
    <div class="product-page-image">
        <div class="card">
            <div class="card-content">
                <img src="{{'/img/products/'. $product->image}}" class="card-img-top img-fluid" alt="singleminded">
            </div>
        </div>
        <div class="price-product-container">
            <h2 class="unit-product">unidade</h2>
            <h2 class="price-product"> R$ {{ $product->price }} </h2>
        </div>
    </div>
    <div class="product-page-description ">
        <div class="card ">
            <div class="card-content product-page-description-card">
                <div class="card-body">
                    <p class="card-text">
                        Código do produto: {{ $product->id }}
                    </p>
                    <h2 class="card-title">{{$product->name}}</h2>
                    <p class="card-text">
                        {{ $product->description }}
                    </p>

                    <h2 class="card-title">Ingredientes</h2>
                    <p class="card-text">
                        {{ $product->ingredientes ?? "alguma coisa" }}
                    </p>
                </div>
            </div>
        </div>

        <div class="card product-page-botton-container">
            <div class="card-content">
                <div class="card-body">
                    <div class="buttons">
                        <a id="addToCart" href="{{route('cart')}}" class="btn btn-secondary btn-add-to-cart">Adicionar ao carrinho</a>

                        <a id="buy" href="#" class="btn btn-secondary btn-buy">Comprar</a>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <div class="buttons">
        <a href="{{route('products.list')}}" class="btn btn-secondary">Voltar</a>
    </div>
</div>
