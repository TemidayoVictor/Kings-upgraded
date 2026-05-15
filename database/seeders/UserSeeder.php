<?php

namespace Database\Seeders;

use App\Enums\UserType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create 10 random users with random roles
        $roles = Role::where('name', '!=', UserType::SUPERADMIN)->get();

        User::factory(10)->create()->each(function ($user) use ($roles) {
            $role = $roles->random();
            $user->assignRole($role);
        });
    }
}
