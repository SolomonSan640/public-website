<?php

namespace Database\Seeders;

use App\Models\ContactPage;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactPageEnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "title_1" => "Contact",
                "content_1"=> "We are open to expand our suppliers across the globe. Please feel invited to become our client. More information about our activities and projects you will find in the relevant sections.",
                "title_2" => "Head Office", "content_2" => "No.1201, Pinlon Road, (35) Ward, North Dagon Township, Yangon, Myanmar",
                "title_3" => "Phone", "content_3" => "09 988877770, 09 988877779",
                "title_4" => "Email", "content_4" => "contact@freshmoe.com",
            ],
        ];
        foreach ($data as $value) {
            ContactPage::updateOrCreate($value);
        }
    }
}
