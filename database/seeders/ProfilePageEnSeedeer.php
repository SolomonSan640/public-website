<?php

namespace Database\Seeders;

use App\Models\ProfilePage;
use Illuminate\Database\Seeder;

class ProfilePageEnSeedeer extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $data = [
            [
                "title_1" => "Profile",
                "title_2" => "Client and Future Plans", "image_2" => "images/profile1.png", "content_2" => "Our products are distributed from five-star hotel groups to local retailers and restaurants, delivering the freshest, most nutritious fruits and vegetables at the right price and understanding the value of our products. Based on the customers' organizations and various fields of business, every fruit and vegetable they receive is processed to meet quality standards and ensure customer satisfaction. Our future aspirations are built on continuous innovation. Better variety to meet evolving client preferences; we intend to invest resources in research and development to introduce organic selections and packaging solutions.",
                "title_3" => "Target Market", "content_3" => "Our company is in the process of expanding operations to penetrate both the domestic market and the product markets of neighboring countries.",
                "title_4" => "Thailand", "image_4" => "images/thailand.png", "content_4" => "Thailand, where most of our country's migrant workers work, is a country bordering Myanmar. In addition to the convenient transportation route, it is also a key country to develop our company's first overseas market in terms of bilateral relations.",
                "title_5" => "Malaysia", "image_5" => "images/malaysia.png", "content_5" => "Malaysia is also included in our company's target to develop a product market. In terms of population ratio, Malaysia has a smaller population than Thailand and Myanmar, but according to the consumption data of clean, fresh, and high-quality fruits and vegetables.",
                "title_6" => "Singapore", "image_6" => "images/singapore.png", "content_6" => "Singapore, which is a regional economic hub, is also intended to distribute our company's products. Our company's products aim to develop a market and support the high demand for product quality according to Singapore's living standards and income ratio.",
                "title_7" => "About Our Partnership", "image_m_1" => "images/profile_mobile1.png", "image_7" => "images/profile2.png", "content_7" => "Our company and partner organizations are mutual trust, shared purpose is built on a clear understanding of roles and responsibilities. It aims to achieve mutual benefits by combining resources and skills towards a common goal with our partner organization. We can support our business partners with technology to drive innovation, develop the market, and improve performance. Cultivating a successful partnership involves constant effort, understanding, and flexibility. By celebrating victories together with colleagues who are resilient to hurt or loss and consistently investing, we can build resilience and ensure long-term success.",
                "title_8" => "Our Deals",
                "image_8" => "images/Logo1.png",
                "image_9" => "images/Logo2.png",
                "image_10" => "images/Logo3.png",
                "image_11" => "images/Logo4.png",
                "image_12" => "images/Logo5.png",
                "title_9" => "Our Cold Chain", "image_m_2" => "images/profile_mobile2.png", "image_13" => "images/profile4.png", "content_9" => "Our cold chain's primary goal is to preserve the quality of fruits and vegetables while minimizing damage from harvest to market distribution by freezing or chilling them at the appropriate temperature. This cold chain involves a process that maintains a given temperature range, extending the shelf life of fruits and vegetables. A variety of fruits and vegetables have variations in structure, origin, and harvest, so it is necessary to regulate temperature, humidity, quantity of illumination, and airflow. Our cold chain employs refrigerated trucks to avoid symptoms such as deformation, uneven ripening, and bacterial spoilage while also maintaining the product's quality standards.",
                "title_10" => "Transportation", "image_m_3" => "images/profile_mobile3.png", "image_14" => "images/profile3.png", "content_10" => "Goods are being transported by Air Freight, Marine Ways, and Road Freight. There are variances in the transportation of commodities due to different modes of transportation. One of the market promotion principles of our company is to pay only the minimum profit for transportation. Refrigerated trucks equipped with the newest technological standards are used to ensure that the products are not damaged and are safe. Our supply chain and logistics management framework is designed to achieve operational excellence, meet customer expectations, and adapt to the changing business environment.",
                "title_11" => "Warehouse", "image_m_4" => "images/profile_mobile4.png", "image_15" => "images/warehouse.png", "content_11" => "The warehouse system is managed and controlled by the operations of goods shipment, receiving, storage, and temporary storage. Our warehouse management system is intended to make warehouse operations run efficiently and in the shortest possible time. We will use our own cutting-edge, technologically enhanced software to automate conventional work procedures to best address unforeseen faults and other issues. A centralized control system for warehousing procedures expedites and improves efficiency. A shift to automatic temperature control that adjusts the relevant temperature for each product type and minimizes damage will bring many benefits to wholesalers, distributors, traders, and retailers.",

            ],
        ];
        foreach ($data as $value) {
            ProfilePage::updateOrCreate($value);
        }
    }
}
