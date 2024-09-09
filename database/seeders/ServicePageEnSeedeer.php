<?php

namespace Database\Seeders;

use App\Models\ServicePage;
use Illuminate\Database\Seeder;

class ServicePageEnSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "title_1" => "Our Services",
                "title_2" => "What We Serve", "content_2" => "From farm-fresh produce to seasonal vegetables, we provide to fulfill your daily essentials and essential nutrients for health. High-quality, clean, and fresh organic crops, seasonal crops, and crops exported from abroad can be chosen and purchased at reasonable prices from chain stores also various townships, and online purchases.",
                "title_3" => "FRESH PRODUCTS", "image_3" => "images/ourservices-1.png", "content_3" => "We procure and supply a diverse array of seasonal fruits and vegetables sourced directly from local farms and trusted suppliers, allowing you to choose only the best products.",
                "title_4" => "CUSTOMIZE ORDER", "image_4" => "images/ourservices-2.png", "content_4" => "It is provided as an easy and convenient online shopping system for customers to search and choose freely, restaurants, grocery stores, whether you need bulk for events or events, custom orders to suit your requirements.",
                "title_5" => "QUALITY POLICY", "image_5" => "images/ourservices-3.png", "content_5" => "Quality is strictly checked by industry standards and certified by experts and regulatory bodies to ensure that every product meets our high-quality standards before reaching our customers.",
                "title_6" => "Our Application", "image_6" => "images/about3-5.png", "content_6" => "Our application has a variety of fruits, vegetables, organic crops, and foreign products that can be accessed and chosen to purchase. Based on users' preferences and browsing history, improved product quality can be given to ratings, creating a more convenient shopping experience. Users receive alerts about sales discounts and promotions, increasing their opportunity to purchase products at reasonable prices. It is featured to give shoppers confidence by allowing users to know their orders in real time and view their purchase history within the app at any time. Find the download our FreshMoe shopping app on the Google Play store and App Store, and start using it.",
                "title_7" => "Retail Shop", "image_7" => "images/RetailShop.png", "content_7" => "Shopping at our retail store is to get our customers the highest quality fruits and vegetables, excellent customer service, and a shopping experience that is both enjoyable and convenient. Our store layout is systematically designed to make product selection easy and your shopping experience quick and easy. Customer satisfaction is our top priority. At our retail shop, from seasonal fruits to everyday vegetables, caters to your cooking needs with a wide selection of their associated products. For those who love organic produce, you can buy a wide variety of organic crops and vegetables that are free of chemical pesticides and fertilizers and help you live a healthy life. To make it convenient for our customers to buy from our stores, we have made it possible to make payments in cash as well as through an online payment system.",
            ],
        ];
        foreach ($data as $value) {
            ServicePage::updateOrCreate($value);
        }
    }
}
