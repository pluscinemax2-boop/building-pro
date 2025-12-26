<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Role;   // ✅ IMPORTANT LINE

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        Role::insert([
            ['name' => 'Admin'],
            ['name' => 'Building Admin'],
            ['name' => 'Manager'],
            ['name' => 'Resident'],
        ]);
    }
}
