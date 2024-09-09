<?php

namespace Database\Seeders;

use App\Models\Township;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TownshipSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $townships = [
            ['city_id' => 19, 'name_en' => 'Ahlon'],
            ['city_id' => 19, 'name_en' => 'Bahan'],
            ['city_id' => 19, 'name_en' => 'Dagon Seikkan'],
            ['city_id' => 19, 'name_en' => 'Dagon'],
            ['city_id' => 19, 'name_en' => 'Dala'],
            ['city_id' => 19, 'name_en' => 'Dawbon'],
            ['city_id' => 19, 'name_en' => 'East Dagon'],
            ['city_id' => 19, 'name_en' => 'Hlaing'],
            ['city_id' => 19, 'name_en' => 'Hlaingthaya'],
            ['city_id' => 19, 'name_en' => 'Insein'],
            ['city_id' => 19, 'name_en' => 'Kamayut'],
            ['city_id' => 19, 'name_en' => 'Kyauktada'],
            ['city_id' => 19, 'name_en' => 'Kyauktan'],
            ['city_id' => 19, 'name_en' => 'Kyimyindaing'],
            ['city_id' => 19, 'name_en' => 'Lanmadaw'],
            ['city_id' => 19, 'name_en' => 'Latha'],
            ['city_id' => 19, 'name_en' => 'Mayangone'],
            ['city_id' => 19, 'name_en' => 'Mingalar Taung Nyunt'],
            ['city_id' => 19, 'name_en' => 'Mingalardon'],
            ['city_id' => 19, 'name_en' => 'North Dagon'],
            ['city_id' => 19, 'name_en' => 'North Okkalapa'],
            ['city_id' => 19, 'name_en' => 'Pabedan'],
            ['city_id' => 19, 'name_en' => 'Pazundaung'],
            ['city_id' => 19, 'name_en' => 'Sanchaung'],
            ['city_id' => 19, 'name_en' => 'South Dagon'],
            ['city_id' => 19, 'name_en' => 'South Okkalapa'],
            ['city_id' => 19, 'name_en' => 'Tamwe'],
            ['city_id' => 19, 'name_en' => 'Thingangyun'],
            ['city_id' => 19, 'name_en' => 'Thongwa'],
            ['city_id' => 19, 'name_en' => 'Twantay'],
            ['city_id' => 19, 'name_en' => 'Yankin'],
        ];

        foreach ($townships as $township) {
            Township::create($township);
        }
    }
}
