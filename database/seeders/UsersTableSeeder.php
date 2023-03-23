<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'                 => 1,
                'name'               => 'admin',
                'email'              => 'admin@admin.com',
                'password'           => bcrypt('password'),
                'remember_token'     => null,
                'mobile'             => "01674797580",
                'approved'           => 1,
                'verified'           => 1,
                'verified_at'        => '2022-08-02 04:35:32',
                'verification_token' => '',
            ],
        ];

        User::insert($users);
    }
}
