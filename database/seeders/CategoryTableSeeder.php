<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    public function run()
    {
        // ==========================================
        // 1. MAIN CATEGORY: TREKKING
        // ==========================================
        $trekking = Category::updateOrCreate(
            ['slug' => 'trekking'],
            [
                'parent_id' => null,
                'name' => 'Trekking',
                'slug' => 'trekking',
                'excerpt' => 'Explore the majestic Himalayas with our curated trekking packages.',
                'description' => 'Nepal is home to some of the most spectacular trekking routes in the world. From the popular Annapurna and Everest regions to the remote trails of Manaslu and Dolpa.',
                'font_icon' => 'bi-backpack', 
                'order_level' => 1,
                'display_on' => 'default',
                'status' => true,
            ]
        );

        $trekkingSubs = [
            ['name' => 'Annapurna Region Trekking', 'slug' => 'annapurna-region-trekking', 'excerpt' => 'Trek through the diverse landscapes of the Annapurna region.', 'order_level' => 1],
            ['name' => 'Everest Region Trekking', 'slug' => 'everest-region-trekking', 'excerpt' => 'Embark on an adventure to the base of the world\'s highest peak.', 'order_level' => 2],
            ['name' => 'Langtang Region Trekking', 'slug' => 'langtang-region-trekking', 'excerpt' => 'Discover the pristine beauty of the Langtang valley.', 'order_level' => 3],
            ['name' => 'Manaslu Region Trekking', 'slug' => 'manaslu-region-trekking', 'excerpt' => 'Experience the remote trails around the 8th highest mountain.', 'order_level' => 4],
            ['name' => 'Dolpa Region Trekking', 'slug' => 'dolpa-region-trekking', 'excerpt' => 'Journey into the hidden landscapes of upper Dolpo.', 'order_level' => 5],
            ['name' => 'Nepal Western Region Trek', 'slug' => 'nepal-western-region-trek', 'excerpt' => 'Explore off-the-beaten-path trails in Western Nepal.', 'order_level' => 6],
            ['name' => 'Nepal Eastern Region Trek', 'slug' => 'nepal-eastern-region-trek', 'excerpt' => 'Trek the rugged terrains of Eastern Nepal.', 'order_level' => 7],
            ['name' => 'Tibet Tour Trek', 'slug' => 'tibet-tour-trek', 'excerpt' => 'Combine cultural tours and high-altitude trekking in Tibet.', 'order_level' => 8],
        ];

        foreach ($trekkingSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => $sub['slug']],
                array_merge($sub, [
                    'parent_id' => $trekking->id,
                    'font_icon' => 'bi-geo-alt',
                    'display_on' => 'default',
                    'status' => true,
                ])
            );
        }


        // ==========================================
        // 2. MAIN CATEGORY: EXPEDITIONS
        // ==========================================
        $expeditions = Category::updateOrCreate(
            ['slug' => 'expeditions'],
            [
                'parent_id' => null,
                'name' => 'Expeditions',
                'slug' => 'expeditions',
                'excerpt' => 'Challenge yourself with our extreme high-altitude mountain climbing expeditions.',
                'description' => 'For the ultimate mountaineer, we offer fully supported climbing expeditions to some of the highest and most technical peaks in the Himalayas.',
                'font_icon' => 'bi-triangle', 
                'order_level' => 2,
                'display_on' => 'default',
                'status' => true,
            ]
        );

        $expeditionSubs = [
            ['name' => '6000m Peaks', 'slug' => '6000m-peaks', 'excerpt' => 'Climbing expeditions to stunning peaks ranging between 6,000 and 6,999 meters.', 'order_level' => 1],
            ['name' => '7000m Peaks', 'slug' => '7000m-peaks', 'excerpt' => 'Extreme high-altitude climbing challenges in the 7,000-meter range.', 'order_level' => 2],
            ['name' => '8000m Peaks', 'slug' => '8000m-peaks', 'excerpt' => 'The ultimate mountaineering goal: conquering the mighty 8,000-meter giants.', 'order_level' => 3],
        ];

        foreach ($expeditionSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => $sub['slug']],
                array_merge($sub, [
                    'parent_id' => $expeditions->id,
                    'font_icon' => 'bi-flag',
                    'display_on' => 'default',
                    'status' => true,
                ])
            );
        }


        // ==========================================
        // 3. MAIN CATEGORY: TOURS
        // ==========================================
        $tours = Category::updateOrCreate(
            ['slug' => 'tours'],
            [
                'parent_id' => null,
                'name' => 'Tours',
                'slug' => 'tours',
                'excerpt' => 'Cultural, historical, and scenic tours across Nepal and Tibet.',
                'description' => 'Experience the rich heritage, vibrant culture, and breathtaking scenery of the Himalayas without the strenuous trekking.',
                'font_icon' => 'bi-bus-front', 
                'order_level' => 3,
                'display_on' => 'default',
                'status' => true,
            ]
        );

        $tourSubs = [
            ['name' => 'Cultural Tours', 'slug' => 'cultural-tours', 'excerpt' => 'Immerse yourself in local traditions, ancient temples, and living heritage.', 'order_level' => 1],
            ['name' => 'City Tours', 'slug' => 'city-tours', 'excerpt' => 'Explore the vibrant cities, markets, and historical landmarks of the Himalayas.', 'order_level' => 2],
            ['name' => 'Village Homestay', 'slug' => 'village-homestay', 'excerpt' => 'Experience authentic rural life and warm hospitality with local families.', 'order_level' => 3],
            ['name' => 'Wildlife Safari', 'slug' => 'wildlife-safari', 'excerpt' => 'Discover diverse wildlife including rhinos, tigers, and elephants in national parks.', 'order_level' => 4],
            ['name' => 'Honeymoon Packages', 'slug' => 'honeymoon-packages', 'excerpt' => 'Romantic getaways with breathtaking mountain views and luxury accommodations.', 'order_level' => 5],
            ['name' => 'Pilgrimage Tours', 'slug' => 'pilgrimage-tours', 'excerpt' => 'Sacred journeys to holy sites of Hinduism and Buddhism.', 'order_level' => 6],
        ];

        foreach ($tourSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => $sub['slug']],
                array_merge($sub, [
                    'parent_id' => $tours->id,
                    'font_icon' => 'bi-compass',
                    'display_on' => 'default',
                    'status' => true,
                ])
            );
        }


        // ==========================================
        // 4. MAIN CATEGORY: DESTINATIONS
        // ==========================================
        $destinations = Category::updateOrCreate(
            ['slug' => 'destinations'],
            [
                'parent_id' => null,
                'name' => 'Destinations',
                'slug' => 'destinations',
                'excerpt' => 'Explore our curated trips across the Himalayas and beyond.',
                'description' => 'Discover the perfect destination for your next adventure, from the high peaks of Nepal to the ancient culture of Tibet.',
                'font_icon' => 'bi-globe-americas',
                'order_level' => 4,
                'display_on' => 'default',
                'status' => true,
            ]
        );

        $destinationSubs = [
            ['name' => 'Nepal', 'slug' => 'nepal', 'excerpt' => 'Home to 8 of the world\'s 10 highest peaks and rich cultural heritage.', 'order_level' => 1],
            ['name' => 'Tibet', 'slug' => 'tibet', 'excerpt' => 'The Roof of the World - explore ancient monasteries and the Everest North Face.', 'order_level' => 2],
            ['name' => 'Bhutan', 'slug' => 'bhutan', 'excerpt' => 'The Land of the Thunder Dragon - a unique blend of ancient culture and pristine nature.', 'order_level' => 3],
            ['name' => 'India', 'slug' => 'india', 'excerpt' => 'From the Himalayan foothills to the vibrant plains, discover incredible diversity.', 'order_level' => 4],
        ];

        foreach ($destinationSubs as $sub) {
            Category::updateOrCreate(
                ['slug' => $sub['slug']],
                array_merge($sub, [
                    'parent_id' => $destinations->id,
                    'font_icon' => 'bi-geo-alt',
                    'display_on' => 'default',
                    'status' => true,
                ])
            );
        }
    }
}