<?php

namespace Database\Factories;

use App\Models\Entities\Admin;
use App\Models\Entities\Role;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class AdminFactory extends Factory
{
    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $roles = new Role();
        $roleList = array_keys($roles->list());

        return [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => Str::random(50),
            'status' => rand(0, 1),
            'protected' => rand(0, 1),
            'role' => $roleList[rand(0, count($roles->list()) - 1)],
            'comment' => $this->faker->realText(rand(10, 50)),
            'oauth_token' => (range(0, 1)) ? Str::random(64) : null,
            'remember_token' => (range(0, 1)) ? Str::random(64) : null,
        ];
    }
}
