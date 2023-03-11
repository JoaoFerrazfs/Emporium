@extends('ecommerce.layouts.main')
@section('title', 'Emporium')
@section('content')

    <div class="container-login">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card-body">
                <div class="text-center mb-5">
                    <img src="/images/favicon.png" height="48" class="mb-4">
                    <h3>Esqueceu a senha</h3>
                    <p> Para seguir com o processo de reset de senha ensira seu email abaixo.</p>
                </div>
                <form action="{{ route('password.email') }}" >
                    <div class="form-group mb-4">
                        <label for="first-name-column">Email</label>
                        <input type="email" id="email" class="form-control" name="email">
                    </div>

                    <div class="clearfix">
                        <button class="btn btn-primary float-end">Enviar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection




