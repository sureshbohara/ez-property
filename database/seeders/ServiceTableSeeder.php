<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceTableSeeder extends Seeder
{
    public function run()
    {
        $services = [
            [
                'title' => 'Airport Transfers',
                'subtitle' => 'Airport Transfers Service',
                'icon' => 'fas fa-plane',
                'slug' => 'airport-transfers',
                'short_content' => 'Experience stress-free travel with White Transportation LLC’s premium airport transfer service. Whether you’re heading to or from New Orleans International Airport, our luxurious black cars & SUVs ensures a comfortable and timely journey...',
                'long_content' => '<p>Experience stress-free travel with White Transportation LLC’s premium airport transfer service. Whether you’re heading to or from New Orleans International Airport, Gulfport-Biloxi International Airport, or Baton Rouge Metropolitan Airport, our luxurious & premium fleet ensures a comfortable and timely journey.</p>
                <p>Our professional chauffeurs prioritize punctuality and provide a seamless, door-to-door experience, complete with amenities like bottled water and a pristine vehicle interior, making your airport travel feel like a first-class experience. We monitor flight schedules in real-time to accommodate delays or early arrivals, ensuring you’re never left waiting.</p>
                <p>With ample luggage space and a commitment to exceptional service, White Transportation LLC transforms your journey to or from New Orleans, LA into a luxurious, hassle-free experience that sets the tone for your travel.</p>',
                'meta_keywords' => 'airport transfer, MSY, New Orleans airport, luxury car service, black car',
                'meta_description' => 'Premium airport transfer services in New Orleans. Stress-free, luxurious black car and SUV transfers to MSY, GPT, and BTR airports.',
                'order_level' => 1,
                'status' => true,
            ],
            [
                'title' => 'Corporate Transfers',
                'subtitle' => 'Corporate Transfers Service',
                'icon' => 'fas fa-briefcase',
                'slug' => 'corporate-transfers',
                'short_content' => 'Elevate your business travel with our tailored corporate transfer service, designed for professionals who value efficiency and sophistication. Our Black Cars, SUVs offers a spacious, quiet environment perfect for preparing for meetings...',
                'long_content' => '<p>Elevate your business travel with our tailored corporate transfer service, designed for professionals who value efficiency and sophistication. Our SUVs offers a spacious, quiet environment perfect for preparing for meetings.</p>
                <p>With Wi-Fi, bottled water, and impeccably dressed chauffeurs, we ensure you arrive on time and in style, ready to make an impression. Our corporate transfers are built for flexibility, accommodating last-minute schedule changes or multi-stop itineraries across New Orleans, LA, or beyond. Our chauffeurs are trained to maintain discretion and professionalism, creating an environment where you can focus on work or relax in comfort.</p>
                <p>Whether it’s a quick trip to a local office or a longer journey to a regional hub, White Transportation LLC delivers a polished, reliable experience that aligns with your professional standards.</p>',
                'meta_keywords' => 'corporate transfer, business travel, executive car service, New Orleans corporate transport',
                'meta_description' => 'Professional corporate transfer services in New Orleans. Efficient, sophisticated, and reliable black car service for business travelers.',
                'order_level' => 2,
                'status' => true,
            ],
            [
                'title' => 'Hourly Transfers',
                'subtitle' => 'Hourly Transfers Service',
                'icon' => 'fas fa-clock',
                'slug' => 'hourly-transfers',
                'short_content' => 'Enjoy ultimate flexibility with our hourly charter service, perfect for a night out, special events, or exploring New Orleans in luxury. Choose from our fleet for an intimate, elegant ride and for extra space and comfort...',
                'long_content' => '<p>Enjoy ultimate flexibility with our hourly charter service, perfect for a night out, special events, or exploring New Orleans, LA in luxury. Choose from our Black Sedan for an intimate, elegant ride or the SUVs for extra space and comfort.</p>
                <p>Our professional chauffeurs are at your service, navigating the best routes to keep your schedule smooth and stress-free, ensuring every moment is elevated with premium comfort. With our hourly charter, you’re in control of your itinerary, whether it’s a multi-stop evening of dining, a corporate event, or a leisurely tour of the region’s attractions. Our premium vehicles are equipped with high-end amenities, and our chauffeurs provide personalized attention to ensure a seamless experience.</p>
                <p>White Transportation LLC makes every hour on the road a luxurious escape, tailored to your unique plans and preferences.</p>',
                'meta_keywords' => 'hourly charter, hourly car service, night out transport, New Orleans luxury rental',
                'meta_description' => 'Flexible hourly charter services in New Orleans. Perfect for nights out, events, and city tours in our luxury black cars and SUVs.',
                'order_level' => 3,
                'status' => true,
            ],
            [
                'title' => 'Point To Point Transfers',
                'subtitle' => 'Point To Point Transfers Service',
                'icon' => 'fas fa-map-marked-alt',
                'slug' => 'point-to-point-transfers',
                'short_content' => 'For direct, hassle-free travel, our point-to-point transfer service delivers luxury and reliability from one destination to another. Whether it’s a business meeting in Mandeville or a special event in New Orleans, our black cars & SUVs provides a stylish,...',
                'long_content' => '<p>For direct, hassle-free travel, our point-to-point transfer service delivers luxury and reliability from one destination to another. Whether it’s a business meeting in Mandeville or a special event in New Orleans, our black cars & SUVs provides a stylish, comfortable ride.</p>
                <p>Our chauffeurs prioritize punctuality and personalized service, ensuring you arrive refreshed and on time, every time. Our point-to-point transfers are ideal for those who value efficiency and elegance, offering a direct route to your destination with no compromises on comfort. From short trips within New Orleans, LA to longer journeys across the region, our chauffeurs plan the best routes and accommodate special requests to enhance your experience.</p>
                <p>With White Transportation LLC, every transfer is a refined journey that reflects the luxury you expect.</p>',
                'meta_keywords' => 'point to point transfer, direct car service, luxury transport New Orleans, Mandeville transport',
                'meta_description' => 'Direct and reliable point-to-point transfer services. Luxury black car and SUV transport between any destinations in and around New Orleans.',
                'order_level' => 4,
                'status' => true,
            ],
            [
                'title' => 'Special Occasion',
                'subtitle' => 'Special Occasion Service',
                'icon' => 'fas fa-glass-cheers',
                'slug' => 'special-occasion',
                'short_content' => 'Make your milestone moments unforgettable with our special occasion transportation service. From anniversaries to birthdays, our variety of fleet add a touch of luxury to any celebration in New Orleans or beyond. Our professional chauffeurs ensure every detail...',
                'long_content' => '<p>Make your milestone moments unforgettable with our special occasion transportation service. From anniversaries to birthdays, our variety of fleet add a touch of luxury to any celebration in New Orleans or beyond.</p>
                <p>Our professional chauffeurs ensure every detail is perfect, providing a seamless, upscale experience that lets you focus on enjoying your event in style and comfort. Whether it’s a romantic anniversary dinner or a lively birthday celebration, our special occasion service is designed to elevate your experience with sophistication and ease. Our chauffeurs coordinate with your event schedule, ensuring timely arrivals and a smooth flow throughout the day or evening.</p>
                <p>With White Transportation LLC, your special moments are enhanced by our premium fleet and exceptional service, creating memories that last a lifetime.</p>',
                'meta_keywords' => 'special occasion transport, wedding car service, anniversary transport, birthday limo New Orleans',
                'meta_description' => 'Luxury transportation for special occasions in New Orleans. Make your anniversaries, birthdays, and milestones unforgettable with our premium fleet.',
                'order_level' => 5,
                'status' => true,
            ],
            [
                'title' => 'Hire A Chauffeur',
                'subtitle' => 'Hire A Chauffeur Service',
                'icon' => 'fas fa-user-tie',
                'slug' => 'hire-a-chauffeur',
                'short_content' => 'For those seeking personalized transportation, our hire-a-chauffeur service offers the ultimate in flexibility and luxury. Whether you need a dedicated driver for a day of appointments or a special outing, our professional chauffeurs, paired...',
                'long_content' => '<p>For those seeking personalized transportation, our hire-a-chauffeur service offers the ultimate in flexibility and luxury. Whether you need a dedicated driver for a day of appointments or a special outing, our professional chauffeurs, paired with our premium black cars, provide a tailored experience.</p>
                <p>Enjoy the convenience of a private driver who prioritizes your schedule and comfort, delivering a first-class journey every step of the way. Our hire-a-chauffeur service is perfect for clients who want a customized travel experience, whether for business or leisure. Our chauffeurs bring local expertise and a commitment to excellence, ensuring every stop is seamless and every ride is comfortable.</p>
                <p>With White Transportation LLC, you gain the freedom to move at your own pace, wrapped in the luxury and professionalism of our premium vehicles and dedicated drivers.</p>',
                'meta_keywords' => 'hire a chauffeur, private driver New Orleans, dedicated driver, luxury chauffeur service',
                'meta_description' => 'Hire a professional private chauffeur in New Orleans. Ultimate flexibility and luxury for your day of appointments or special outings.',
                'order_level' => 6,
                'status' => true,
            ],
        ];

 
        foreach ($services as $serviceData) {
            Service::updateOrCreate(
                ['slug' => $serviceData['slug']], 
                $serviceData
            );
        }
    }
}