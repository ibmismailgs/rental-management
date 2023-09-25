<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('permissions')->insert([
            [
                'id' => 1,
                'name' => 'manage_roles',
                'guard_name' => 'web',
            ],
            [
                'id' => 2,
                'name' => 'manage_permission',
                'guard_name' => 'web',
            ],
            [
                'id' => 3,
                'name' => 'manage_user',
                'guard_name' => 'web',
            ],
            [
                'id' => 4,
                'name' => 'manage_owner',
                'guard_name' => 'web',
            ],
            [
                'id' => 5,
                'name' => 'manage_flat',
                'guard_name' => 'web',
            ],
            [
                'id' => 6,
                'name' => 'manage_tenant',
                'guard_name' => 'web',
            ],
            [
                'id' => 7,
                'name' => 'manage_rent',
                'guard_name' => 'web',
            ],
            [
                'id' => 8,
                'name' => 'manage_rent_collect',
                'guard_name' => 'web',
            ],
            [
                'id' => 9,
                'name' => 'manage_due_collect',
                'guard_name' => 'web',
            ],
            [
                'id' => 10,
                'name' => 'manage_mobile_banking',
                'guard_name' => 'web',
            ],
            [
                'id' => 11,
                'name' => 'manage_mobile_banking_account',
                'guard_name' => 'web',
            ],
            [
                'id' => 12,
                'name' => 'manage_bank',
                'guard_name' => 'web',
            ],
            [
                'id' => 13,
                'name' => 'manage_bank_account',
                'guard_name' => 'web',
            ],
            [
                'id' => 14,
                'name' => 'manage_expense_category',
                'guard_name' => 'web',
            ],
            [
                'id' => 15,
                'name' => 'manage_expense',
                'guard_name' => 'web',
            ],
            [
                'id' => 16,
                'name' => 'manage_revenue',
                'guard_name' => 'web',
            ],
        ]);
    }
}
