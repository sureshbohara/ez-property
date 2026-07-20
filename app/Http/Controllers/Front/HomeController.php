<?php

namespace App\Http\Controllers\Front;

use Inertia\Inertia; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;

class HomeController extends Controller
{

    private function getPropertyTypes(): array {
        return [
            'all'          => ['label' => 'All', 'icon' => 'fa-solid fa-border-all'],
            'entire_home'  => ['label' => 'Entire Home', 'icon' => 'fa-solid fa-house-chimney'],
            'private_room' => ['label' => 'Private Room', 'icon' => 'fa-solid fa-door-open'],
            'shared_room'  => ['label' => 'Shared Room', 'icon' => 'fa-solid fa-users'],
            'homestay'     => ['label' => 'Homestay', 'icon' => 'fa-solid fa-people-roof'],
            'hotel'        => ['label' => 'Hotel', 'icon' => 'fa-solid fa-hotel'],
            'resort'       => ['label' => 'Resort', 'icon' => 'fa-solid fa-umbrella-beach'],
            'lodge'        => ['label' => 'Lodge', 'icon' => 'fa-solid fa-mountain-sun'],
            'cabin'        => ['label' => 'Cabin', 'icon' => 'fa-solid fa-tree'],
            'camping'      => ['label' => 'Camping', 'icon' => 'fa-solid fa-campground'],
        ];
    }

    private function getPopularDestinations(): array {
        return [
            ['city' => 'Kathmandu', 'desc' => 'Capital city', 'icon' => 'fa-place-of-worship', 'color' => 'orange'],
            ['city' => 'Lalitpur', 'desc' => 'City of Fine Arts', 'icon' => 'fa-landmark', 'color' => 'rose'],
            ['city' => 'Bhaktapur', 'desc' => 'Historic heritage city', 'icon' => 'fa-gopuram', 'color' => 'amber'],
            ['city' => 'Pokhara', 'desc' => 'Lake city', 'icon' => 'fa-water', 'color' => 'blue'],
            ['city' => 'Chitwan', 'desc' => 'Jungle safari', 'icon' => 'fa-tree', 'color' => 'green'],
            ['city' => 'Janakpur', 'desc' => 'City of temples', 'icon' => 'fa-place-of-worship', 'color' => 'purple'],
            ['city' => 'Hetauda', 'desc' => 'Industrial city', 'icon' => 'fa-industry', 'color' => 'gray'],
            ['city' => 'Birgunj', 'desc' => 'Gateway to Nepal', 'icon' => 'fa-truck', 'color' => 'red'],
            ['city' => 'Bharatpur', 'desc' => 'Medical & tourism hub', 'icon' => 'fa-hospital', 'color' => 'emerald'],
        ];
    }

    private function getListingCardColumns(): array {
        return [
            'id',
            'slug',
            'title',
            'image', 
            'listing_type',
            'instant_bookable',
            'city',
            'province',
            'base_price',
            'minimum_nights',
            'category_id'
        ];
    }

    public function homePage(Request $request) {
        $propertyTypes = $this->getPropertyTypes();
        $selectedType = $request->get('type', 'all');
        $columns = $this->getListingCardColumns();

        $baseQuery = Listing::select($columns)
            ->where('status', true)
            ->with(['reviews' => fn($q) => $q->select('listing_id', 'overall_rating')]); 
        
        if ($selectedType !== 'all' && array_key_exists($selectedType, $propertyTypes)) {
            $baseQuery->where('listing_type', $selectedType);
        }

        $featuredProperties = (clone $baseQuery)->where('display_on', 'featured')->orderBy('order_level', 'desc')->take(10)->get();
        $homestays = (clone $baseQuery)->where('display_on', 'homestays')->take(10)->get();
        $nearby = (clone $baseQuery)->where('display_on', 'nearby')->take(10)->get();
        $recommended = (clone $baseQuery)->where('display_on', 'recommended')->inRandomOrder()->take(15)->get();
        
        $categories = Category::where('status', true)->orderBy('order_level', 'asc')->get();

        return Inertia::render('Home', [
            'propertyTypes'       => $propertyTypes,
            'popularDestinations' => $this->getPopularDestinations(),
            'selectedType'        => $selectedType,
            'categories'          => $categories,
            'featuredProperties'  => $featuredProperties,
            'homestays'           => $homestays,
            'nearby'              => $nearby,
            'recommended'         => $recommended,
        ]);
    }


    public function experiencePage(Request $request){
        $propertyTypes = $this->getPropertyTypes();
        $selectedType = $request->get('type', 'all');
        $columns = $this->getListingCardColumns();
        
        $experienceCategory = Category::where('slug', 'experiences')->first();
        $categoryIds = $experienceCategory ? array_merge([$experienceCategory->id], $experienceCategory->getAllDescendantIds()) : [];

        $baseQuery = Listing::select($columns)
            ->where('status', true)
            ->with(['reviews' => fn($q) => $q->select('listing_id', 'overall_rating')]);

        if (!empty($categoryIds)) {
            $baseQuery->whereIn('category_id', $categoryIds);
        }

        if ($selectedType !== 'all' && array_key_exists($selectedType, $propertyTypes)) {
            $baseQuery->where('listing_type', $selectedType);
        }

        $experiences = $baseQuery->inRandomOrder()->get();

        return Inertia::render('Experience', [
            'experiences'         => $experiences,
            'propertyTypes'       => $propertyTypes,
            'selectedType'        => $selectedType,
            'popularDestinations' => $this->getPopularDestinations(),
        ]);
    }

    public function servicesPage(Request $request) {
        $propertyTypes = $this->getPropertyTypes();
        $selectedType = $request->get('type', 'all');
        $columns = $this->getListingCardColumns();

        $servicesCategory = Category::where('slug', 'services')->first();
        $categoryIds = $servicesCategory ? array_merge([$servicesCategory->id], $servicesCategory->getAllDescendantIds()) : [];

        $baseQuery = Listing::select($columns)
            ->where('status', true)
            ->with(['reviews' => fn($q) => $q->select('listing_id', 'overall_rating')]);

        if (!empty($categoryIds)) {
            $baseQuery->whereIn('category_id', $categoryIds);
        }

        if ($selectedType !== 'all' && array_key_exists($selectedType, $propertyTypes)) {
            $baseQuery->where('listing_type', $selectedType);
        }

        $services = $baseQuery->inRandomOrder()->get();

        return Inertia::render('Services', [
            'services'            => $services,
            'propertyTypes'       => $propertyTypes,
            'selectedType'        => $selectedType,
            'popularDestinations' => $this->getPopularDestinations(),
        ]);
    }

    public function propertyDetails($slug) {
        $listing = Listing::where('slug', $slug)
            ->where('status', true)
            ->with(['user', 'category', 'amenities', 'availabilities', 'reviews'])
            ->firstOrFail();
            
        $listing->increment('views');
        $reviews = $listing->reviews; 
        $totalReviews = $reviews->count();
        
        if ($totalReviews > 0) {
            $avgOverall = round($reviews->avg('overall_rating'), 1);
            $avgCleanliness = round($reviews->avg('cleanliness'), 1);
            $avgAccuracy = round($reviews->avg('accuracy'), 1);
            $avgCheckIn = round($reviews->avg('check_in'), 1);
            $avgLocation = round($reviews->avg('location'), 1);
            $avgValue = round($reviews->avg('value'), 1);
        } else {
            $avgOverall = $avgCleanliness = $avgAccuracy = $avgCheckIn = $avgLocation = $avgValue = 0;
        }

        $calendarData = [];
        foreach ($listing->availabilities as $avail) {
            $dateKey = \Carbon\Carbon::parse($avail->date)->format('Y-m-d');
            $calendarData[$dateKey] = [
                'status' => $avail->status, 
                'price' => $avail->custom_price ? (float) $avail->custom_price : null
            ];
        }

        return Inertia::render('PropertyDetails', [
            'listing'        => $listing,
            'calendarData'   => $calendarData,
            'totalReviews'   => $totalReviews,
            'reviews'        => $reviews->take(6), 
            'avgOverall'     => $avgOverall,
            'avgCleanliness' => $avgCleanliness,
            'avgAccuracy'    => $avgAccuracy,
            'avgCheckIn'     => $avgCheckIn,
            'avgLocation'    => $avgLocation,
            'avgValue'       => $avgValue,
        ]);
    }

    public function searchPage(Request $request) {
        $location = $request->get('location');
        $checkIn = $request->get('checkIn');
        $checkOut = $request->get('checkOut');
        $adults = (int) $request->get('adults', 0);
        $children = (int) $request->get('children', 0);
        $totalGuests = $adults + $children;
        
        $selectedType = $request->get('type', 'all');
        $propertyTypes = $this->getPropertyTypes();
        $columns = $this->getListingCardColumns();

        $baseQuery = Listing::select($columns)
            ->where('status', true)
            ->with(['reviews' => fn($q) => $q->select('listing_id', 'overall_rating')]);

        if ($location) {
            $baseQuery->where(function($q) use ($location) {
                $q->where('city', 'like', "%{$location}%")
                  ->orWhere('province', 'like', "%{$location}%")
                  ->orWhere('title', 'like', "%{$location}%");
            });
        }

        if ($totalGuests > 0) {
            $baseQuery->where('guests', '>=', $totalGuests);
        }

        if ($checkIn && $checkOut) {
            $baseQuery->whereDoesntHave('availabilities', function ($query) use ($checkIn, $checkOut) {
                $query->whereBetween('date', [$checkIn, $checkOut])
                      ->whereIn('status', ['blocked', 'booked']);
            });
        }

        if ($selectedType !== 'all' && array_key_exists($selectedType, $propertyTypes)) {
            $baseQuery->where('listing_type', $selectedType);
        }

        $searchResults = $baseQuery->orderBy('order_level', 'desc')->paginate(15)->withQueryString();

        return Inertia::render('SearchListing', [
            'searchResults'       => $searchResults,
            'searchParams'        => [
                'location' => $location,
                'checkIn' => $checkIn,
                'checkOut' => $checkOut,
                'adults' => $adults,
                'children' => $children,
            ],
            'propertyTypes'       => $propertyTypes,
            'selectedType'        => $selectedType,
            'popularDestinations' => $this->getPopularDestinations(),
        ]);
    }
}