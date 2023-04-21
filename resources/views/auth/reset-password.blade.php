@extends('ecommerce.layouts.main')
@section('title', 'Emporium')
@section('content')

    <div class="container-login">
        <div class="col-md-5 col-sm-12 mx-auto">
            <div class="card-body">
                <div class="text-center mb-5">
                    <img src="/images/favicon.png" height="48" class="mb-4">
                    <h3>Reset de senha</h3>
                    <p> Para seguir com o processo de reset de senha ensira seu email abaixo.</p>
                </div>

                <div class="mb-4">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <div class="font-medium text-red-600">
                                {{ __('Ops! Algo de errado aconteceu.') }}
                            </div>
                            <ul class="mt-3 list-disc list-inside text-sm text-red-600">
                                    <li>O token já fui utilizado, será necessário refazer o pedido de reset de senha</li>
                            </ul>
                        </div>
                    @endif
                </div>

                <form method="POST" action="{{ route('password.update') }}">
                    @csrf
                    <div class="form-group mb-4">
                        <label for="first-name-column">Email</label>
                        <input type="email" id="email" class="form-control" name="email" value={{ old('email', $request->email) }}>
                    </div>

                    <div class="form-group mb-4">
                        <label for="password">Nova senha</label>
                        <input type="password" id="password" class="form-control" name="password"  >
                    </div>

                    <div class="form-group mb-4">
                        <label for="password_confirmation">Nova senha</label>
                        <input type="password" id="password_confirmation" class="form-control" name="password_confirmation"  >
                    </div>

                    <div class="clearfix">
                        <button type="submit" class="btn btn-primary float-end">Enviar</button>
                    </div>

                    <input type="hidden" name="token" value="{{ $request->route('token') }}">

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





{{--<x-guest-layout>--}}
{{--    <x-auth-card>--}}
{{--        <x-slot name="logo">--}}
{{--            <a href="/">--}}
{{--                <x-application-logo class="w-20 h-20 fill-current text-gray-500" />--}}
{{--            </a>--}}
{{--        </x-slot>--}}

{{--        <!-- Validation Errors -->--}}
{{--        <x-auth-validation-errors class="mb-4" :errors="$errors" />--}}

{{--        <form method="POST" action="{{ route('password.update') }}">--}}
{{--            @csrf--}}

{{--            <!-- Password Reset Token -->--}}
{{--            <input type="hidden" name="token" value="{{ $request->route('token') }}">--}}

{{--            <!-- Email Address -->--}}
{{--            <div>--}}
{{--                <x-label for="email" :value="__('Email')" />--}}

{{--                <x-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email', $request->email)" required autofocus />--}}
{{--            </div>--}}

{{--            <!-- Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="password" :value="__('Password')" />--}}

{{--                <x-input id="password" class="block mt-1 w-full" type="password" name="password" required />--}}
{{--            </div>--}}

{{--            <!-- Confirm Password -->--}}
{{--            <div class="mt-4">--}}
{{--                <x-label for="password_confirmation" :value="__('Confirm Password')" />--}}

{{--                <x-input id="password_confirmation" class="block mt-1 w-full"--}}
{{--                                    type="password"--}}
{{--                                    name="password_confirmation" required />--}}
{{--            </div>--}}

{{--            <div class="flex items-center justify-end mt-4">--}}
{{--                <x-button>--}}
{{--                    {{ __('Reset Password') }}--}}
{{--                </x-button>--}}
{{--            </div>--}}
{{--        </form>--}}
{{--    </x-auth-card>--}}
{{--</x-guest-layout>--}}
