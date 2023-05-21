<div class="form-container">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">

                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    @if($product->id ?? false)
                        <p>Código: {{$product->id}} </p>
                    @endif
                    <form method="POST" action="@yield('action_route')" class="form"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Nome</label>
                                        <input type="text" id="name" class="form-control" name="name" value="{{ old('name', $product->name ?? null) }}" >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Descrição</label>
                                        <input type="text" id="description" class="form-control" name="description" value="{{ old('description', $product->description ?? null) }}"  >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Ingredientes</label>
                                        <input type="text" id="ingredients" class="form-control" name="ingredients" value="{{ old('ingredients', $product->ingredients ?? null) }}" >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Estoque</label>
                                        <input type="number" id="stock" class="form-control" name="stock" value="{{ old('stock', $product->stock ?? null) }}"  >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Validade</label>
                                        <input type="date" id="validate" class="form-control" name="validate" value="{{ old('validate', $product->validate ?? null) }}"  >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Preço</label>
                                        <input type="text" name="price" class="form-control" id="price" onKeyUp="coinMask(this, event)"  value="{{ old('price', $product->price ?? null) }}"  >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Imagem</label>
                                        <input type="file" id="image" class="form-control" name="image" value="{{ old('image', $product->image ?? null) }}" >
                                    </div>
                                </div>

                                @if($product->id ?? false)
                                    <input type="hidden" name="id" id="id" value={{$product->id}}  >
                                @endif

                                @if($product->image ?? false)
                                    <img class="image-product-edit" src="{{ '/img/products/'. $product->image }}" alt="{{ $product->name }}">
                                @endif

                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" id="status" name="status" class="form-check-input" @if(($product->status ?? false) == "disponivel" ) checked="" @endif>
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
                        <a href="{{ route('admin.products') }}" type="submit" class="btn btn-primary me-1 mb-1">Voltar</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        String.prototype.reverse = function(){
            return this.split('').reverse().join('');
        };

        function coinMask(campo,evento){
            var tecla = (!evento) ? window.event.keyCode : evento.which;
            var valor  =  campo.value.replace(/[^\d]+/gi,'').reverse();
            var resultado  = "";
            var mascara = "################.##".reverse();
            for (var x=0, y=0; x<mascara.length && y<valor.length;) {
                if (mascara.charAt(x) != '#') {
                    resultado += mascara.charAt(x);
                    x++;
                } else {
                    resultado += valor.charAt(y);
                    y++;
                    x++;
                }
            }
            campo.value = resultado.reverse();
        }
    </script>

</div>
