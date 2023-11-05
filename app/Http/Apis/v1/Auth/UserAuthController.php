<?php

namespace App\Http\Apis\v1\Auth;

use App\Http\Apis\Requests\Auth\AuthLoginRequest;
use App\Http\Apis\Requests\Auth\AuthRegisterRequest;
use App\Http\Controllers\Controller;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use App\Repositories\UserRepository;
use Illuminate\Http\Response;
use Illuminate\Contracts\Foundation\Application;
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
        $user = $this->repository->createUser($request->all());
        $token = $user->createToken('API Token')->accessToken;

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
        $token = $user->createToken('API Token')->accessToken;

        return response(compact('user', 'token'));

    }
}
