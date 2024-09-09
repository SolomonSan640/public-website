<?php

namespace Database\Seeders;

use App\Models\HomePage;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class HomePageEnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "slider_title_1" => "Quick Delivery", "slider_image_1" => "images/slider1.jpg", "slider_content_1" => "Consumers can easily choose and purchase our products, and they will be delivered to their homes in the quickest amount of time without sacrificing the products' highest quality and freshness.",
                "slider_title_2" => "Quick Delivery", "slider_image_2" => "images/slider1.jpg", "slider_content_2" => "Consumers can easily choose and purchase our products, and they will be delivered to their homes in the quickest amount of time without sacrificing the products' highest quality and freshness.",
                "slider_title_3" => "Quick Delivery", "slider_image_3" => "images/slider1.jpg", "slider_content_3" => "Consumers can easily choose and purchase our products, and they will be delivered to their homes in the quickest amount of time without sacrificing the products' highest quality and freshness.",
                "slider_title_4" => "Quick Delivery", "slider_image_4" => "images/slider1.jpg", "slider_content_4" => "Consumers can easily choose and purchase our products, and they will be delivered to their homes in the quickest amount of time without sacrificing the products' highest quality and freshness.",
                "slider_title_5" => "Quick Delivery", "slider_image_5" => "images/slider1.jpg", "slider_content_5" => "Consumers can easily choose and purchase our products, and they will be delivered to their homes in the quickest amount of time without sacrificing the products' highest quality and freshness.",
                "title_2" => "Why Choose Us",
                "title_3" => "Fresh is Best", "image_3" => "images/icon_check.png", "content_3" => "Quality control measures are implemented at every stage of the farm-to-market process to ensure that only fresh, tasty fruits reach customers.",
                "title_4" => "Easy to Buy", "image_4" => "images/icon_car.png", "content_4" => "Products can be easily selected and purchased using our retail stores and shopping applications.",
                "title_5" => "Quality is Best", "image_5" => "images/icon_phone.png", "content_5" => "We will be paying greater attention to raising product quality standards and producing chemical-free products.",
                "title_6" => "Service is Best", "image_6" => "images/icon_heart.png", "content_6" => "We strive to deliver products of excellent quality through accurate, rapid, and dependable home delivery systems, as well as the finest services possible.",
                "title_7" => "Healthy Food", "image_7" => "images/icon_fruit.png", "content_7" => "Distributes and sells high-quality crops that are nutritious, food-safe, and healthy to consumers.",
                "title_8" => "No Quantity Limit", "image_8" => "images/icon_cart.png", "content_8" => "Consumers can order the custom quantity of products they need and get them within the limited time they want to arrive.",
                "title_9" => "What We Do", "image_9" => "images/about1.png", "image_m_1" => "images/aboutMobile.png", "content_9" => "We are making great efforts to ensure that customers receive safe and healthy products, that standards for product quality are not lowered, and allow people of all classes to freely choose and buy. As a leading provider in this industry, we always work to provide more innovative services, moredistribution of higher quality fruits and vegetables, and reliability.",
                "title_10" => "Our Quality Fresh Food", "image_10" => "images/about2-1.png", "content_10" => "From seasonal fruit and vegetable produce, from juicy strawberries to crisp lettuce, each product is carefully selected and harvested at the peak of its development, ensuring the full flavor and nutrition of each product. Working directly with local farmers who share our passion for sustainable organic farming techniques helps support our communities and brings you only the freshest and most delicious produce. Facilitated processes, solid production chains, and the implementation of sustainable agriculture techniques are at the heart of our operations, allowing future generations to live a healthier lifestyle.",
                "title_11" => "Our Organic Farm", "image_11" => "images/about44.png", "image_m_2" => "images/aboutMobile2.png", "content_11" => "Our organic farming is healthy for food and soil quality, and it is an agricultural industry that aims for economic and social sustainability based on food security, with crop production prioritizing plants and the environment. Our organic farm avoids using which is dangerous to the health chemical fertilizers and pesticides to improve soil quality and organic soil. Enhancing the organic matter in the soil aids in the absorption and storage of carbon and other nutrients, as well as the resistance to pests and diseases for the growth of nutritious crops. Our organic farm's fundamental principle is to grow organically from the time the soil is planted until the consumer, in order to protect the health of the soil, plants, people, animals, and other living things.",
            ],
        ];
        foreach ($data as $value) {
            HomePage::updateOrCreate($value);
        }
    }
}
