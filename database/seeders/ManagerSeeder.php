<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ManagerSeeder extends Seeder
{
    public function run(): void
    {
        $managerRole = Role::where('name', 'Manager')->first();

        if (! $managerRole) {
            $managerRole = Role::create(['name' => 'Manager']);
        }

        User::updateOrCreate(
            ['email' => 'manager@demo.com'],
            [
                'name' => 'Demo Manager',
                'password' => Hash::make('123456'),
                'role_id' => $managerRole->id,
            ]
        );
    }
}
