<?php

namespace Database\Seeders;

use App\Models\Regional;
use Illuminate\Database\Seeder;

class RegionalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $data = [
            ['name' => 'Asia Pacific'],
            ['name' => 'Middle East'],
            ['name' => 'Europe'],
            ['name' => 'North America'],
        ];
        foreach ($data as $value) {
            Regional::updateOrCreate($value);
        }
    }
}
