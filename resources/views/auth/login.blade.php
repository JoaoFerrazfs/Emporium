@extends('ecommerce.layouts.main')
@section('title', 'Emporium')
@section('content')

    <div class="container-login">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card-body">
                <div class="text-center mb-5">
                    <img src="/images/favicon.png" height="48" class="mb-4">
                    <h3>Login</h3>
                </div>
                <form method="post" action="{{route('login')}}">
                    @csrf
                    <div class="form-group position-relative has-icon-left">
                        <label for="username">Email</label>
                        <div class="position-relative mt-3">
                            <input type="text" class="form-control" id="email" name="email">
                        </div>
                    </div>
                    <div class="form-group position-relative has-icon-left mt-4">
                        <div class="clearfix">
                            <label for="password">Senha</label>
                            <a href="{{ route('password.request') }}" class="float-end mt-3 ">
                                <small>Esqueceu sua senha?</small>
                            </a>
                        </div>
                        <div class="position-relative">
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                    </div>

                    <div class="form-check clearfix my-4">
                        <div class="float-end">
                            <a href="{{route('user.register')}}">Não tem uma conta?</a>
                        </div>
                    </div>
                    <div class="clearfix">
                        <button class="btn btn-lg btn-primary d-block mx-auto">Logar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection




