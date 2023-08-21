<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run (): void
    {
        Role::create( [
            'guard_name' => 'api',
            'name'       => Role::EMPLOYEE,
        ] );

        Role::create( [
            'guard_name' => 'api',
            'name'       => Role::COURIER,
        ] );
    }
}
