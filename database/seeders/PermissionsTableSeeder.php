<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
//            [
//                'id'    => 1,
//                'title' => 'user_management_access',
//            ],
//            [
//                'id'    => 2,
//                'title' => 'permission_create',
//            ],
//            [
//                'id'    => 3,
//                'title' => 'permission_edit',
//            ],
//            [
//                'id'    => 4,
//                'title' => 'permission_show',
//            ],
//            [
//                'id'    => 5,
//                'title' => 'permission_delete',
//            ],
//            [
//                'id'    => 6,
//                'title' => 'permission_access',
//            ],
//            [
//                'id'    => 7,
//                'title' => 'role_create',
//            ],
//            [
//                'id'    => 8,
//                'title' => 'role_edit',
//            ],
//            [
//                'id'    => 9,
//                'title' => 'role_show',
//            ],
//            [
//                'id'    => 10,
//                'title' => 'role_delete',
//            ],
//            [
//                'id'    => 11,
//                'title' => 'role_access',
//            ],
//            [
//                'id'    => 12,
//                'title' => 'user_create',
//            ],
//            [
//                'id'    => 13,
//                'title' => 'user_edit',
//            ],
//            [
//                'id'    => 14,
//                'title' => 'user_show',
//            ],
//            [
//                'id'    => 15,
//                'title' => 'user_delete',
//            ],
//            [
//                'id'    => 16,
//                'title' => 'user_access',
//            ],
//            [
//                'id'    => 17,
//                'title' => 'audit_log_show',
//            ],
//            [
//                'id'    => 18,
//                'title' => 'audit_log_access',
//            ],
//            [
//                'id'    => 19,
//                'title' => 'profile_password_edit',
//            ],
//            [
//                'id'    => 20,
//                'title' => 'setting_edit',
//            ],
//            [
//                'id'    => 21,
//                'title' => 'setting_access',
//            ],
//            [
//                'id'    => 22,
//                'title' => 'valid_email_create',
//            ],
//            [
//                'id'    => 23,
//                'title' => 'valid_email_edit',
//            ],
//            [
//                'id'    => 24,
//                'title' => 'valid_email_show',
//            ],
//            [
//                'id'    => 25,
//                'title' => 'valid_email_delete',
//            ],
//            [
//                'id'    => 26,
//                'title' => 'valid_email_access',
//            ],
//            [
//                'id'    => 27,
//                'title' => 'package_create',
//            ],
//            [
//                'id'    => 28,
//                'title' => 'package_edit',
//            ],
//            [
//                'id'    => 29,
//                'title' => 'package_show',
//            ],
//            [
//                'id'    => 30,
//                'title' => 'package_delete',
//            ],
//            [
//                'id'    => 31,
//                'title' => 'package_access',
//            ],
//            [
//                'id'    => 32,
//                'title' => 'purchase_create',
//            ],
//            [
//                'id'    => 33,
//                'title' => 'purchase_edit',
//            ],
//            [
//                'id'    => 34,
//                'title' => 'purchase_show',
//            ],
//            [
//                'id'    => 35,
//                'title' => 'purchase_access',
//            ],
            [
                'id'    => 36,
                'title' => 'benefit_create',
            ],
            [
                'id'    => 37,
                'title' => 'benefit_edit',
            ],
            [
                'id'    => 38,
                'title' => 'benefit_show',
            ],
            [
                'id'    => 39,
                'title' => 'benefit_delete',
            ],
            [
                'id'    => 40,
                'title' => 'benefit_access',
            ],


        ];

        Permission::insert($permissions);
    }
}
