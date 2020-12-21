<?php

namespace S25\Auth\Controllers;

use App\Http\Controllers\Controller;
use S25\Auth\RedisUserRepository;
use GuzzleHttp\Client;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use S25\Auth\User;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /** @var RedisUserRepository */
    private $userRepository;

    /**
     * Create a new controller instance.
     *
     * @param RedisUserRepository $userRepository
     */
    public function __construct(RedisUserRepository $userRepository)
    {
        $this->middleware('guest')->except('logout', 'loginByToken');

        $this->userRepository = $userRepository;
    }

    public function loginByToken(Request $request)
    {
        $token = $this->getToken($request);

        $payload = JWTAuth::setToken($token)->payload();

        $userData = [
            'id'              => $payload->get('id'),
            'firstName'       => $payload->get('firstName'),
            'lastName'        => $payload->get('lastName'),
            'phone'           => $payload->get('phone'),
            'personnelNumber' => $payload->get('personnelNumber'),
            'avatar'          => $payload->get('avatar'),
            'groupId'         => $payload->get('groupId'),
            'positionName'    => $payload->get('positionName')
        ];

        $user = new User($userData);

        $this->userRepository->save($user);

        auth()->login($user);

        return $this->sendLoginResponse($request);
    }

    public function logout(Request $request): JsonResponse
    {
        $user = $request->user();
        $this->userRepository->remove($user->id);
        $request->session()->flush();

        $client = new Client();
        $client->post(config('through.auth_service') . 'logout');

        return JsonResponse::create(['url' => config('through.auth_service') . 'logout']);
    }

    private function getToken(Request $request)
    {
        return $request->get('auth_token') ?? $request->get('token');
    }
}
