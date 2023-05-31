<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */

     protected $member_route  = 'login';
     protected $admin_route = 'admin.login';

    protected function redirectTo($request)
    {
        if (! $request->expectsJson()) {

            if (Route::is('*')) {
                return route($this->member_route);
            } elseif (Route::is('admin.*')) {
                return route($this->admin_route);
            }
        }
    }
}
