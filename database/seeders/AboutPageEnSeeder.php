<?php

namespace Database\Seeders;

use App\Models\AboutPage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AboutPageEnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "title_1" => "About Us",
                "title_2" => "What We Are", "image_2" => "images/aboutus-1.png", "content_2" => "We believe that life is good, so we need to keep it healthy and fresh. Our goal is to inspire healthy lifestyles through wholesome, convenient foods that benefit everyone. Serving our valued customers the finest and freshest fruit and vegetables is something we are enthusiastic about. Our high quality fresh fruits & vegetables available as whole, fresh cut and packaged products, make it easy to choose wholesome options whether you’re at home or on the go. FreshMoe brand is the symbol of quality, innovation, reliability, and new product development in the manufacturing and service sectors.",
                "image_3"=> "images/aboutus-2.png",
                "image_4"=> "images/aboutus-3.png",
                "image_5"=> "images/aboutus-5.png",
                "image_6"=> "images/aboutus-4.png",
            ],
        ];
        foreach ($data as $value) {
            AboutPage::updateOrCreate($value);
        }
    }
}
