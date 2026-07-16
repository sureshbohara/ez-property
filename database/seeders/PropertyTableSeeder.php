<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Listing;
use App\Models\Category;
use Illuminate\Support\Str;
use Faker\Factory as Faker;

class PropertyTableSeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();
        
        $homestayCat = Category::where('slug', 'village-homestay')->value('id');
        $tourCat = Category::where('slug', 'cultural-tours')->value('id');
        $destinationCat = Category::where('slug', 'nepal')->value('id');
        $experienceCat = Category::where('slug', 'cultural-workshops')->value('id');
        $serviceCat = Category::where('slug', 'airport-transfers')->value('id');
        
        $allCategoryIds = Category::pluck('id')->toArray();
        if (empty($allCategoryIds)) {
            $this->command->error('❌ No categories found! Please run CategoryTableSeeder first.');
            return;
        }

        $sections = [
            'featured'    => 12,
            'nearby'      => 12,
            'homestays'   => 12,
            'recommended' => 18,
        ];

        foreach ($sections as $displayOn => $count) {
            for ($i = 0; $i < $count; $i++) {
                $this->createListing($faker, $allCategoryIds, $displayOn, $i, [
                    'homestay' => $homestayCat,
                    'tour' => $tourCat,
                    'destination' => $destinationCat
                ]);
            }
        }

        for ($i = 0; $i < 10; $i++) {
            $this->createExperienceListing($faker, $experienceCat ?: $allCategoryIds);
        }
        for ($i = 0; $i < 8; $i++) {
            $this->createServiceListing($faker, $serviceCat ?: $allCategoryIds);
        }

        $this->command->info('✅ Listings created successfully! (Home: 54, Experiences: 10, Services: 8)');
    }

    private function createListing($faker, $allCategoryIds, $displayOn, $index, $specificCats){
        $cities = ['Kathmandu', 'Pokhara', 'Chitwan', 'Lalitpur', 'Bhaktapur', 'Nagarkot', 'Bandipur', 'Ilam'];
        $city = $faker->randomElement($cities);
        $provinces = ['Bagmati', 'Gandaki', 'Lumbini', 'Koshi', 'Sudurpashchim'];

        if ($displayOn === 'homestays') {
            $listingType = 'homestay';
            $categoryId = $specificCats['homestay'] ?: $faker->randomElement($allCategoryIds);
            $titles = ['Peaceful Valley Homestay', 'Riverside Retreat', 'Traditional Newari House', 'Mountain View Homestay', 'Lakeside Homestay', 'Heritage Homestay'];
            $price = $faker->numberBetween(1500, 5000);
        } elseif ($displayOn === 'featured') {
            $listingType = $faker->randomElement(['entire_home', 'resort', 'hotel']);
            $categoryId = $specificCats['tour'] ?: $specificCats['destination'] ?: $faker->randomElement($allCategoryIds);
            $titles = ['Lakeview Apartment', 'Thamel Heritage Stay', 'Jungle Safari Lodge', 'Luxury Villa with Pool', 'Annapurna Base Camp Resort', 'Pokhara Lakeside Resort'];
            $price = $faker->numberBetween(5000, 15000);
        } elseif ($displayOn === 'nearby') {
            $listingType = $faker->randomElement(['hotel', 'resort', 'entire_home']);
            $categoryId = $specificCats['tour'] ?: $specificCats['destination'] ?: $faker->randomElement($allCategoryIds);
            $titles = ['City Center Hotel', 'Eco-Friendly Cabin', 'Boutique Hotel Stay', 'The Dwarika\'s Resort', 'Korner Saint-Marcel', 'Hotel Joke Boutique'];
            $price = $faker->numberBetween(3000, 12000);
        } else { 
            $listingType = $faker->randomElement(['lodge', 'cabin', 'camping', 'entire_home']);
            $categoryId = $specificCats['destination'] ?: $faker->randomElement($allCategoryIds);
            $titles = ['Himalayan Resort', 'Annapurna Base Camp Lodge', 'Rara Lake Cabin', 'Ilam Tea Garden House', 'Mustang Cave Hotel', 'Bardiya Jungle Camp'];
            $price = $faker->numberBetween(1000, 8000);
        }
        
        $title = $faker->randomElement($titles) . ', ' . $city;

        Listing::create([
            'user_id'            => null, 
            'category_id'        => $categoryId, 
            'title'              => $title,
            'slug'               => Str::slug($title) . '-' . $faker->unique()->numberBetween(100, 999),
            'description'        => $faker->paragraphs(3, true),
            'address'            => $faker->streetAddress,
            'city'               => $city,
            'province'           => $faker->randomElement($provinces),
            'country'            => 'Nepal',
            'latitude'           => $faker->latitude(26.3, 30.4), 
            'longitude'          => $faker->longitude(80.0, 88.2),
            'image'              => null,
            'gallery'            => null, 
            'highlight_key'      => $faker->randomElements(['Guest favorite', 'Superhost', 'New', 'Great location', 'Free cancellation'], $faker->numberBetween(1, 2)),
            'guests'             => $faker->numberBetween(1, 6),
            'bedrooms'           => $faker->numberBetween(1, 4),
            'beds'               => $faker->numberBetween(1, 4),
            'bathrooms'          => $faker->numberBetween(1, 3),
            'display_on'         => $displayOn,
            'listing_type'       => $listingType,
            'base_price'         => $price,
            'cleaning_fee'       => $faker->numberBetween(500, 2000),
            'service_fee'        => $faker->numberBetween(200, 1000),
            'minimum_nights'     => $faker->numberBetween(1, 3),
            'cancellation_policy'=> $faker->randomElement(['flexible', 'moderate', 'strict']),
            'instant_bookable'   => $faker->boolean(70),
            'status'             => true,
            'views'              => $faker->numberBetween(50, 500),
            'order_level'        => $index, 
            'meta_title'         => $title . ' | BNB Nepali',
            'meta_description'   => $faker->sentence(15),
        ]);
    }

    private function createExperienceListing($faker, $categoryId)
    {
        $cities = ['Kathmandu', 'Pokhara', 'Chitwan', 'Bhaktapur', 'Nagarkot'];
        $city = $faker->randomElement($cities);
        
        $titles = [
            'Traditional Newari Cooking Class', 'Sunrise Yoga in Pokhara', 'Kathmandu Heritage Walking Tour',
            'Thame Village Cultural Immersion', 'Nepali Tea Tasting Experience', 'Pottery Making in Bhaktapur',
            'Local Market Food Tour', 'Meditation and Mindfulness Retreat', 'Traditional Thangka Painting Workshop'
        ];

        Listing::create([
            'user_id'            => null,
            'category_id'        => is_array($categoryId) ? $faker->randomElement($categoryId) : $categoryId,
            'title'              => $faker->randomElement($titles) . ', ' . $city,
            'slug'               => Str::slug($faker->randomElement($titles) . '-' . $city) . '-' . $faker->unique()->numberBetween(100, 999),
            'description'        => $faker->paragraphs(2, true),
            'address'            => $faker->streetAddress,
            'city'               => $city,
            'province'           => 'Bagmati',
            'country'            => 'Nepal',
            'latitude'           => $faker->latitude(26.3, 30.4), 
            'longitude'          => $faker->longitude(80.0, 88.2),
            'image'              => null,
            'gallery'            => null,
            'highlight_key'      => ['Unique', 'Local Guide'],
            'guests'             => $faker->numberBetween(2, 10),
            'bedrooms'           => 0, 
            'beds'               => 0,
            'bathrooms'          => 0,
            'display_on'         => 'default', 
            'listing_type'       => 'experience',
            'base_price'         => $faker->numberBetween(1000, 5000),
            'cleaning_fee'       => 0,
            'service_fee'        => $faker->numberBetween(100, 500),
            'minimum_nights'     => 1,
            'cancellation_policy'=> 'flexible',
            'instant_bookable'   => $faker->boolean(80),
            'status'             => true,
            'views'              => $faker->numberBetween(10, 200),
            'order_level'        => 0,
            'meta_title'         => 'Experience in Nepal | BNB Nepali',
            'meta_description'   => $faker->sentence(15),
        ]);
    }

    private function createServiceListing($faker, $categoryId){
        $cities = ['Kathmandu', 'Pokhara', 'Chitwan', 'Bhairahawa'];
        $city = $faker->randomElement($cities);
        
        $titles = [
            'Kathmandu Airport Pickup & Drop', 'Professional English Speaking Guide', 'Trekking Gear Rental Package',
            'Nepal Tourist Visa Assistance', 'Private Vehicle Charter for Tours', 'Porter Booking for Treks',
            'Travel Insurance Consultation'
        ];

        Listing::create([
            'user_id'            => null,
            'category_id'        => is_array($categoryId) ? $faker->randomElement($categoryId) : $categoryId,
            'title'              => $faker->randomElement($titles) . ' - ' . $city,
            'slug'               => Str::slug($faker->randomElement($titles) . '-' . $city) . '-' . $faker->unique()->numberBetween(100, 999),
            'description'        => $faker->paragraphs(2, true),
            'address'            => $faker->streetAddress,
            'city'               => $city,
            'province'           => 'Bagmati',
            'country'            => 'Nepal',
            'latitude'           => $faker->latitude(26.3, 30.4), 
            'longitude'          => $faker->longitude(80.0, 88.2),
            'image'              => null,
            'gallery'            => null,
            'highlight_key'      => ['Reliable', '24/7 Support'],
            'guests'             => $faker->numberBetween(1, 4),
            'bedrooms'           => 0, 
            'beds'               => 0,
            'bathrooms'          => 0,
            'display_on'         => 'default', 
            'listing_type'       => 'service',
            'base_price'         => $faker->numberBetween(1500, 10000),
            'cleaning_fee'       => 0,
            'service_fee'        => $faker->numberBetween(200, 1000),
            'minimum_nights'     => 1,
            'cancellation_policy'=> 'moderate',
            'instant_bookable'   => $faker->boolean(90),
            'status'             => true,
            'views'              => $faker->numberBetween(20, 300),
            'order_level'        => 0,
            'meta_title'         => 'Travel Service in Nepal | BNB Nepali',
            'meta_description'   => $faker->sentence(15),
        ]);
    }
}