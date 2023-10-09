<?php

namespace App\Http\Middleware;

use App\Models\Entities\Admin;
use Illuminate\Auth\Middleware\Authenticate as Middleware;

class AdminAuthenticate extends Middleware
{
    /**
     * @inheritDoc
     */
    protected function authenticate($request, array $guards)
    {
        if (empty($guards)) {
            $guards = [null];
        }

        foreach ($guards as $guard) {
            if (
                $this->auth->guard($guard)
                           ->check()
            ) {
                /** @var Admin $admin */
                $admin = $this->auth->guard($guard)
                                    ->user();
                if ($admin->status !== Admin::STATUS_ENABLE) {
                    continue;
                }

                return $this->auth->shouldUse($guard);
            }
        }

        $this->unauthenticated($request, $guards);
    }

    /**
     * @inheritDoc
     */
    protected function redirectTo($request)
    {
        if (!$request->expectsJson()) {
            return route('admin.login.index');
        }
    }
}
