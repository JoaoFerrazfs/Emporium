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
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="first-name-column">Email</label>
                        <input type="email" id="email" class="form-control" name="email">
                    </div>

                    <div class="clearfix">
                        <button type="submit" class="btn btn-primary float-end">Enviar</button>
                    </div>
                </form>

                @if(session('status'))
                    <div class="text-center mb-5">
                        <p> Email para redefinição foi enviado com sucesso, cheque sua caixa de entrada e conclua o processo!</p>
                    </div>
                @endif

                @error('email')
                    <div class="text-center mb-5">
                        <p> O email de reset foi enviado é necessário aguardar para realizar outro reset</p>
                    </div>
                @enderror
            </div>
        </div>
    </div>

@endsection




