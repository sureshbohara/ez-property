<?php

namespace Database\Seeders;

use App\Models\Review;
use Illuminate\Database\Seeder;

class ReviewTableSeeder extends Seeder
{
    public function run()
    {
        $reviews = [
            [
                'name' => 'Sarah M.',
                'email' => null,
                'address' => 'Slidell, LA',
                'rating' => 5,
                'review' => 'I booked White Transportation LLC for an airport transfer from Slidell to MSY,...',
                'content' => 'and it was hands-down the best experience! The Black Sedan was spotless, luxurious, and so comfortable after a long flight. Our chauffeur was professional, punctual, and navigated traffic like a pro, ensuring we arrived with time to spare. Highly recommend for anyone needing reliable, upscale airport transport!',
                'image' => null,
                'display_on' => 'home',
                'order_level' => 1,
                'status' => true,
            ],
            [
                'name' => 'Michael R.',
                'email' => null,
                'address' => 'Slidell, LA',
                'rating' => 5,
                'review' => 'As a frequent business traveler, I rely on White Transportation for corporate transfers,...',
                'content' => 'and they never disappoint. Their SUVs is perfect for meetings—spacious, quiet, and equipped with all the amenities to prep on the go. The driver was courteous, dressed sharp, and even offered bottled water and Wi-Fi. They always arrive early, which helps me stay on schedule. White Transportation has become my go-to for professional travel in the Slidell area!',
                'image' => null,
                'display_on' => 'home',
                'order_level' => 2,
                'status' => true,
            ],
            [
                'name' => 'Emily T.',
                'email' => null,
                'address' => null,
                'rating' => 5,
                'review' => 'We booked White Transportation for an hourly charter to celebrate a friend’s...',
                'content' => 'promotion, and it was phenomenal! Our chauffeur was friendly, professional, and knew the best routes to keep the night seamless. The luxury experience elevated the entire occasion. Can’t wait to book again!',
                'image' => null,
                'display_on' => 'home',
                'order_level' => 3,
                'status' => true,
            ],
            [
                'name' => 'Melanie H',
                'email' => null,
                'address' => 'Mandeville, LA',
                'rating' => 5,
                'review' => 'I used White Transportation for a point-to-point transfer from Slidell to a special event...',
                'content' => 'in Mandeville, and it was perfect. The SUV was pristine and felt like a true luxury experience. The driver was professional, arrived early, and ensured a stress-free ride. The attention to detail and premium service make this company stand out. Highly recommend!',
                'image' => null,
                'display_on' => 'home',
                'order_level' => 4,
                'status' => true,
            ],
        ];
        foreach ($reviews as $reviewData) {
            Review::updateOrCreate(
                ['name' => $reviewData['name'], 'review' => $reviewData['review']], 
                $reviewData
            );
        }
    }
}