<?php

namespace App\Http\Apis\v1\Auth;

use App\Http\Apis\Requests\Auth\AuthLoginRequest;
use App\Http\Apis\Requests\Auth\AuthRegisterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\Response;


use Illuminate\Contracts\Routing\ResponseFactory;


class UserAuthController extends Controller
{
    public function __construct(
        private readonly UserRepository $repository,
        private readonly Application $application,
    ){
    }

    public function register(AuthRegisterRequest $request): Response|Application|ResponseFactory
    {
        $scopes = $request->input('scopes', []);
        $user = $this->repository->createUser($request->all());
        $token = $user->createToken('API Token', $scopes)->accessToken;

        return response(compact('user','token'));
    }

    public function login(AuthLoginRequest $request): Response | Application | ResponseFactory
    {
        $AuthFactory = $this->application->make( AuthFactory::class);
        if (!$AuthFactory->attempt($request->all())) {
            return response([
                'error_message' => 'Incorrect Details. Please try again'
            ]);
        }

        $user =  $request->user();
        $scopes = json_decode($user->scopes, true);
        $token = $user->createToken('API Token', $scopes)->accessToken;

        return response(compact('user', 'token'));

    }
}
