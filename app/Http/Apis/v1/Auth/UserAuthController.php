<?php

namespace App\Http\Apis\v1\Auth;

use App\Http\Apis\Requests\Auth\AuthLoginRequest;
use App\Http\Apis\Requests\Auth\AuthRegisterRequest;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;


class UserAuthController extends Controller
{
    public function register(AuthRegisterRequest $request): Response|Application|ResponseFactory
    {
        $user = User::create($request->all());
        $token = $user->createToken('API Token')->accessToken;

        return response(compact('user','token'));
    }

    public function login(AuthLoginRequest $request): Response | Application | ResponseFactory
    {
        if (!auth()->attempt($request->all())) {
            return response([
                'error_message' => 'Incorrect Details. Please try again'
            ]);
        }

        $user =  $request->user();
        $token = $user->createToken('API Token')->accessToken;

        return response(compact('user', 'token'));

    }
}
