<?php

namespace Database\Seeders;

use App\Models\ContactPageMM;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactPageMmSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "title_1" => "ဆက်သွယ်ရန်",
                "content_1"=> "ကျွန်ုပ်တို့၏ ပေးသွင်းသူများအတွက် ကမ္ဘာတစ်ဝှမ်းတွင် တိုးချဲ့ဖွင့်လှစ်ထားပါသည်။ ကျွန်ုပ်တို့၏ဖောက်သည်ဖြစ် လာရန် ဖိတ်ခေါ်အပ်ပါသည်။ သက်ဆိုင်ရာကဏ္ဍများတွင် ကျွန်ုပ်တို့၏လုပ်ဆောင်မှုများနှင့် ပရောဂျက်များ အကြောင်း ပိုမိုသိရှိနိုင်မည် ဖြစ်သည်။",
                "title_2" => "ရုံးချုပ်လိပ်စာ", "content_2" => "အမှတ်(၁၂၀၁)၊ ပင်လုံလမ်းမကြီး၊ (၃၅) ရပ်ကွက်၊ မြောက်ဒဂုံမြို့နယ်၊ ရန်ကုန်တိုင်း၊ မြန်မာ",
                "title_3" => "ဖုန်းနံပါတ်", "content_3" => "၀၉၉၈၈၈၇၇၇၇၀၊ ၀၉၉၈၈၈၇၇၇၇၉",
                "title_4" => "အီးမေးလ်", "content_4" => "contact@freshmoe.com",
            ],
        ];
        foreach ($data as $value) {
            ContactPageMM::updateOrCreate($value);
        }
    }
}
