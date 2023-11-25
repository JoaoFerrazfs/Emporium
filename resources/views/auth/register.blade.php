@extends('ecommerce.layouts.main')
@section('title', 'Emporium')
@section('content')

    <div class="container-login">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card pt-4">
                <div class="card-body">
                    <div class="text-center mb-5">
                        <img src="/images/favicon.png" height="48" class="mb-4">
                        <h3>Registrar conta</h3>
                    </div>
                    <form method="POST" action="{{ route('user.register') }}">
                        @csrf
                        <div class="row mb-4 ">
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="first-name-column">Nome</label>
                                    <input type="text" id="name" class="form-control" name="name" value="{{old('name')}}" required autofocus>
                                </div>
                            </div>
                            <div class="col-md-4 col-6">
                                <div class="form-group">
                                    <label for="last-name-column">Telefone</label>
                                    <input type="text" id="phone" class="form-control" name="phone" value="{{old('phone')}}" required>
                                </div>
                            </div>
                            <div class="col-md-4 col-12">
                                <div class="form-group">
                                    <label for="username-column">Email</label>
                                    <input type="text" id="email" class="form-control" name="email" value="{{old('email')}}" required >
                                </div>
                            </div>

                        </div>

                        <div class="row mb-5">
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="country-floating">Senha</label>
                                    <input type="password" id="password" class="form-control" name="password">
                                </div>
                            </div>
                            <div class="col-md-6 col-12">
                                <div class="form-group">
                                    <label for="country-floating">Repita a senha</label>
                                    <input type="password" id="password_confirmation" class="form-control" name="password_confirmation">
                                </div>
                            </div>
                        </div>

                        <a href="{{ route('login') }}">Já tem uma conta? Faça login</a>

                        <div class="clearfix">
                            <button class="btn btn-lg btn-primary d-block mx-auto">Registrar</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

@endsection




