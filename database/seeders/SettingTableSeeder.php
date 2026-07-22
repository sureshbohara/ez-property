<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Seeder;

class SettingTableSeeder extends Seeder
{
    public function run()
    {
        Setting::updateOrCreate(
            ['id' => 1],
            [
                // --- General Info ---
                'system_name' => 'Ez Property',
                'email' => 'support@ezproperty.com',
                'extra_email' => 'booking@ezproperty.com',
                'phone' => '+977-1-XXXXXXX',
                'extra_phone' => '+977-98XXXXXXXX', 
                'address' => 'Kathmandu, Nepal',
                'opening_hr' => 'Sun - Fri: 9AM - 6PM',
                'work_hours' => 'Your gateway to authentic Nepali hospitality.',
                'footer_copyright' => '© ' . date('Y') . ' Ez Property. All Rights Reserved.',
                'google_map' => 'https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3532.0284987496536!2d85.32405831506056!3d27.717245933190117!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x39eb19a8b5b88e43%3A0x6d64b8f8b8b8b8b8!2sKathmandu!5e0!3m2!1sen!2snp!4v1620000000000', 

                // --- Social Links ---
                'facebook' => 'https://facebook.com/ezproperty',
                'twitter'  => 'https://twitter.com/ezproperty',
                'linkedin' => 'https://linkedin.com/company/ezproperty',
                'instagram'=> 'https://instagram.com/ezproperty',
                'youtube'  => null,
                'google'   => null,
                'yelp'     => null,

                // --- Media ---
                'favicon' => null,
                'logo'    => null,
                'loader'  => null,
                'footer_gateway_img' => null,
                'bg_image' => null,
                'breadcrumb' => null,
                'image1'   => null, 
                'image2'   => null,

                // --- SEO Meta Data ---
                'meta_author' => 'Ez Property',
                'meta_title'  => 'Ez Property | Find Premium Homestays & Rentals in Nepal',
                'meta_keywords' => 'nepal property, homestay nepal, kathmandu apartment, pokhara rental, nepal travel, book hotel nepal',
                'meta_description' => 'Discover authentic Nepali hospitality with Ez Property. Book premium homestays, city apartments, and mountain retreats across Nepal.',

                // --- Info Texts (About Us Content) ---
                'info1' => 'Your Gateway to Authentic Nepali Hospitality',
                'info2' => 'Founded in Kathmandu, Ez Property is dedicated to connecting travelers with unique homes, breathtaking landscapes, and genuine local experiences.',
                'info3' => 'Our mission is to empower local communities by providing a platform that promotes sustainable tourism, making authentic Nepali homestays accessible to the world.',
                'info4' => 'Your gateway to authentic Nepali hospitality. Find your perfect mountain retreat, city apartment, or jungle lodge.',
                'info5' => 'Secure Online Payments',
                'info6' => '24/7 Local Support',
                'info7' => null,

                 // --- SMTP / Mail ---


                'mail_transport' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => '587',
                'mail_username' => 'ezbooking42@gmail.com',
                'mail_password' => 'uqxr fnvu uznf zisi',
                'mail_encryption' => 'tls',
                'mail_from' => 'noreply@ezproperty.com',
                'mail_from_name' => 'Ez Property',
                'smtp_check' => true,
            

                // --- ReCaptcha ---
                'recaptcha_site_key' => '', 
                'recaptcha_secret_key'=> '', 
                'is_recaptcha' => false,

                // --- Analytics ---
                'google_analytic_id' => '',
                'facebook_analytic_id' => '',

                // --- Social Login ---
                'facebook_client_id' => '',
                'facebook_client_secret' => '',
                'facebook_redirect' => '',
                'is_facebook' => false,

                'google_client_id' => '',
                'google_client_secret' => '',
                'google_redirect' => '',
                'is_google' => false,



                'process_title' => 'Why Choose Ez Property?',
                'process_sub_title' => 'Experience the best of Nepal with our trusted platform',
                'process_item' => ([
                    [
                        'icon' => 'fa-solid fa-shield-halved',
                        'title' => 'Verified Listings',
                        'content' => 'Every property is checked to ensure what you see is exactly what you get.'
                    ],
                    [
                        'icon' => 'fa-solid fa-credit-card',
                        'title' => 'Secure Payments',
                        'content' => 'Book with peace of mind using our secure and reliable payment gateways.'
                    ],
                    [
                        'icon' => 'fa-solid fa-headset',
                        'title' => 'Local Support',
                        'content' => 'Our local team is always ready to assist you during your stay in Nepal.'
                    ],
                    [
                        'icon' => 'fa-solid fa-house-chimney-heart',
                        'title' => 'Authentic Experience',
                        'content' => 'Connect with local hosts and experience the true warmth of Nepali culture.'
                    ]
                ]),



                'work_title' => 'Become a Host',
                'work_sub_title' => 'Ready to earn from your property? Upgrade your account now to access the host dashboard and create your first listing in minutes.',
                'work_item' => ([
                    [
                        'icon' => 'fa-solid fa-user-plus',
                        'title' => 'Upgrade Your Account',
                        'content' => 'Click the button below to unlock host features and dashboard access.'
                    ],
                    [
                        'icon' => 'fa-solid fa-list-check',
                        'title' => 'List Your Property',
                        'content' => 'Add your property details, location, amenities, and high-quality photos.'
                    ],
                    [
                        'icon' => 'fa-solid fa-sliders',
                        'title' => 'Set Your Rules & Price',
                        'content' => 'Define your house rules, check-in/out times, and set competitive nightly rates.'
                    ],
                    [
                        'icon' => 'fa-solid fa-door-open',
                        'title' => 'Welcome Your Guests',
                        'content' => 'Once approved, your listing goes live. Start receiving bookings and earning income!'
                    ]
                ]),



                'counter_title' => 'Why Book With Us',
                'counter_sub_title' => 'Trusted by Travelers Across the Globe',
                'counter_item' => ([
                    [
                        'icon' => 'fa-solid fa-building',
                        'title' => '500+',
                        'content' => 'Properties Listed'
                    ],
                    [
                        'icon' => 'fa-solid fa-users',
                        'title' => '10K+',
                        'content' => 'Happy Travelers'
                    ],
                    [
                        'icon' => 'fa-solid fa-location-dot',
                        'title' => '15+',
                        'content' => 'Cities Covered'
                    ],
                    [
                        'icon' => 'fa-solid fa-star',
                        'title' => '4.8',
                        'content' => 'Average Rating'
                    ]
                ]),
            ]
        );
}
}