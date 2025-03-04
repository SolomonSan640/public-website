<?php

namespace Database\Seeders;

use App\Models\ProfilePageMM;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProfilePageMmSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "title_1" => "ကိုယ်ရေးအချက်အလက်",
                "title_2" => "ဖောက်သည် နှင့် အနာဂါတ်အစီအစဥ်", "image_2" => "images/profile1.png", "content_2" => "ထုတ်ကုန်များကို ကြယ်ငါးပွင့်အဆင့် ဟိုတယ်လုပ်ငန်းစုများမှ ဒေသခံ လက်လီလက်ကား ရောင်းချ သည့်ပွဲရုံများ၊ စားသောက်ဆိုင်များအထိ အလတ်ဆတ်ဆုံး၊ အာဟာရ အပြည့်၀ဆုံး သစ်သီး နှင့် ဟင်းသီးဟင်းရွက် များကို အရည်အသွေးမှန်၊ စျေးနှုန်း မှန်ကန်စွာဖြင့် ဖြန့်ဖြူးပေးပြီး ကျွန်ုပ်တို့ထုတ်ကုန်၏ တန်ဖိုးကို နားလည် စေပါသည်။ ဖောက်သည်များ၏ တစ်ဦးချင်း၊ အဖွဲ့အစည်းအမျိုးမျိုး နှင့် စီးပွားရေးလုပ်ငန်းအမျိုးမျိုးရှိ နယ်ပယ် အသီးသီးကို အခြေခံထားပြီး ၄င်းတို့ရရှိသော သစ်သီးဝလံနှင့် ဟင်းသီးဟင်းရွက်တိုင်းသည် အရည်အသွေးစံချိန်စံနှုန်း ပြည့်မှီစေရန် လုပ်ဆောင်ပေးထားပြီး သုံးစွဲသူများ၏ စိတ်ကျေနပ်မှုကို ရရှိစေပါသည်။ ပြောင်းလဲလာသော ရာသီဥတု နှင့် ကိုက်ညီသော စိုက်ပျိုးရေးနည်းစနစ်များ ဖော်ထုတ်၍ လက်မှုစိုက်ပျိုးရေးစနစ် မှ စက်မှုစိုက်ပျိုးရေးစနစ်သို့ အချိတ်အဆက်မိမိ ကူးပြောင်းဆောင်ရွက်နိုင်ရန် အားပေးဆောင်ရွက်သွားမည်။ ဝန်ဆောင်မှုများ၊ ထုတ်ကုန်များနှင့် ဆန်းသစ်တီထွင်မှုများ စဉ်ဆက်မပြတ်တိုးမြင့်လာစေရန်ရည်ရွယ်ထားပြီး ရေရှည်တည်တံ့မှုနှင့် သုံးစွဲသူစိတ်ကျေနပ်မှုကို ရရှိစေမည့် ရေရှည်အစီအစဉ်များစွာ စီမံထားကြောင်း ကျွန်ုပ်တို့ ကတိကဝတ်ပြုပါသည်။",
                "title_3" => "ကျွန်ုပ်တို့ ဦးစားပေးစျေးကွက်", "content_3" => "ကျွန်ုပ်တို့ကုမ္ပဏီသည် ပြည်တွင်းစျေးကွက်အပြင် အိမ်နီးချင်းနိုင်ငံများ၏ ထုတ်ကုန်စျေးကွက်ကိုလည်း ထိုးဖောက် ၀င်ရောက်နိုင်ရန်အတွက် အကောင်အထည်ဖော်လျက်ရှိသည်။",
                "title_4" => "ထိုင်းနိုင်ငံ", "image_4" => "images/thailand.png", "content_4" => "ကျွန်ုပ်တို့နိုင်ငံ၏ ရွေ့ပြောင်းလုပ်သား အများစု အလုပ်သွားရောက်လုပ်ကိုင်လျက်ရှိသည့် ထိုင်းနိုင်ငံသည် ကျွန်ုပ်တို့ မြန်မာနိုင်ငံ နှင့် နယ်နိမိတ်ချင်း ထိစပ်နေသည့် နိုင်ငံတစ်နိုင်ငံဖြစ်သည်။ သယ်ယူပို့ဆောင်ရေး လမ်းကြောင်း အဆင်ပြေချောမွေ့သည့်အပြင် နှစ်နိုင်ငံဆက်ဆံရေးအရ ကျွန်ုပ်တို့ ကုမ္ပဏီ၏ ပထမဆုံး ပြည်ပစျေးကွက်တစ်ခု ဖော်ဆောင်ရန် အချက်ချာကျသော နိုင်ငံလည်းဖြစ်သည်။",
                "title_5" => "မလေးရှားနိုင်ငံ", "image_5" => "images/malaysia.png", "content_5" => "ကျွန်ုပ်တို့ကုမ္ပဏီ၏ ထုတ်ကုန်စျေးကွက်တစ်ခုဖော်ဆောင်ရန် လျာထားချက်တွင် မလေးရှားနိုင်ငံလည်း ပါ၀င်သည်။ လူဦးရေ အချိုးအစားအရ ထိုင်းနိုင်ငံ နှင့် မြန်မာနိုင်ငံထက် လူဦးရေ နည်းပါးသော်လည်း သန့်ရှင်းလတ်ဆတ်ပြီး အရည်အသွေးမြင့် သစ်သီး၀လံ နှင့် ဟင်းသီးဟင်းရွက်များ စားသုံးမှု အချက် အလက်များအရ မလေးရှားနိုင်ငံသည် ကျွန်ုပ်တို့ကုမ္ပဏီ၏ အချက်အချာကျသော ပြည်ပစျေးကွက်တစ်ခု ဖြစ်လာနိုင်သည်။",
                "title_6" => "စင်္ကာပူနိုင်ငံ", "image_6" => "images/singapore.png", "content_6" => "ဒေသတွင်း စီးပွားရေးအချက်အချာဖြစ်သော စင်္ကာပူနိုင်ငံကိုလည်း ကျွန်ုပ်တို့ ကုမ္ပဏီ၏ ထုတ်ကုန်များ ဖြန့်ချီရန် အတွက် ရည်ရွယ်ထားပါသည်။ စင်္ကာပူနိုင်ငံ၏ လူနေမှုအဆင့်အတန်း နှင့် ၀င်ငွေအချိုးအစားအရ လိုအပ်ချက် မြင့်မားသော ထုတ်ကုန်အရည်အသွေး သတ်မှတ်ချက်များကို ကျွန်ုပ်တို့ကုမ္ပဏီ၏ ထုတ်ကုန်များမှ ပံ့ပိုးပေးနိုင်ရန် နှင့် စျေးကွက်တစ်ခုဖော်ဆောင်နိုင်ရန် ရည်ရွယ်ထားပါသည်။",
                "title_7" => "ကျွန်ုပ်တို့မိတ်ဖက်များအကြောင်း", "image_m_1" => "images/profile_mobile1.png", "image_7" => "images/profile2.png", "content_7" => "ကျွန်ုပ်တို့ကုမ္ပဏီ နှင့် မိတ်ဖက်အဖွဲ့အစည်းများသည် အပြန်အလှန်ယုံကြည်မှု၊ မျှဝေထားသော ရည်ရွယ်ချက် အခန်းကဏ္ဍများ နှင့် တာဝန်များကို ရှင်းလင်းစွာ နားလည်မှုအပေါ်တွင် တည်ဆောက်ထားသည်။ ကျွန်ုပ်တို့သည် မိတ်ဖက်အဖွဲ့အစည်းများနှင့်အတူ အရင်းအမြစ်များ၊ ကျွမ်းကျင်မှုများဖြင့် ဘုံရည်မှန်းချက်တစ်ခုဆီသို့ ကြိုးစား အားထုတ်မှုများကို ပေါင်းစပ်ခြင်းဖြင့် အပြန်အလှန် အကျိုးခံစားခွင့်များ ရရှိစေရန် ရည်မှန်းထားသည်။ ကျွန်ုပ်တို့၏ လုပ်ငန်းခွင်တွင် မိတ်ဖက်များအတွက် ဆန်းသစ်တီထွင်မှု၊ ပိုမိုကျယ်ပြန့်သော စျေးကွက်များ နှင့် စွမ်းဆောင်ရည်မြှင့်တင်ရန် နည်းပညာများဖြင့်ပံ့ပိုးပေးနိုင်ပါသည်။ အောင်မြင်သောလက်တွဲဖော်ကို ပြုစုပျိုးထောင် ရာတွင် စဥ်ဆက်မပြတ်ကြိုးစားအားထုတ်မှု၊ နားလည်မှုနှင့် လိုက်လျောညီထွေရှိမှုတို့ပါဝင်သည်။ နစ်နာဆုံးရှုံးမှုဒဏ်ကို ခံနိုင်ရည်ရှိသော မိတ်ဖက်များ နှင့်အတူ အောင်ပွဲများကို အတူတကွ ဆင်နွှဲခြင်းဖြင့် ကျွန်ုပ်တို့သည် ခံနိုင်ရည်ရှိမှုကို ပိုမိုတည်ဆောက်နိုင်ပြီး ရေရှည်အောင်မြင်မှုကို သေချာစေပါသည်။",
                "title_8" => "Our Deals",
                "image_8" => "images/Logo1.png",
                "image_9" => "images/Logo2.png",
                "image_10" => "images/Logo3.png",
                "image_11" => "images/Logo4.png",
                "image_12" => "images/Logo5.png",
                "title_9" => "အအေးခန်းချိတ်ဆက်မှု", "image_m_2" => "images/profile_mobile2.png", "image_13" => "images/profile4.png", "content_9" => "ကျွန်ုပ်တို့အအေးခန်းချိတ်ဆက်မှု၏အဓိကပန်းတိုင်မှာ အသီးအနှံနှင့် ဟင်းသီးဟင်းရွက်များကို ရိတ်သိမ်းချိန်မှ စျေးကွက် ဖြန့်ဖြူးခြင်းအထိ ထိခိုက်ပျက်စီးမှု နည်းပါးစေရန် အေးခဲခြင်း (သို့မဟုတ်) အအေးခံခြင်းလုပ်ငန်းစဥ် အတွင်း သင့်လျော်သောအပူချိန်တွင်ထားရှိပြီး အရည်အသွေးမလျော့ကျရန် အဓိကထား လုပ်ဆောင်သည်။ ဤအအေး ခန်းကွင်းဆက်သည် သတ်မှတ်ထားသော အပူချိန်အတိုင်းအတာကို ထိန်းသိမ်းပေးကာ အသီးအနှံနှင့် ဟင်းသီးဟင်းရွက်များ၏ သိုလှောင်မှုသက်တမ်းကို ကြာရှည်ခံစေသည့် လုပ်ငန်းစဥ်တစ်ခုဖြစ်ပါဝင်သည်။ သစ်သီးဝလံနှင့် ဟင်းသီးဟင်းရွက်မျိုးစုံတို့သည် ဖွဲ့စည်းပုံ၊ ဇာစ်မြစ် နှင့် ရိတ်သိမ်းခြင်းတို့မှာ ကွဲပြားခြားနားမှုရှိ သည့်အတွက် အပူချိန်၊ စိုထိုင်းဆ၊ အလင်းရောင်ပမာဏ နှင့် လေဝင်လေထွက်နှုန်းတို့ကို ထိန်းညှိပေးရန် လိုအပ် ပါသည်။ ကျွန်ုပ်တို့၏အ‌အေးခန်းချိတ်ဆက်မှုသည် ထုတ်ကုန်များ၏ အရည်အသွေးစံနှုန်းကို ထိန်းသိမ်းထားစဥ်တွင် ပုံသဏ္ဍာန်ပြောင်းလဲခြင်း၊ မညီမညာမှည့်ခြင်း နှင့် ဘက်တီးရီးယား များကြောင့် ပျက်စီးခြင်းစသည့် လက္ခဏာများ ကို ရှောင်ရှားရန် အအေးခန်းထရပ်ကားများကို အသုံးပြုသည်။",
                "title_10" => "ပို့ဆောင်ရေး", "image_m_3" => "images/profile_mobile3.png", "image_14" => "images/profile3.png", "content_10" => "ကုန်ပစ္စည်းများကို လေကြောင်းလမ်း၊ ရေကြောင်းလမ်း၊ ကုန်းလမ်းများဖြင့် သယ်ယူပို့ဆောင်ပေးလျက်ရှိသည်။ သယ်ယူပို့ဆောင်ရေးပုံစံ ကွဲပြားသောကြောင့် ကုန်ပစ္စည်းများ သယ်ယူရာတွင်လည်း ကွဲပြားခြားနားမှုများရှိသည်။ ကျွန်ုပ်တို့ကုမ္ပဏီ၏ အရောင်းမြှင့်တင်ရေးနိယာမတစ်ခုမှာ သယ်ယူပို့ဆောင်ရေးအတွက် အနည်းဆုံးအမြတ်အစွန်း ကိုသာပေးချေရန်ဖြစ်သည်။ ကုန်ပစ္စည်းများ ထိခိုက်ဆုံးရှုူံးမှုမရှိစေရန် နှင့် ဘေးအန္တရာယ် ကင်းရှင်းစေရန် နောက်ဆုံးပေါ် နည်းပညာစံနှုန်းအတိုင်း တပ်ဆင်ထုတ်လုပ်ထားသော အအေးခန်းကုန်တင်ယာဥ်များကို အသုံး ပြုသည်။ ကျွန်ုပ်တို့၏ ထောက်ပံ့ရေးကွင်းဆက်နှင့် ထောက်ပံ့ပို့ဆောင်ရေး စီမံခန့်ခွဲမှု မူဘောင်သည် လုပ်ငန်းလည်ပတ်မှုတွင် သာလွန်ကောင်းမွန်စေရန်၊ ဖောက်သည်များ၏ မျှော်လင့်ချက်များကို ပြည့်မီစေရန်နှင့် ပြောင်းလဲနေသော စီးပွားရေးပတ်ဝန်းကျင်နှင့် လိုက်လျောညီထွေဖြစ်အောင် ဒီဇိုင်းထုတ်ထားပါသည်။",
                "title_11" => "သိုလှောင်စနစ်", "image_m_4" => "images/profile_mobile4.png", "image_15" => "images/warehouse.png", "content_11" => "ကျွန်ုပ်တို့၏သိုလှောင်ရုံစနစ်ကို ကုန်ပစ္စည်းတင်ပို့ခြင်း၊ လက်ခံခြင်း၊ သိုလှောင်ခြင်း နှင့် ယာယီထိန်းသိမ်း ထားသိုခြင်း စသော လုပ်ငန်းစဥ်များဖြင့် ကုန်စည်သိုလှောင်ရုံအား စီမံခန့်ခွဲထိန်းချုပ်ထားပါသည်။ ကျွန်ုပ်တို့၏ ကုန်စည်သိုလှောင်ရုံ စီမံခန့်ခွဲမှုစနစ်သည် ကုန်စည်သိုလှောင်ရုံလုပ်ငန်းများအား အချိန်တိုတို နှင့် အကျိုးရှိစွာ ထိထိရောက်ရောက် အကောင်းဆုံး လည်ပတ်လုပ်ဆောင်စေရန် ရည်ရွယ်ပါသည်။ ကြိုတင်မမြင်နိုင်သော လွဲမှားမှုများနှင့် အခြားပြဿနာများကို အကောင်းဆုံးဖြေရှင်းနိုင်ရန် သမားရိုးကျ လုပ်ကိုင်ရသည့် လုပ်ငန်းစဥ်များမှ အလိုအလျောက်စနစ်သို့ ပြုလုပ်ပေးသည့် ကိုယ်ပိုင်နည်းပညာမြှင့်ဆော့ဖ်ဝဲကို အသုံးပြုပါမည်။ သိုလှောင်မှုဆိုင်ရာလုပ်ထုံးလုပ်နည်းများအတွက် ဗဟိုချုပ်ကိုင်မှုစနစ်သည် အရှိန်မြှင့်ပြီး ထိရောက်မှုကို တိုးတက်စေသည်။ ထုတ်ကုန်အမျိုးအစားတစ်ခုချင်းအတွက် သက်ဆိုင်ရာ အပူချိန် ချိန်ညှိပေးပြီး ထိခိုက်ပျက်စီးဆုံးရူံးမှု နည်းပါးစေရန် အလိုအလျောက်အပူထိန်းစနစ်သို့ ပြောင်းလဲခြင်းသည် လက်ကားရောင်းချသူများ၊ ကုန်ပစ္စည်းဖြန့်ဖြူးသူများ၊ ကုန်သည်များ နှင့် လက်လီရောင်းချသူများ အတွက် အကျိုးကျေးဇူးများစွာ ရရှိစေမည်ဖြစ်ပါသည်။",

            ],
        ];
        foreach ($data as $value) {
            ProfilePageMM::updateOrCreate($value);
        }
    }
}
