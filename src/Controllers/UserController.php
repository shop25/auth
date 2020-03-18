<?php

namespace S25\Auth\Controllers;


use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class UserController extends Controller
{
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
}
