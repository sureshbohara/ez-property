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
            // Essentials
            ['name' => 'Free WiFi',            'icon' => 'bi bi-wifi',               'description' => 'High-speed internet access throughout the property'],
            ['name' => 'Air Conditioning',     'icon' => 'bi bi-snow',               'description' => 'Fully air-conditioned rooms for your comfort'],
            ['name' => 'Heating',              'icon' => 'bi bi-thermometer-sun',    'description' => 'Central heating system available'],
            ['name' => 'Washing Machine',      'icon' => 'bi bi-droplet',            'description' => 'In-unit washing machine for guests'],
            ['name' => 'Dryer',                'icon' => 'bi bi-wind',               'description' => 'Clothes dryer available'],
            ['name' => 'Iron',                 'icon' => 'bi bi-square',             'description' => 'Iron and ironing board provided'],
            ['name' => 'Hair Dryer',           'icon' => 'bi bi-wind',               'description' => 'Hair dryer in the bathroom'],
            ['name' => 'Hangers',              'icon' => 'bi bi-suit-heart',         'description' => 'Plenty of hangers in the closet'],
            ['name' => 'Bed Linens',           'icon' => 'bi bi-layout-text-window', 'description' => 'Fresh bed linens and towels provided'],
            ['name' => 'Extra Pillows & Blankets', 'icon' => 'bi bi-cloud',          'description' => 'Extra pillows and blankets available'],

            // Kitchen & Dining
            ['name' => 'Kitchen',              'icon' => 'bi bi-cup-hot',            'description' => 'Fully equipped kitchen for cooking'],
            ['name' => 'Refrigerator',         'icon' => 'bi bi-snow2',              'description' => 'Refrigerator with freezer compartment'],
            ['name' => 'Microwave',            'icon' => 'bi bi-clock-history',      'description' => 'Microwave oven available'],
            ['name' => 'Stove',                'icon' => 'bi bi-fire',               'description' => 'Gas or electric stove'],
            ['name' => 'Oven',                 'icon' => 'bi bi-thermometer-half',   'description' => 'Built-in oven for baking'],
            ['name' => 'Dishwasher',           'icon' => 'bi bi-droplet-half',       'description' => 'Dishwasher for easy cleanup'],
            ['name' => 'Coffee Maker',         'icon' => 'bi bi-cup-straw',          'description' => 'Coffee maker with complimentary coffee'],
            ['name' => 'Toaster',              'icon' => 'bi bi-square-half',        'description' => 'Toaster for breakfast'],
            ['name' => 'Dining Table',         'icon' => 'bi bi-table',              'description' => 'Dedicated dining area'],

            // Outdoor & Leisure
            ['name' => 'Swimming Pool',        'icon' => 'bi bi-water',              'description' => 'Private or shared swimming pool'],
            ['name' => 'Balcony',              'icon' => 'bi bi-building',           'description' => 'Private balcony with view'],
            ['name' => 'Garden',               'icon' => 'bi bi-tree',               'description' => 'Beautiful garden area'],
            ['name' => 'BBQ Grill',            'icon' => 'bi bi-fire',               'description' => 'Outdoor BBQ grill available'],
            ['name' => 'Patio',                'icon' => 'bi bi-house',              'description' => 'Outdoor patio seating area'],
            ['name' => 'Fireplace',            'icon' => 'bi bi-fire',               'description' => 'Cozy indoor fireplace'],
            ['name' => 'Hot Tub',              'icon' => 'bi bi-water',              'description' => 'Private hot tub / jacuzzi'],

            // Parking & Transport
            ['name' => 'Free Parking',         'icon' => 'bi bi-p-circle',           'description' => 'Free on-site parking for guests'],
            ['name' => 'Garage Parking',       'icon' => 'bi bi-car-front',          'description' => 'Secure garage parking available'],
            ['name' => 'EV Charger',           'icon' => 'bi bi-ev-front',           'description' => 'Electric vehicle charging station'],
            ['name' => 'Bicycle',              'icon' => 'bi bi-bicycle',            'description' => 'Complimentary bicycles for guests'],

            // Entertainment
            ['name' => 'TV',                   'icon' => 'bi bi-tv',                 'description' => 'Flat-screen TV with cable channels'],
            ['name' => 'Smart TV',             'icon' => 'bi bi-tv-fill',            'description' => 'Smart TV with Netflix, YouTube, etc.'],
            ['name' => 'Sound System',         'icon' => 'bi bi-speaker',            'description' => 'Bluetooth sound system'],
            ['name' => 'Books & Reading Material', 'icon' => 'bi bi-book',           'description' => 'Library of books and guides'],
            ['name' => 'Board Games',          'icon' => 'bi bi-controller',         'description' => 'Board games for family fun'],

            // Safety & Security
            ['name' => 'Security Cameras',     'icon' => 'bi bi-camera-video',       'description' => 'CCTV cameras in common areas'],
            ['name' => 'Smoke Alarm',          'icon' => 'bi bi-fire',               'description' => 'Smoke detectors installed'],
            ['name' => 'Fire Extinguisher',    'icon' => 'bi bi-shield-check',       'description' => 'Fire extinguisher on premises'],
            ['name' => 'First Aid Kit',        'icon' => 'bi bi-plus-circle',        'description' => 'First aid kit available'],
            ['name' => 'Safe Box',             'icon' => 'bi bi-shield-lock',        'description' => 'In-room safe for valuables'],

            // Services
            ['name' => 'Breakfast Included',   'icon' => 'bi bi-cup-hot-fill',       'description' => 'Complimentary breakfast provided'],
            ['name' => 'Room Service',         'icon' => 'bi bi-bell',               'description' => '24/7 room service available'],
            ['name' => 'Housekeeping',         'icon' => 'bi bi-brush',              'description' => 'Daily housekeeping service'],
            ['name' => 'Concierge',            'icon' => 'bi bi-person-badge',       'description' => 'Concierge service for tour booking'],
            ['name' => 'Airport Shuttle',      'icon' => 'bi bi-airplane',           'description' => 'Complimentary airport transfer'],
            ['name' => 'Luggage Storage',      'icon' => 'bi bi-bag',                'description' => 'Secure luggage storage available'],

            // Accessibility
            ['name' => 'Wheelchair Accessible', 'icon' => 'bi bi-universal-access',  'description' => 'Fully wheelchair accessible'],
            ['name' => 'Elevator',             'icon' => 'bi bi-arrow-up-square',    'description' => 'Elevator access to all floors'],
            ['name' => 'Ground Floor',         'icon' => 'bi bi-house-door',         'description' => 'Located on ground floor'],

            // Work & Business
            ['name' => 'Dedicated Workspace',  'icon' => 'bi bi-laptop',             'description' => 'Dedicated desk and chair for work'],
            ['name' => 'Printer',              'icon' => 'bi bi-printer',            'description' => 'Printer available for guests'],

            // Pet & Family
            ['name' => 'Pet Friendly',         'icon' => 'bi bi-emoji-smile',        'description' => 'Pets are welcome'],
            ['name' => 'Child Friendly',       'icon' => 'bi bi-emoji-laughing',     'description' => 'Family-friendly with kids amenities'],
            ['name' => 'Crib',                 'icon' => 'bi bi-basket',             'description' => 'Baby crib available on request'],
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