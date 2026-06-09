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
                'system_name' => 'White Transportation LLC',
                'email' => 'info@whitetransportllc.com',
                'extra_email' => null,
                'phone' => '(504) 327-6880',
                'extra_phone' => null, 
                'address' => 'New Orleans, LA',
                'opening_hr' => '24/7 Service',
                'work_hours' => 'Providing premium black car and luxury services since 2010.',
                'footer_copyright' => '© ' . date('Y') . ' White Transportation LLC. All Rights Reserved.',
                'google_map' => null, 

                // --- Social Links ---
                'facebook' => null,
                'twitter'  => null,
                'linkedin' => null,
                'instagram'=> null,
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
                'meta_author' => 'White Transportation LLC',
                'meta_title'  => 'White Transportation LLC | Premier Luxury Transportation in New Orleans',
                'meta_keywords' => 'luxury transportation, black car service, New Orleans airport transfer, corporate transfers, hourly charter',
                'meta_description' => 'Experience premium luxury transportation in New Orleans, LA with White Transportation LLC. Offering airport transfers, corporate travel, hourly charters, and special occasion black car & SUV services.',

                // --- Info Texts (About Us Content) ---
                'info1' => 'Your Premier Luxury Transportation Service provider in New Orleans, LA',
                'info2' => 'Founded in New Orleans, Louisiana, White Transportation LLC is dedicated to redefining luxury travel with our premium black car services. With a fleet featuring the sophisticated Black Sedan and spacious SUVs, we cater to discerning clients seeking unparalleled comfort and reliability.',
                'info3' => 'Our mission is to elevate every journey—whether it’s an airport transfer to MSY, GPT, or BTR, a corporate trip, or a special occasion—by combining impeccable service, professional chauffeurs, and a commitment to excellence.',
                'info4' => '15% discount to senior citizens and veterans',
                'info5' => 'Easy Booking Process',
                'info6' => '15+ Years of Experience',
                'info7' => null,

                 // --- SMTP / Mail ---
                'mail_transport' => 'smtp',
                'mail_host' => 'smtp.gmail.com',
                'mail_port' => '587',
                'mail_username' => 'ezbooking42@gmail.com',
                'mail_password' => 'uqxr fnvu uznf zisi',
                'mail_encryption' => 'tls',
                'mail_from' => 'info@whitetransportllc.com',
                'mail_from_name' => 'White Transportation LLC',
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

            
                'process_title' => 'Why Choose White Transportation LLC?',
                'process_sub_title' => 'Experience the difference with our premium services',
                'process_item' => json_encode([
                    [
                        'icon' => 'bi bi-person-badge',
                        'title' => 'Professional Chauffeurs',
                        'content' => 'Our chauffeurs ensure safe, punctual, and courteous transportation tailored to your needs.'
                    ],
                    [
                        'icon' => 'bi bi-star-fill',
                        'title' => 'Impeccable Service',
                        'content' => 'We provide impeccable service, ensuring every detail is handled with precision and care.'
                    ],
                    [
                        'icon' => 'bi bi-gem',
                        'title' => 'Legacy of Luxury',
                        'content' => 'We embody a legacy of luxury, crafting every ride into a refined, extravagant experience.'
                    ],
                    [
                        'icon' => 'bi bi-car-front-fill',
                        'title' => 'Luxury Fleet Selection',
                        'content' => 'We have a luxury fleet, featuring meticulously curated vehicles for unmatched style and comfort.'
                    ]
                ]),

       
                'work_title' => 'Our Services',
                'work_sub_title' => 'Premium Transportation Solutions Tailored to Your Needs',
                'work_item' => json_encode([
                    [
                        'icon' => 'fas fa-plane-departure',
                        'title' => 'Airport Transfers',
                        'content' => 'Experience stress-free travel with our premium airport transfer service to MSY, GPT, or BTR. Our luxurious black cars & SUVs ensure a comfortable and timely journey.'
                    ],
                    [
                        'icon' => 'fas fa-briefcase',
                        'title' => 'Corporate Transfers',
                        'content' => 'Elevate your business travel with our tailored corporate transfer service, designed for professionals who value efficiency and sophistication.'
                    ],
                    [
                        'icon' => 'fas fa-clock',
                        'title' => 'Hourly Transfers',
                        'content' => 'Enjoy ultimate flexibility with our hourly charter service, perfect for a night out, special events, or exploring New Orleans in luxury.'
                    ],
                    [
                        'icon' => 'fas fa-route',
                        'title' => 'Point To Point Transfers',
                        'content' => 'For direct, hassle-free travel, our point-to-point transfer service delivers luxury and reliability from one destination to another.'
                    ],
                    [
                        'icon' => 'fas fa-champagne-glasses',
                        'title' => 'Special Occasion',
                        'content' => 'Make your milestone moments unforgettable with our special occasion transportation service. Our professional chauffeurs ensure every detail is perfect.'
                    ],
                    [
                        'icon' => 'fas fa-user-tie',
                        'title' => 'Hire A Chauffeur',
                        'content' => 'For those seeking personalized transportation, our hire-a-chauffeur service offers the ultimate in flexibility and luxury for your day.'
                    ]
                ]),

             
                'counter_title' => 'Why Ride With Us',
                'counter_sub_title' => 'Commitment to Excellence Since 2010',
                'counter_item' => json_encode([
                    [
                        'icon' => 'bi bi-calendar-check',
                        'title' => '15+',
                        'content' => 'Years of Experience'
                    ],
                    [
                        'icon' => 'bi bi-clock-history',
                        'title' => '24/7',
                        'content' => 'Service Available'
                    ],
                    [
                        'icon' => 'bi bi-percent',
                        'title' => '15%',
                        'content' => 'Senior & Veteran Discount'
                    ],
                    [
                        'icon' => 'bi bi-hand-thumbs-up',
                        'title' => '100%',
                        'content' => 'Satisfaction Guaranteed'
                    ]
                ]),
            ]
        );
    }
}