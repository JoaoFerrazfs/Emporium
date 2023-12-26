<?php

namespace App\Http\Apis\v1\Auth;

use App\Http\Apis\Requests\Auth\AuthLoginRequest;
use App\Http\Apis\Requests\Auth\AuthRegisterRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Contracts\Auth\Factory as AuthFactory;
use Laravel\Passport\PersonalAccessTokenResult;
use Illuminate\Contracts\Foundation\Application;
use Tests\TestCase;
use Mockery as m;

class UserAuthControllerTest extends TestCase
{
    public function testShouldRegisterAnUser(): void
    {
        // Set
        $request = m::mock(AuthRegisterRequest::class);
        $user = m::mock(User::class);
        $userRepository = m::mock(UserRepository::class);
        $application = m::mock(Application::class);
        $userAuthController = new UserAuthController($userRepository, $application);
        $personalAccessTokenResult = m::mock(PersonalAccessTokenResult::class);
        $personalAccessTokenResult->accessToken = '123zxc123';
        $input =  [
            'email' => 'joaoferrazp@gmail.com',
            'password' => '123456',
            'scopes' => ['products_read']
        ];
        $expected = [
            'user' => 'serealized user',
            'token' => '123zxc123'
        ];

        // Expectations
        $request->expects()
            ->all()
            ->andReturn($input);

        $request->expects()
            ->input('scopes', [])
            ->andReturn($input['scopes']);

        $userRepository->expects()
            ->createUser($input)
            ->andReturn($user);

        $user->expects()
            ->createToken('API Token', $input['scopes'])
            ->andReturn($personalAccessTokenResult);

        $user->expects()
            ->jsonSerialize()
            ->andReturn('serealized user');

        // Actions
        $action =$userAuthController->register($request);

        // Assertions
        $this->assertSame(json_encode($expected), $action->content());
    }

    public function testShouldNotMakeUserLogin(): void
    {
        // Set
        $request = m::mock(AuthLoginRequest::class);
        $authFactory = m::mock(AuthFactory::class);
        $userRepository = m::mock(UserRepository::class);
        $application = m::mock(Application::class);
        $userAuthController = new UserAuthController($userRepository, $application);
        $personalAccessTokenResult = m::mock(PersonalAccessTokenResult::class);
        $personalAccessTokenResult->accessToken = '123zxc123';
        $input =  [
            'email' => 'joaoferrazp@gmail.com',
            'password' => '123456'
        ];
        $expected = ['error_message' => 'Incorrect Details. Please try again'];

        // Expectations
        $request->expects()
            ->all()
            ->andReturn($input);

        $application->expects()
            ->make(AuthFactory::class)
            ->andReturn($authFactory);

        $authFactory->expects()
            ->attempt($input)->andReturnFalse();

        // Actions
        $action =$userAuthController->login($request);

        // Assertions
        $this->assertSame(json_encode($expected), $action->content());
    }

    public function testShouldMakeUserLogin(): void
    {
        // Set
        $request = m::mock(AuthLoginRequest::class);
        $user = m::mock(User::class);
        $authFactory =  m::mock(AuthFactory::class);
        $userRepository = m::mock(UserRepository::class);
        $application = m::mock(Application::class);
        $userAuthController = new UserAuthController($userRepository, $application);
        $personalAccessTokenResult = m::mock(PersonalAccessTokenResult::class);
        $personalAccessTokenResult->accessToken = '123zxc123';
        $input =  [
            'email' => 'joaoferrazp@gmail.com',
            'password' => '123456'

        ];
        $scopes = ['scopes' => 'products_read'];
        $expected = [
            'user' => 'serealized user',
            'token' => '123zxc123'
        ];

        // Expectations
        $request->expects()
            ->all()
            ->andReturn($input);

        $request->expects()
            ->user()
            ->andReturn($user);

        $authFactory->allows()
            ->attempt($input)->andReturnTrue();

        $user->expects()
            ->getAttribute('scopes')
            ->andReturn(json_encode($scopes));

        $user->expects()
            ->createToken('API Token', $scopes)
            ->andReturn($personalAccessTokenResult);

        $user->expects()
            ->jsonSerialize()
            ->andReturn('serealized user');

        $application->expects()
            ->make(AuthFactory::class)
            ->andReturn($authFactory);

        // Actions
        $action =$userAuthController->login($request);

        // Assertions
        $this->assertSame(json_encode($expected), $action->content());
    }
}
