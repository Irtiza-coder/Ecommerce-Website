<?php

namespace Database\Seeders;

use App\Models\Admin;
use App\Models\Category;
use App\Models\HomeContent;
use App\Models\Product;
use App\Models\Testmonials;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Admin Account
        Admin::updateOrCreate(
            ['username' => 'admin'],
            [
                'password' => Hash::make('123456'),
            ]
        );

        // 2. Seed Categories
        $categories = [
            ['id' => 1, 'name' => 'Cookware', 'slug' => 'cookware'],
            ['id' => 2, 'name' => 'Bakeware', 'slug' => 'bakeware'],
            ['id' => 3, 'name' => 'Cutlery', 'slug' => 'cutlery'],
            ['id' => 4, 'name' => 'Tableware', 'slug' => 'tableware'],
            ['id' => 5, 'name' => 'Kitchen Tools', 'slug' => 'kitchen-tools'],
            ['id' => 6, 'name' => 'Storage', 'slug' => 'storage'],
            ['id' => 7, 'name' => 'Electronics', 'slug' => 'electronics'],
            ['id' => 8, 'name' => 'Bedroom', 'slug' => 'bedroom'],
        ];

        foreach ($categories as $cat) {
            Category::updateOrCreate(['id' => $cat['id']], $cat);
        }

        // 3. Seed Products from JSON
        $productsJsonPath = __DIR__ . '/products_export.json';
        if (file_exists($productsJsonPath)) {
            $products = json_decode(file_get_contents($productsJsonPath), true);
            foreach ($products as $item) {
                Product::updateOrCreate(
                    ['slug' => $item['slug']],
                    $item
                );
            }
        }

        // 4. Seed HomeContent
        $homeContents = [
            [
                'section' => 'hero',
                'title' => null,
                'subtitle' => null,
                'description' => null,
                'image' => null,
            ],
            [
                'section' => 'welcome',
                'title' => 'CREST&CLOVE',
                'subtitle' => 'Welcome To',
                'description' => 'Premium kitchenware crafted for everyday cooking — built to last, designed to impress.',
                'image' => null,
            ],
            [
                'section' => 'feature1',
                'title' => 'Where Design Meets Precision',
                'subtitle' => '',
                'description' => 'Every piece is shaped with precision, blending function with timeless design.',
                'image' => null,
            ],
            [
                'section' => 'feature2',
                'title' => "The Essential Chef's Companion",
                'subtitle' => '',
                'description' => 'From prep to plate, our tools are made to handle it all — without slowing you down.',
                'image' => null,
            ],
            [
                'section' => 'brand_banner',
                'title' => 'Crest & Clove',
                'subtitle' => null,
                'description' => null,
                'image' => null,
            ],
            [
                'section' => 'shop_section',
                'title' => 'Our Shop',
                'subtitle' => 'Explore our best-selling kitchenware, chosen for quality and everyday durability.',
                'description' => '',
                'image' => null,
            ],
            [
                'section' => 'catalogue',
                'title' => 'Browse Our 2026 Catalogue',
                'subtitle' => '',
                'description' => 'Curated cookware and culinary essentials engineered for passionate home chefs and culinary experts.',
                'image' => null,
            ],
            [
                'section' => 'testimonials',
                'title' => 'Our Happy Customers',
                'subtitle' => "Real feedback from customers who've made Crest & Clove part of their kitchen.",
                'description' => '',
                'image' => null,
            ],
            [
                'section' => 'footer_contact',
                'title' => 'Contact Us',
                'subtitle' => "Have a question? We're happy to help.",
                'description' => 'support@crestandclove.com|+92 300 1234567',
                'image' => null,
            ],
            [
                'section' => 'footer_subscribe',
                'title' => 'Subscribe',
                'subtitle' => 'Sign up for our newsletter to get updates and exclusive culinary guides',
                'description' => null,
                'image' => null,
            ],
            [
                'section' => 'footer_copyright',
                'title' => '© 2026, All Rights Reserved',
                'subtitle' => '',
                'description' => '',
                'image' => null,
            ],
            [
                'section' => 'about_story',
                'title' => 'Our Story',
                'subtitle' => 'Founded with a deep passion for culinary excellence and fine craft, Crest & Clove brings timeless kitchenware to passionate cooks and home chefs worldwide. Every piece is sculpted with precision, designed to endure everyday cooking, and crafted to elevate your tabletop.',
                'description' => 'Crafted with premium materials, refined by master artisans, and tested for performance in modern kitchens.',
                'image' => null,
            ],
            [
                'section' => 'top_bar',
                'title' => 'FREE SHIPPING IN 🇺🇸 FOR THE LOWER 48 ON ORDERS OVER $200.00',
                'subtitle' => '+92 300 1234567',
                'description' => "Pakistan\r\nUSA",
                'image' => null,
            ],
        ];

        foreach ($homeContents as $hc) {
            HomeContent::updateOrCreate(['section' => $hc['section']], $hc);
        }

        // 5. Seed Testimonials
        $testimonials = [
            [
                'name' => 'Irtiza',
                'role' => 'Senior Director',
                'review' => 'The cookware set exceeded all my expectations. The craftsmanship is outstanding, heating is perfectly even, and the pieces look stunning on open kitchen shelves. Truly timeless quality!',
                'rating' => 5,
                'image' => 'testimonials/irtiza.png',
                'status' => 1,
            ],
            [
                'name' => 'Bilal Ahmed',
                'role' => 'Head Chef, Lahore',
                'review' => 'Cookware ki quality bohot zabardast hai. Heat retention bilkul perfect hai aur heavy-bottom design cooking ko bohot aasan banata hai. Restaurant aur home cooking dono ke liye best choice hai!',
                'rating' => 5,
                'image' => 'testimonials/bilal-ahmed.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Ayesha Khan',
                'role' => 'Food Stylist & Baker, Karachi',
                'review' => 'Truly premium quality kitchenware! Serving dishes aur pans ka aesthetic look open kitchen shelves par bohot khubsurat lagta hai. Packaging aur delivery bhi on time thi.',
                'rating' => 5,
                'image' => 'testimonials/ayesha-khan.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Hamza Tariq',
                'role' => 'Interior Designer, Islamabad',
                'review' => 'Handcrafted kitchen accessories aur cookware bohot elegant hain. Material solid hai aur durability ka andaza pehli baar use karte hi ho jata hai. Highly satisfied with my purchase.',
                'rating' => 4,
                'image' => 'testimonials/hamza-tariq.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Fatima Noor',
                'role' => 'Verified Buyer, Rawalpindi',
                'review' => 'Maine gift set order kiya tha family ke liye aur sabko bohot pasand aya. Non-stick finish aur weight bilkul premium standard ka hai. Definitely ordering again!',
                'rating' => 5,
                'image' => 'testimonials/fatima-noor.jpg',
                'status' => 1,
            ],
            [
                'name' => 'Usman Ali',
                'role' => 'Culinary Enthusiast, Faisalabad',
                'review' => 'Outstanding craftsmanship! Market mein aisi finishing aur durable metal quality rare milti hai. Value for money product hai.',
                'rating' => 5,
                'image' => 'testimonials/usman-ali.jpg',
                'status' => 1,
            ],
        ];

        foreach ($testimonials as $t) {
            Testmonials::updateOrCreate(['name' => $t['name']], $t);
        }
    }
}
