<?php

namespace S25\Auth\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string
     */
    protected function redirectTo($request)
    {
        if (($authServiceUrl = rtrim(config('through.auth_service'), '/')) === null) {
            abort(403, 'Unauthorized');
        }

        return $authServiceUrl . '/get_token?returnUrl=' . rtrim(config('through.app_url'), '/') . '/me?auth_token=';
    }
}
