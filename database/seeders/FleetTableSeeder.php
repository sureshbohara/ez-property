<?php

namespace Database\Seeders;

use App\Models\Fleet;
use Illuminate\Database\Seeder;

class FleetTableSeeder extends Seeder
{
    public function run()
    {
        $fleets = [
            [
                'title' => 'Sedan',
                'subtitle' => 'Executive Black Sedan',
                'slug' => 'sedan',
                'passengers' => '4',
                'bags' => '4',
                'image' => null,
                'feature_image' => null,
                'short_content' => 'A sophisticated and comfortable black sedan, perfect for intimate rides, business meetings, and airport transfers.',
                'highlight' => json_encode([
                    'Premium leather interior',
                    'Dual-zone climate control',
                    'Complimentary bottled water',
                    'Professional, courteous chauffeur'
                ]),
                'order_level' => 1,
                'status' => true,
            ],
            [
                'title' => 'Toyota Highlander',
                'subtitle' => 'Mid-Size Luxury SUV',
                'slug' => 'toyota-highlander',
                'passengers' => '4',
                'bags' => '4',
                'image' => null,
                'feature_image' => null,
                'short_content' => 'A spacious and versatile SUV offering a smooth ride, ideal for small groups and family travel.',
                'highlight' => json_encode([
                    'Spacious and versatile cabin',
                    'Advanced safety and navigation features',
                    'Smooth and quiet ride quality',
                    'Ample cargo and luggage space'
                ]),
                'order_level' => 2,
                'status' => true,
            ],
            [
                'title' => 'GMC Yukon',
                'subtitle' => 'Full-Size Premium SUV',
                'slug' => 'gmc-yukon',
                'passengers' => '5',
                'bags' => '4',
                'image' => null,
                'feature_image' => null,
                'short_content' => 'A premium full-size SUV combining luxury and capability, perfect for group travel with extra luggage.',
                'highlight' => json_encode([
                    'Premium leather-trimmed seating',
                    'Tri-zone automatic climate control',
                    'Spacious third-row seating',
                    'Quiet and refined cabin experience'
                ]),
                'order_level' => 3,
                'status' => true,
            ],
            [
                'title' => 'Chevrolet Suburban',
                'subtitle' => 'Ultimate Group SUV',
                'slug' => 'chevrolet-suburban',
                'passengers' => '6',
                'bags' => '4',
                'image' => null,
                'feature_image' => null,
                'short_content' => 'The ultimate full-size SUV for large groups, offering maximum passenger comfort and extensive luggage capacity.',
                'highlight' => json_encode([
                    'Seats up to 6 passengers comfortably',
                    'Massive luggage and cargo capacity',
                    'Premium Bose surround sound system',
                    'Executive interior finish and lighting'
                ]),
                'order_level' => 4,
                'status' => true,
            ],
            [
                'title' => 'Ultimate Luxury Sprinter Coach',
                'subtitle' => 'VIP Party & Group Bus',
                'slug' => 'ultimate-luxury-sprinter-coach',
                'passengers' => '9',
                'bags' => 'Space Available',
                'image' => null,
                'feature_image' => null,
                'short_content' => 'Make a statement with your transportation. Perfect for weddings, VIP events, or group celebrations, our luxury coach offers seating for up to 9 guests. With a private washroom and exceptional comfort, you can focus on the event while we handle the driving. It\'s the ideal way to travel in style and convenience.',
                'highlight' => json_encode([
                    'Seating for up to 9 guests with a private washroom',
                    'Premium bar with wine, champagne, and crystal glassware',
                    'Full entertainment system with HD TVs and premium audio',
                    'Personalized service (custom playlist, temperature control)',
                    'Fresh flowers or custom decor for special occasions'
                ]),
                'order_level' => 5,
                'status' => true,
            ],
        ];


        foreach ($fleets as $fleetData) {
            Fleet::updateOrCreate(
                ['slug' => $fleetData['slug']], 
                $fleetData
            );
        }
    }
}