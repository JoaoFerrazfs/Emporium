<div class="freight-page-container" id="basic-table">
    <div class="card">

        <div class="card-header">
            <h3 class="card-title">Entrega</h3>
        </div>

    </div>

    <div class="container-total-value">
        <p class="label-total-value">Retirar na loja</p>
        <p class="total-value">Valor : R$ {{$_COOKIE['totalCart']}}</p>
        <a href="{{route('order.with.freight')}}" class="btn btn btn-secondary">Retirar em loja</a>
    </div>

<hr>

    <div class="card-header">
        <h3 class="card-title">Confirme o endereço abaixo em casos de pedidos para entrega</h3>
    </div>

    <div class="card-header">
        <p class="">Para pedidos de entrega será adicionado uma taxa de R$ 7 reais para o envio</p>
    </div>

    <div class="container-total-value">
        <form method="post" action="{{route('order.with.freight')}}" class="form form-vertical">
            @csrf
            <div class="row">

                <div class="form-group">
                    <label for="first-name-vertical">CEP</label>
                    <input type="text" id="zipCode" class="form-control" name="zipCode" placeholder="CEP">
                </div>

                <div class="form-group">
                    <label for="first-name-vertical">Cidade</label>
                    <input type="text" id="city" class="form-control" name="city" placeholder="Cidade">
                </div>

                <div class="form-group">
                    <label for="email-id-vertical">Rua</label>
                    <input type="text" id="street" class="form-control" name="street" placeholder="Rua">
                </div>

                <div class="form-group">
                    <label for="contact-info-vertical">Bairro</label>
                    <input type="text" id="neighborhood" class="form-control" name="contact"
                           placeholder="Bairro">
                </div>

                <div class="form-group">
                    <label for="password-vertical">Numero</label>
                    <input type="text" id="number" class="form-control" name="number"
                           placeholder="Numero">
                </div>

                <div class="form-group">
                    <label for="password-vertical">Observação</label>
                    <input type="text" id="observation" class="form-control" name="observation"
                           placeholder="Voce tem alguma observação?">
                </div>
            </div>
            <div class="btn-freight-confirm">

                <button type="submit" class="btn  me-1 mb-1"> Confirmar Entrega </button>
            </div>

        </form>
    </div>


</div>
