<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'Admin', 'role_id' => 1, 'email' => 'admin@freshmoe.com', 'password' => Hash::make('admin')],
            ['name' => 'Merchant', 'role_id' => 2, 'email' => 'merchant@freshmoe.com', 'password' => Hash::make('admin')],
        ];
        foreach ($data as $value) {
            User::updateOrCreate(
                ['email' => $value['email']],
                [
                    'name' => $value['name'],
                    'role_id' => $value['role_id'],
                    'password' => $value['password'],
                ]
            );
        }
    }
}
