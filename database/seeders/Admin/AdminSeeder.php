<?php

namespace Database\Seeders\Admin;

use App\Models\Entities\Admin;
use App\Models\Entities\Role;
use Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $accounts = [
            [
                'name' => 'admin',
                'email' => 'admin@cw.com.tw',
                'protected' => 1,
            ],
            [
                'name' => '陳世彥',
                'email' => 'shihyen@cw.com.tw',
                'protected' => 1
            ],
            [
                'name' => '柯布丁',
                'email' => 'tingchungk@cw.com.tw',
                'protected' => 1,
            ],
            [
                'name' => '謝鴻逸',
                'email' => 'hansonshieh@cw.com.tw',
                'protected' => 1,
            ],
            [
                'name' => '徐文彬',
                'email' => 'sindershyu@cw.com.tw',
                'protected' => 1,
            ],
            [
                'name' => '林川正',
                'email' => 'peterlin@cw.com.tw',
                'protected' => 1,
            ],
            [
                'name' => '呂恩承',
                'email' => 'peterlu@cw.com.tw',
                'protected' => 1,
            ],
            [
                'name' => '劉佳豪',
                'email' => 'brendonliu@cw.com.tw',
                'protected' => 1,
            ],
            [
                'name' => '陳逸霖',
                'email' => 'jerrychenyilin@cw.com.tw',
                'protected' => 1,
            ],
            [
                'name' => '姜韋帆',
                'email' => 'wfchiang@cw.com.tw',
                'protected' => 1,
            ],

        ];

        foreach ($accounts as $account) {
            $model = new Admin();
            $model->fill(
                [
                    'name' => $account['name'],
                    'email' => $account['email'],
                    'password' => Hash::make(random_bytes(32)),
                    'status' => true,
                    'protected' => $account['protected'],
                    'role' => [Role::ADMIN],
                    'comment' => 'admin user.',
                ]
            )
                  ->save();
        }
    }
}
