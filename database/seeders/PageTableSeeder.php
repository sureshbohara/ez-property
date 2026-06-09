<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Page;

class PageTableSeeder extends Seeder
{
    public function run(): void
    {
        $pages = [
            [
                'title' => 'About Us',
                'slug' => 'about-us',
                'icon' => 'bi-info-circle',
                'short_content' => 'Learn about our company, mission, and the team behind our success.',
                'content' => '<h2>Welcome to Our Company</h2><p>Write your about us content here...</p>',
                'meta_title' => 'About Us',
                'meta_description' => 'Learn more about our company, mission, and values.',
                'show_in_menu' => true,
                'show_in_footer' => true,
                'is_featured' => true,
                'order_level' => 1,
            ],
            [
                'title' => 'Contact Us',
                'slug' => 'contact-us',
                'icon' => 'bi-envelope',
                'short_content' => 'Get in touch with us for inquiries, support, or partnership opportunities.',
                'content' => '<h2>Get in Touch</h2><p>Contact information here...</p>',
                'meta_title' => 'Contact Us',
                'meta_description' => 'Contact us for inquiries and support.',
                'show_in_menu' => true,
                'show_in_footer' => true,
                'order_level' => 2,
            ],
            [
                'title' => 'Terms and Conditions',
                'slug' => 'terms-and-conditions',
                'icon' => 'bi-file-earmark-text',
                'short_content' => 'Read our terms of service and usage guidelines.',
                'content' => '<h2>Terms of Service</h2><p>Your terms and conditions content...</p>',
                'meta_title' => 'Terms and Conditions',
                'meta_description' => 'Read our terms and conditions.',
                'show_in_footer' => true,
                'order_level' => 3,
            ],
            [
                'title' => 'Privacy Policy',
                'slug' => 'privacy-policy',
                'icon' => 'bi-shield-check',
                'short_content' => 'Learn how we protect and handle your personal information.',
                'content' => '<h2>Privacy Policy</h2><p>Your privacy policy content...</p>',
                'meta_title' => 'Privacy Policy',
                'meta_description' => 'Learn about how we protect your privacy.',
                'show_in_footer' => true,
                'order_level' => 4,
            ],
        ];

        foreach ($pages as $pageData) {
            Page::updateOrCreate(['slug' => $pageData['slug']], $pageData);
        }
    }
}