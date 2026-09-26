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
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed aliqua. Ut enim ad minim veniam.',
                'image' => null,
            ],
            [
                'section' => 'feature1',
                'title' => 'Where Design Meets Precision',
                'subtitle' => '',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.',
                'image' => null,
            ],
            [
                'section' => 'feature2',
                'title' => "The Essential Chef's Companion",
                'subtitle' => '',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation.',
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
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'description' => '',
                'image' => null,
            ],
            [
                'section' => 'catalogue',
                'title' => 'Browse Our 2026 Catalogue',
                'subtitle' => '',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => null,
            ],
            [
                'section' => 'testimonials',
                'title' => 'Our Happy Customers',
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'description' => '',
                'image' => null,
            ],
            [
                'section' => 'footer_contact',
                'title' => 'Contact Us',
                'subtitle' => 'Lorem ipsum dolor sit amet consectetur adipisicing elit.',
                'description' => 'loremipsum@gmail.com|(123)-456-7890',
                'image' => null,
            ],
            [
                'section' => 'footer_subscribe',
                'title' => 'Subscribe',
                'subtitle' => 'Sign up for our newsletter to get up-to-date from u',
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
                'subtitle' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo.',
                'description' => 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.',
                'image' => null,
            ],
            [
                'section' => 'top_bar',
                'title' => 'FREE SHIPPING IN 🇺🇸 FOR THE LOWER 48 ON ORDERS OVER $200.00',
                'subtitle' => '123 456 7890',
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
                'rating' => 3,
                'image' => 'Testimonials/HX1wzXQmzgUnPTdFzHD8YZ0ZWsmb0E0YhlEkohSL.png',
                'status' => 1,
            ],
            [
                'name' => 'Bilal Ahmed',
                'role' => 'Head Chef, Lahore',
                'review' => 'Cookware ki quality bohot zabardast hai. Heat retention bilkul perfect hai aur heavy-bottom design cooking ko bohot aasan banata hai. Restaurant aur home cooking dono ke liye best choice hai!',
                'rating' => 5,
                'image' => null,
                'status' => 0,
            ],
            [
                'name' => 'Ayesha Khan',
                'role' => 'Food Stylist & Baker, Karachi',
                'review' => 'Truly premium quality kitchenware! Serving dishes aur pans ka aesthetic look open kitchen shelves par bohot khubsurat lagta hai. Packaging aur delivery bhi on time thi.',
                'rating' => 2,
                'image' => 'Testimonials/o12ILpNPARVHXS5l0mXpHgEzRLSYEzcrrFwPRxo0.png',
                'status' => 1,
            ],
            [
                'name' => 'Hamza Tariq',
                'role' => 'Interior Designer, Islamabad',
                'review' => 'Handcrafted kitchen accessories aur cookware bohot elegant hain. Material solid hai aur durability ka andaza pehli baar use karte hi ho jata hai. Highly satisfied with my purchase.',
                'rating' => 4,
                'image' => null,
                'status' => 1,
            ],
            [
                'name' => 'Fatima Noor',
                'role' => 'Verified Buyer, Rawalpindi',
                'review' => 'Maine gift set order kiya tha family ke liye aur sabko bohot pasand aya. Non-stick finish aur weight bilkul premium standard ka hai. Definitely ordering again!',
                'rating' => 5,
                'image' => 'Testimonials/e0U0etdTiyvzW1J2JGNw1vMbWFyqDD1xb8SnawKy.png',
                'status' => 0,
            ],
            [
                'name' => 'Usman Ali',
                'role' => 'Culinary Enthusiast, Faisalabad',
                'review' => 'Outstanding craftsmanship! Market mein aisi finishing aur durable metal quality rare milti hai. Value for money product hai.',
                'rating' => 5,
                'image' => null,
                'status' => 1,
            ],
        ];

        foreach ($testimonials as $t) {
            Testmonials::updateOrCreate(['name' => $t['name']], $t);
        }
    }
}
