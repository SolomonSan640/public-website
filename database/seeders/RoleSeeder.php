<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ['name' => 'Admin', 'type' => 'Admin'],
            ['name' => 'Merchant', 'type' => 'Merchant'],
        ];
        foreach ($data as $value) {
            Role::updateOrCreate($value);
        }
    }
}
