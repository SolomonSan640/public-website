<?php

namespace Database\Seeders;

use App\Models\TimeZone;
use Illuminate\Database\Seeder;

class TimeZoneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            ['name' => 'GMT-12:00'],
            ['name' => 'GMT-11:00'],
            ['name' => 'GMT-10:00'],
            ['name' => 'GMT-09:30'],
            ['name' => 'GMT-09:00'],
            ['name' => 'GMT-08:00'],
            ['name' => 'GMT-07:00'],
            ['name' => 'GMT-06:00'],
            ['name' => 'GMT-05:00'],
            ['name' => 'GMT-04:00'],
            ['name' => 'GMT-03:30'],
            ['name' => 'GMT-03:00'],
            ['name' => 'GMT-02:00'],
            ['name' => 'GMT-01:00'],
            ['name' => 'GMT-00:00'],
            ['name' => 'GMT+01:00'],
            ['name' => 'GMT+02:00'],
            ['name' => 'GMT+03:00'],
            ['name' => 'GMT+03:30'],
            ['name' => 'GMT+04:00'],
            ['name' => 'GMT+04:30'],
            ['name' => 'GMT+05:00'],
            ['name' => 'GMT+05:30'],
            ['name' => 'GMT+05:45'],
            ['name' => 'GMT+06:00'],
            ['name' => 'GMT+06:30'],
            ['name' => 'GMT+07:00'],
            ['name' => 'GMT+08:00'],
            ['name' => 'GMT+08:30'],
            ['name' => 'GMT+08:45'],
            ['name' => 'GMT+09:00'],
            ['name' => 'GMT+09:30'],
            ['name' => 'GMT+10:00'],
            ['name' => 'GMT+10:30'],
            ['name' => 'GMT+11:00'],
            ['name' => 'GMT+12:00'],
            ['name' => 'GMT+12:45'],
            ['name' => 'GMT+13:00'],
            ['name' => 'GMT+14:00'],

        ];
        foreach ($data as $value) {
            TimeZone::updateOrCreate($value);
        }
    }
}
