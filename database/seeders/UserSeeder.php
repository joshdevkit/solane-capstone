<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{

    public function run(): void
{
    try {
        $role = Role::firstOrCreate(['name' => 'Admin']);

        $user = User::create([
            'employee_number' => '00000',
            'name' => 'Admin User',
            'email' => 'admin@gmail.com',
            'password' => Hash::make('12345678'),
        ]);

        $user->assignRole($role);
        echo "User seeded successfully.";
    } catch (\Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
}
