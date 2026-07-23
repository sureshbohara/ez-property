<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Listing;
use App\Models\Category;
use App\Models\Setting;
use App\Http\Resources\WebSettingResource;
use App\Http\Resources\ListingResource;
use App\Http\Resources\ListingDetailsResource; 
use App\Http\Resources\CategoryResource;
use App\Models\Page;
use App\Models\Faq;
class IndexController extends Controller
{
    
    public function getSettingData() {
        $setting = Setting::firstOrFail();
        return response()->json([
            'status' => 200,
            'message' => 'Data retrieved successfully',
            'datas' => new WebSettingResource($setting),
        ]);
    }

    public function getHomeData(Request $request) {
        $propertyTypes = $this->getPropertyTypes();
        $selectedType = $request->get('type', 'all');
        $columns = $this->getListingCardColumns();

        $baseQuery = Listing::select($columns)
        ->where('status', true)
        ->with(['reviews' => fn($q) => $q->select('listing_id', 'overall_rating')]); 

        if ($selectedType !== 'all' && array_key_exists($selectedType, $propertyTypes)) {
            $baseQuery->where('listing_type', $selectedType);
        }

        $data = [
            'propertyTypes'       => $propertyTypes,
            'popularDestinations' => $this->getPopularDestinations(),
            'categories'          => CategoryResource::collection(Category::where('status', true)->orderBy('order_level', 'asc')->get()),
            'featuredProperties'  => ListingResource::collection((clone $baseQuery)->where('display_on', 'featured')->orderBy('order_level', 'desc')->take(10)->get()),
            'homestays'           => ListingResource::collection((clone $baseQuery)->where('display_on', 'homestays')->take(10)->get()),
            'nearby'              => ListingResource::collection((clone $baseQuery)->where('display_on', 'nearby')->take(10)->get()),
            'recommended'         => ListingResource::collection((clone $baseQuery)->where('display_on', 'recommended')->inRandomOrder()->take(15)->get()),
        ];

        return response()->json([
            'status' => true,
            'data' => $data
        ]);
    }

    public function getAllData() {
        $properties = Listing::where('status', true)
        ->select($this->getListingCardColumns())
        ->orderBy('created_at', 'desc')
        ->get();

        return response()->json([
            'status' => true,
            'data' => ListingResource::collection($properties)
        ]);
    }


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


    

      public function search(Request $request) {
        $location = $request->get('location');
        $type = $request->get('type', 'all');
        $guests = (int) $request->get('guests', 0);
        $query = Listing::where('status', true)
            ->with(['reviews' => fn($q) => $q->select('listing_id', 'overall_rating')]);
        if ($location) {
            $query->where(function($q) use ($location) {
                $q->where('city', 'like', "%{$location}%")
                  ->orWhere('province', 'like', "%{$location}%")
                  ->orWhere('title', 'like', "%{$location}%");
            });
        }
        if ($guests > 0) {
            $query->where('guests', '>=', $guests);
        }
        if ($type !== 'all') {
            $query->where('listing_type', $type);
        }
        $results = $query->orderBy('order_level', 'desc')->paginate(15);
        return response()->json([
            'status' => true,
            'data' => ListingResource::collection($results)
        ]);
    }


    public function getPropertyDetails($slug) {
        $listing = Listing::where('slug', $slug)
        ->where('status', true)
            ->with(['user', 'category', 'amenities', 'availabilities', 'reviews']) 
            ->firstOrFail();
            $listing->increment('views');
            return response()->json([
                'status' => true,
                'data' => new ListingDetailsResource($listing)
            ]);
        }



     public function getPage($slug) {
        $page = Page::where('slug', $slug)->where('status', true)->firstOrFail();
        return response()->json([
            'status' => true,
            'data' => $page
        ]);
      }


    public function getFaqs() {
        $faqs = Faq::active()->ordered()->get();
        return response()->json([
            'status' => true,
            'data' => $faqs
        ]);
    }

    



    }