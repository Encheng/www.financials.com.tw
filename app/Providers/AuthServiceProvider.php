<?php

namespace App\Providers;

use App\Models\Entities\Role;
use Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->adminGates();
    }

    protected function adminGates()
    {
        $permissions = config('permission', []);
        foreach ($permissions as $role => $controllers) {
            Gate::define($role, function ($admin, $currentAction) use ($controllers) {
                $controller = explode('@', $currentAction);
                if (!isset($controller[0])) {
                    return false;
                }

                if (in_array(Role::ADMIN, $admin->role, true)) {
                    return true;
                }

                if (in_array($controller[0], $controllers, true)) {
                    return true;
                }

                return false;
            });
        }
    }
}
