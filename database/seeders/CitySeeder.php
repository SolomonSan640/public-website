<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $cities = [
            ['country_id' => 148, 'name_en' => 'Bagan'],
            ['country_id' => 148, 'name_en' => 'Bago'],
            ['country_id' => 148, 'name_en' => 'Dawei'],
            ['country_id' => 148, 'name_en' => 'Hpa-An'],
            ['country_id' => 148, 'name_en' => 'Inle Lake'],
            ['country_id' => 148, 'name_en' => 'Lashio'],
            ['country_id' => 148, 'name_en' => 'Mandalay'],
            ['country_id' => 148, 'name_en' => 'Mawlamyine'],
            ['country_id' => 148, 'name_en' => 'Meiktila'],
            ['country_id' => 148, 'name_en' => 'Monywa'],
            ['country_id' => 148, 'name_en' => 'Myitkyina'],
            ['country_id' => 148, 'name_en' => 'Naypyidaw'],
            ['country_id' => 148, 'name_en' => 'Pakokku'],
            ['country_id' => 148, 'name_en' => 'Pathein'],
            ['country_id' => 148, 'name_en' => 'Pyay'],
            ['country_id' => 148, 'name_en' => 'Pyin Oo Lwin'],
            ['country_id' => 148, 'name_en' => 'Sagaing'],
            ['country_id' => 148, 'name_en' => 'Taunggyi'],
            ['country_id' => 148, 'name_en' => 'Yangon'],
        ];

        // Sort cities alphabetically
        usort($cities, function($a, $b) {
            return strcmp($a['name_en'], $b['name_en']);
        });

        foreach ($cities as $city) {
            City::create($city);
        }
    }
}
