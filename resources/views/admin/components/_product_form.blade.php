<div class="form-container">
    <div class="col-md-6 col-12">
        <div class="card">
            <div class="card-content">
                <div class="card-body">
                    <form method="POST" action="{{route('admin.products.create')}}" class="form"  enctype="multipart/form-data">
                        @csrf
                        <div class="form-body">
                            <div class="row">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="first-name-vertical">Nome</label>
                                        <input type="text" id="name" class="form-control" name="name" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Descrição</label>
                                        <input type="text" id="description" class="form-control" name="description" required >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Ingredientes</label>
                                        <input type="text" id="ingredients" class="form-control" name="ingredients" required>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Estoque</label>
                                        <input type="number" id="stock" class="form-control" name="stock" required >
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Validade</label>
                                        <input type="date" id="validate" class="form-control" name="validate" required >
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Preço</label>
                                        <input type="text" id="price" class="form-control" name="price" required>
                                    </div>
                                </div>

                                <div class="col-12">
                                    <div class="form-group">
                                        <label for="email-id-vertical">Imagem</label>
                                        <input type="file" id="image" class="form-control" name="image" required >
                                    </div>
                                </div>

                                <div class="form-check">
                                    <div class="checkbox">
                                        <input type="checkbox" id="status" name="status" class="form-check-input" value="disponivel" checked="">
                                        <label for="checkbox3">Disponível</label>
                                    </div>
                                </div>

                                <div class="col-12 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary me-1 mb-1">Salvar</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        </div>
        <div class="col-12 d-flex justify-content-start">
            <button type="submit" class="btn btn-primary me-1 mb-1">Voltar</button>
        </div>
    </div>

</div>
