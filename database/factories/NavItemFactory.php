<?php

namespace Database\Factories;

use App\Models\Entities\NavItem;
use App\Models\Entities\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class NavItemFactory extends Factory
{
    protected $model = NavItem::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $routes = \Route::getRoutes()
                        ->getRoutes();
        shuffle($routes);

        /** @var \Illuminate\Routing\Route $route */
        $route = \Arr::first($routes);
        $roles = array_keys(Role::list());
        shuffle($roles);

        return [
            'parent_id' => null,
            'active_nav_item_id' => null,
            'name' => $this->faker->word,
            'route_name' => $route->getName(),
            'role' => array_splice($roles, 0, rand(1, count($roles))),
            'display' => rand(0, 1),
        ];
    }
}
