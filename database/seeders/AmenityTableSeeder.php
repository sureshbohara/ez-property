<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Amenity;
use Illuminate\Support\Str;

class AmenityTableSeeder extends Seeder
{
    public function run(): void
    {
        $amenities = [
            [
                'name' => 'Free WiFi',
                'icon' => 'fa-wifi',
                'description' => 'High-speed internet access throughout the property',
            ],
            [
                'name' => 'Air Conditioning',
                'icon' => 'fa-snowflake',
                'description' => 'Fully air-conditioned rooms for your comfort',
            ],
            [
                'name' => 'Heating',
                'icon' => 'fa-temperature-high',
                'description' => 'Central heating system available',
            ],
            [
                'name' => 'Washing Machine',
                'icon' => 'fa-shirt',
                'description' => 'In-unit washing machine for guests',
            ],
            [
                'name' => 'Dryer',
                'icon' => 'fa-wind',
                'description' => 'Clothes dryer available',
            ],
            [
                'name' => 'Kitchen',
                'icon' => 'fa-kitchen-set',
                'description' => 'Fully equipped kitchen for cooking',
            ],
            [
                'name' => 'Swimming Pool',
                'icon' => 'fa-person-swimming',
                'description' => 'Private or shared swimming pool',
            ],
            [
                'name' => 'Free Parking',
                'icon' => 'fa-square-parking',
                'description' => 'Free on-site parking for guests',
            ],
            [
                'name' => 'TV',
                'icon' => 'fa-tv',
                'description' => 'Flat-screen TV with cable channels',
            ],
            [
                'name' => 'Pet Friendly',
                'icon' => 'fa-paw',
                'description' => 'Pets are welcome',
            ],
        ];
        $order = 1;
        foreach ($amenities as $amenity) {
            Amenity::updateOrCreate(
                ['slug' => Str::slug($amenity['name'])],
                [
                    'name'        => $amenity['name'],
                    'slug'        => Str::slug($amenity['name']),
                    'icon'        => $amenity['icon'],
                    'description' => $amenity['description'],
                    'order_level' => $order++,
                    'status'      => true,
                ]
            );
        }

        $this->command->info('✅ Amenities seeded successfully! (' . count($amenities) . ' items)');
    }
}