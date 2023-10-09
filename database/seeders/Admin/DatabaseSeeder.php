<?php

namespace Database\Seeders\Admin;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{

    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        $this->call(AdminSeeder::class);
        $this->call(NavItemSeeder::class);
        $this->call(AdminNavItemSeeder::class);
        Model::reguard();
        \Artisan::call('cache:clear');
    }
}
