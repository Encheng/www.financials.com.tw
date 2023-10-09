<?php

namespace App\Http\Middleware;

use App\Models\Entities\Admin;
use Auth;
use Closure;
use Gate;
use Illuminate\Support\MessageBag;
use LogHelper;
use Route;

class CheckAdminRole
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        /** @var Admin $admin */
        $admin = Auth::guard('admin')
                     ->user();
        $msg = new MessageBag();

        if (!Gate::has($admin->role)) {
            $msg->add(1, '帳號群組設定錯誤');
            LogHelper::error(__METHOD__, "帳號群組設定錯誤", ['model' => $admin->getAttributes()]);

            return redirect()
                ->route('admin.logout')
                ->withErrors($msg);
        }

        if (
            Gate::forUser($admin)
                ->none($admin->role, Route::currentRouteAction())
        ) {
            $msg->add(1, '權限不足');

            return redirect()
                ->route('admin.index')
                ->withErrors($msg);
        }

        return $next($request);
    }
}
