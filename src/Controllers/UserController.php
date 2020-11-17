<?php

namespace S25\Auth\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use S25\Auth\UserProvider\UserProviderInterface;
use S25\Auth\UserProvider\UserResource;

class UserController extends Controller
{
    /** @var UserProviderInterface */
    private $users;

    public function __construct(UserProviderInterface  $userProvider)
    {
        $this->users = $userProvider;
    }

    public function user(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return abort(401, 'Unauthorized');
        }

        $userResource = [
            'id'              => $user->id,
            'firstName'       => $user->firstName,
            'lastName'        => $user->lastName,
            'phone'           => $user->phone,
            'avatar'          => $user->avatar,
            'positionName'    => $user->positionName,
            'groupId'         => $user->groupId,
            'personnelNumber' => $user->personnelNumber,
        ];

        return JsonResponse::create(['user' => $userResource]);
    }

    public function all(Request $request)
    {
        $managers = collect($this->users->all(config('through.app_code')))->keyBy('id');

        $groupedManagers = [];

        foreach ($managers as $uuid => $manager) {
            $groupedManagers[$manager->positionName][$uuid] = UserResource::make($manager);
        }

        return new JsonResponse($groupedManagers);
    }
}
