For future update changes:

git add .
git commit -m "Updated project"
git push

















my code this type <?php

use Illuminate\Support\Facades\Route;

// ─── Core Admin Controllers ────────────────────────────────────
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CkeditorController;
use App\Http\Controllers\Admin\SiteHealthController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\LoginActivityController;

// ─── Resource/CRUD Controllers ─────────────────────────────────
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\ReviewController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServiceController;
use App\Http\Controllers\Admin\FaqController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\FleetController;
use App\Http\Controllers\Admin\TeamController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\PostController;

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

// ─── Guest Routes (Login) ──────────────────────────────────────
Route::middleware('admin.guest')->group(function () {
    Route::get('/admin', [AuthController::class, 'showLogin'])->name('admin.login');
    Route::post('/admin/login', [AuthController::class, 'login'])->name('admin.login.submit');
});

// ─── Authenticated Admin Routes ────────────────────────────────
Route::prefix('admin')
->middleware(['auth:admin'])
->name('admin.') 
->group(function () {

        // ─── Dashboard ───────────────────────
    Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard'); 
    Route::get('/dashboard/live', [DashboardController::class, 'getLiveStats'])->name('dashboard.live');

        // ─── Authentication & Profile ────────
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 
    Route::get('/profile', [AuthController::class, 'showProfile'])->name('profile.edit'); 
    Route::post('/profile', [AuthController::class, 'updateProfile'])->name('profile.update');

    Route::get('/change-password', [AuthController::class, 'showChangePassword'])->name('password.edit');
    Route::post('/change-password', [AuthController::class, 'updatePassword'])->name('password.update')->middleware('throttle:3,1');
    Route::delete('/account', [AuthController::class, 'deleteAccount'])->name('account.destroy'); 

        // ─── Site Settings ───────────────────
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

        // ─── CKEditor Image Uploads ──────────
    Route::post('/ckeditor/upload', [CkeditorController::class, 'ckeditorUpload'])->name('ckeditor.upload');
    Route::post('/ckeditor/delete', [CkeditorController::class, 'ckeditorDeleteImage'])->name('ckeditor.delete');

        // ─── Site Health Check ───────────────
    Route::get('/site-health', [SiteHealthController::class, 'index'])->name('site.health');

        // ─── Login Activities ────────────────
    Route::get('/login-activities', [LoginActivityController::class, 'index'])->name('login-activities.index');
    Route::delete('/login-activities/bulk-delete', [LoginActivityController::class, 'bulkDelete'])->name('login-activities.bulk-delete');


        // ==========================================
        // Permissions Management
        // ==========================================
    Route::resource('permission', PermissionController::class)->except(['show']);

        // ==========================================
        // Admin Users Management
        // ==========================================
    Route::post('user/status', [AdminController::class, 'userStatus'])->name('user.status');
    Route::post('user/order-level', [AdminController::class, 'updateOrderLevel'])->name('user.order-level');
    Route::resource('user', AdminController::class)->except(['show']);

        // ==========================================
        // Banners
        // ==========================================
    Route::post('banner/status', [BannerController::class, 'bannerStatus'])->name('banner.status');
    Route::post('banner/order-level', [BannerController::class, 'updateOrderLevel'])->name('banner.order-level');
    Route::resource('banner', BannerController::class)->except(['show']);

        // ==========================================
        // Reviews
        // ==========================================
    Route::post('review/status', [ReviewController::class, 'reviewStatus'])->name('review.status');
    Route::post('review/order-level', [ReviewController::class, 'updateOrderLevel'])->name('review.order-level');
    Route::resource('review', ReviewController::class)->except(['show']);

        // ==========================================
        // Galleries
        // ==========================================
    Route::post('gallery/status', [GalleryController::class, 'galleryStatus'])->name('gallery.status');
    Route::post('gallery/order-level', [GalleryController::class, 'updateOrderLevel'])->name('gallery.order-level');
    Route::resource('gallery', GalleryController::class)->except(['show']);

        // ==========================================
        // Categories
        // ==========================================
    Route::post('category/status', [CategoryController::class, 'toggleStatus'])->name('category.status');
    Route::post('category/order-level', [CategoryController::class, 'updateOrderLevel'])->name('category.order-level');
    Route::resource('category', CategoryController::class)->except(['show']);

        // ==========================================
        // Services
        // ==========================================
    Route::post('service/status', [ServiceController::class, 'serviceStatus'])->name('service.status');
    Route::post('service/order-level', [ServiceController::class, 'updateOrderLevel'])->name('service.order-level');
    Route::resource('service', ServiceController::class)->except(['show']);

        // ==========================================
        // Fleet
        // ==========================================
    Route::post('fleet/status', [FleetController::class, 'fleetStatus'])->name('fleet.status');
    Route::post('fleet/order-level', [FleetController::class, 'updateOrderLevel'])->name('fleet.order-level');
    Route::resource('fleet', FleetController::class)->except(['show']);

        // ==========================================
        // FAQs
        // ==========================================
    Route::post('faq/status', [FaqController::class, 'faqStatus'])->name('faq.status');
    Route::post('faq/order-level', [FaqController::class, 'updateOrderLevel'])->name('faq.order-level');
    Route::resource('faq', FaqController::class)->except(['show']);

        // ==========================================
        // Menus
        // ==========================================
    Route::post('menu/status', [MenuController::class, 'menuStatus'])->name('menu.status');
    Route::post('menu/order-level', [MenuController::class, 'updateOrderLevel'])->name('menu.order-level');
    Route::resource('menu', MenuController::class)->except(['show']);

        // ==========================================
        // Team Members
        // ==========================================
    Route::post('team/status', [TeamController::class, 'teamStatus'])->name('team.status');
    Route::post('team/order-level', [TeamController::class, 'updateOrderLevel'])->name('team.order-level');
    Route::resource('team', TeamController::class)->except(['show']);

        // ==========================================
        // Pages (About, Contact, Terms, Privacy, etc.)
        // ==========================================
    Route::post('page/status', [PageController::class, 'pageStatus'])->name('page.status');
    Route::post('page/order-level', [PageController::class, 'updateOrderLevel'])->name('page.order-level');
    Route::resource('page', PageController::class)->except(['show']);



        // ==========================================
     // Blog / Posts
     // ==========================================
     Route::post('post/status', [PostController::class, 'toggleStatus'])->name('post.status');
     Route::post('post/featured', [PostController::class, 'toggleFeatured'])->name('post.featured');
     Route::post('post/order-level', [PostController::class, 'updateOrderLevel'])->name('post.order-level');
     Route::resource('post', PostController::class)->except(['show']);


});


<?php

namespace App\Traits;

trait HasImages
{
    public function getImageUrlAttribute(): string
    {
        return $this->resolveImage($this->image);
    }

    public function getFeatureImageUrlAttribute(): string
    {
        return $this->resolveImage($this->feature_image ?? null);
    }

    protected function resolveImage(?string $path): string
    {
        if (empty($path)) {
            return asset('default/noimage.png');
        }

        if (filter_var($path, FILTER_VALIDATE_URL)) {
            return $path;
        }

        return asset('storage/' . $path);
    }
}

<?php

namespace App\Traits;

use Illuminate\Support\Str;

trait Slugable
{
    protected static function bootSlugable(): void
    {
        static::creating(function ($model) {
            if (empty($model->slug)) {
                $model->slug = static::generateUniqueSlug($model);
            }
        });

        static::updating(function ($model) {
            if ($model->isDirty('name') || $model->isDirty('title')) {
                $model->slug = static::generateUniqueSlug($model);
            }
        });
    }

    protected static function generateUniqueSlug($model): string
    {
        $source = $model->name ?? $model->title ?? '';
        $slug = Str::slug($source);
        $originalSlug = $slug;
        $count = 1;

        while (static::where('slug', $slug)->where('id', '!=', $model->id ?? 0)->exists()) {
            $slug = "{$originalSlug}-{$count}";
            $count++;
        }

        return $slug;
    }
}


<?php

namespace App\Services\Admin;

use App\Models\Banner;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class BannerService
{


 
    public function __construct(protected Banner $banner, protected MediaService $mediaService) {}


    // Fetch paginated banners filtered by status and title
    public function getBanners(array $filters = []){
        return $this->banner->query()
            ->when(!empty($filters['status']), function ($q) use ($filters) {
                $status = filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN);
                $q->where('status', $status);
            })
            ->when(!empty($filters['title']), function ($q) use ($filters) {
                $q->where('title', 'like', '%' . $filters['title'] . '%');
            })
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }


    public function storeBanner(array $data){
        return DB::transaction(function () use ($data) {
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }
            return $this->banner->create($data);
        });
    }


    public function updateBanner(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $banner = $this->banner->findOrFail($id);

            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($banner->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($banner->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }

            $banner->update($data);
            return $banner->fresh();
        });
    }


    public function deleteBanner(int $id): bool
    {
        $banner = $this->banner->findOrFail($id);
        if ($banner->image) {
            $this->mediaService->deleteImageVariants($banner->image);
        }
        return $banner->delete();
    }



    public function toggleStatus(int $id): bool
    {
        $banner = $this->banner->findOrFail($id);
        $banner->status = !$banner->status;
        $banner->save();
        return $banner->status;
    }


    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $banner = $this->banner->findOrFail($id);
        $banner->order_level = $orderLevel;
        $banner->save();
        return true;
    }
}


<?php

namespace App\Services\Admin;

use App\Models\Service;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ServiceService
{
    public function __construct(protected Service $service, protected MediaService $mediaService) {}

    public function getServices(array $filters = []){
        return $this->service->query()
            ->when(!empty($filters['status']), fn($q) => $q->where('status', filter_var($filters['status'], FILTER_VALIDATE_BOOLEAN)))
            ->when(!empty($filters['title']), fn($q) => $q->where('title', 'like', '%'.$filters['title'].'%'))
            ->ordered()
            ->paginate(15)
            ->appends($filters);
    }

    public function storeService(array $data){
        return DB::transaction(function () use ($data) {
                       
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            }
            
            if (isset($data['feature_image']) && $data['feature_image'] instanceof UploadedFile) {
                $path = $this->mediaService->uploadImage($data['feature_image'], 'features');
                $this->mediaService->dispatchImageProcessing($path);
                $data['feature_image'] = $path;
            }
            
            return $this->service->create($data);
        });
    }

    public function updateService(int $id, array $data){
        return DB::transaction(function () use ($id, $data) {
            $service = $this->service->findOrFail($id);

            
            if (isset($data['image']) && $data['image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($service->image);
                $path = $this->mediaService->uploadImage($data['image']);
                $this->mediaService->dispatchImageProcessing($path);
                $data['image'] = $path;
            } elseif (array_key_exists('image', $data) && $data['image'] === null) {
                $this->mediaService->deleteImageVariants($service->image);
                $data['image'] = null;
            } else {
                unset($data['image']);
            }
            
            if (isset($data['feature_image']) && $data['feature_image'] instanceof UploadedFile) {
                $this->mediaService->deleteImageVariants($service->feature_image);
                $path = $this->mediaService->uploadImage($data['feature_image'], 'features');
                $this->mediaService->dispatchImageProcessing($path);
                $data['feature_image'] = $path;
            } elseif (array_key_exists('feature_image', $data) && $data['feature_image'] === null) {
                $this->mediaService->deleteImageVariants($service->feature_image);
                $data['feature_image'] = null;
            } else {
                unset($data['feature_image']);
            }
            
            $service->update($data);
            return $service->fresh();
        });
    }


    public function deleteService(int $id): bool
    {
        $service = $this->service->findOrFail($id);
        
        if ($service->image) {
            $this->mediaService->deleteImageVariants($service->image);
        }
        if ($service->feature_image) {
            $this->mediaService->deleteImageVariants($service->feature_image);
        }
        
        return $service->delete();
    }


    public function toggleStatus(int $id): bool
    {
        $service = $this->service->findOrFail($id);
        $service->status = !$service->status;
        $service->save();
        return $service->status;
    }


    public function updateOrderLevel(int $id, int $orderLevel): bool
    {
        $service = $this->service->findOrFail($id);
        $service->order_level = $orderLevel;
        $service->save();
        return true;
    }


    
}

<?php

namespace App\Services\Admin;

use App\Models\Setting;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;

class SettingService
{

    public function __construct(protected MediaService $mediaService) {}

    public function getSettings(): array
    {
        return Setting::getInstance()->toArray();
    }

    public function updateSettings(array $data): Setting
    {
        return DB::transaction(function () use ($data) {
            $setting = Setting::getInstance();
            $imageFields = [
                'logo', 'favicon', 'loader', 'footer_gateway_img', 
                'bg_image', 'breadcrumb', 'image1', 'image2'
            ];

            foreach ($imageFields as $field) {
                if (isset($data[$field]) && $data[$field] instanceof UploadedFile) {
                    if ($setting->{$field}) {
                        $this->mediaService->deleteImageVariants($setting->{$field});
                    }
                    $path = $this->mediaService->uploadImage($data[$field], 'settings');
                    $this->mediaService->dispatchImageProcessing($path);
                    $data[$field] = $path;
                } 
                elseif (array_key_exists($field, $data) && $data[$field] === null) {
                    if ($setting->{$field}) {
                        $this->mediaService->deleteImageVariants($setting->{$field});
                    }
                    $data[$field] = null;
                } 
                else {
                    unset($data[$field]);
                }
            }
            $setting->update($data);
            return $setting->fresh();
        });
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Traits\HasImages;

class Banner extends Model
{
    use HasFactory, HasImages;

    protected $fillable = [
        'title',
        'subtitle', 
        'image',
        'description',
        'order_level',
        'status',
    ];

    protected $casts = [
        'status'      => 'boolean',
        'order_level' => 'integer',
    ];

    // Query scope to filter only enabled/active banners
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Query scope to sort by display order ascending, then newest first
    public function scopeOrdered($query)
    {
        return $query->orderBy('order_level', 'asc')
                    ->orderBy('created_at', 'desc');
    }

    // Query scope to search banners by matching title or subtitle
    public function scopeSearch($query, string $term)
    {
        return $query->where('title', 'like', "%{$term}%")
                    ->orWhere('subtitle', 'like', "%{$term}%");
    }
}

<?php

namespace App\Models;

use App\Traits\Slugable;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Service extends Model
{
    use HasFactory, Slugable, HasImages;

    protected $table = 'services';

    protected $fillable = [
        'title',
        'subtitle',
        'icon',
        'short_content',
        'long_content',
        'slug',
        'image',
        'feature_image',
        'process_title',
        'process_sub_title',
        'process_item',
        'highlight',
        'order_level',
        'status',
        'meta_keywords',
        'meta_description',
    ];

    protected $casts = [
        'process_item'  => 'array',
        'highlight'     => 'array',
        'status'        => 'boolean',
        'order_level'   => 'integer',
    ];

    public function scopeActive($query): void
    {
        $query->where('status', true);
    }

    public function scopeOrdered($query): void
    {
        $query->orderBy('order_level', 'asc')
              ->orderBy('created_at', 'desc');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Traits\HasImages;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Setting extends Model
{
   
   use HasFactory, HasImages;
    protected $table = 'settings';

   
    protected $fillable = [
        // General Information
        'system_name',
        'email',
        'extra_email',
        'phone',
        'extra_phone',
        'address',
        'opening_hr',
        'work_hours',
        'google_map',
        'footer_copyright',

        // Social Media Links
        'facebook',
        'twitter',
        'linkedin',
        'instagram',
        'youtube',
        'google',
        'yelp',

        // Media & Images
        'logo',
        'favicon',
        'loader',
        'footer_gateway_img',
        'bg_image',
        'breadcrumb',
        'image1',
        'image2',

        // SEO Meta Tags
        'meta_author',
        'meta_title',
        'meta_keywords',
        'meta_description',

        // Information Blocks (1-7)
        'info1',
        'info2',
        'info3',
        'info4',
        'info5',
        'info6',
        'info7',

        // SMTP / Mail Configuration
        'mail_transport',
        'mail_host',
        'mail_port',
        'mail_username',
        'mail_password',
        'mail_encryption',
        'mail_from',
        'mail_from_name',
        'smtp_check',

        // Recaptcha
        'recaptcha_site_key',
        'recaptcha_secret_key',
        'is_recaptcha',

        // Google API & Analytics
        'google_analytic_id',
        'google_client_id',
        'google_client_secret',
        'google_redirect',
        'is_google',

        // Facebook API & Analytics
        'facebook_analytic_id',
        'facebook_client_id',
        'facebook_client_secret',
        'facebook_redirect',
        'is_facebook',

        // Process Section Dynamic Content
        'process_title',
        'process_sub_title',
        'process_item',

        // Work Section Dynamic Content
        'work_title',
        'work_sub_title',
        'work_item',

        // Counter Section Dynamic Content
        'counter_title',
        'counter_sub_title',
        'counter_item',

  
    ];

  
     protected $casts = [
        'process_item' => 'array', 'work_item' => 'array', 'counter_item' => 'array',
        'smtp_check' => 'boolean', 'is_recaptcha' => 'boolean', 'is_google' => 'boolean', 'is_facebook' => 'boolean',
    ];

   
    public static function getInstance(): self
    {
        return static::firstOrCreate(
            ['id' => 1],
            ['system_name' => config('app.name')]
        );
    }
   

    protected $appends = [
        'logo_url',
        'favicon_url',
        'loader_url',
        'bg_image_url',
        'footer_gateway_img_url',
        'breadcrumb_url',
        'image1_url',
        'image2_url',
    ];


    public function getLogoUrlAttribute(): string
    {
        return $this->resolveImage($this->logo);
    }

    public function getFaviconUrlAttribute(): string
    {
        return $this->resolveImage($this->favicon);
    }

    public function getLoaderUrlAttribute(): string
    {
        return $this->resolveImage($this->loader);
    }

    public function getBgImageUrlAttribute(): string
    {
        return $this->resolveImage($this->bg_image);
    }

    public function getFooterGatewayImgUrlAttribute(): string
    {
        return $this->resolveImage($this->footer_gateway_img);
    }

    public function getBreadcrumbUrlAttribute(): string
    {
        return $this->resolveImage($this->breadcrumb);
    }

    public function getImage1UrlAttribute(): string
    {
        return $this->resolveImage($this->image1);
    }

    public function getImage2UrlAttribute(): string
    {
        return $this->resolveImage($this->image2);
    }
}

<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class ProcessImage implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $timeout = 120;
    public $tries = 3;
    public $backoff = [10, 30];

    public function __construct(
        public string $imagePath,
        public string $disk = 'public',
        public array $sizes = ['thumb' => [150, 150], 'medium' => [400, 400]]
    ) {}

    public function handle(): void
    {
        if (!Storage::disk($this->disk)->exists($this->imagePath)) {
            Log::warning("Image not found: {$this->imagePath}");
            return;
        }

        try {
            $manager = new ImageManager(new Driver());
            $originalPath = Storage::disk($this->disk)->path($this->imagePath);
            $image = $manager->read($originalPath);

            foreach ($this->sizes as $label => [$width, $height]) {
                $resized = $image->cover($width, $height, 'center');
                $newPath = $this->generateVariantPath($this->imagePath, $label);
                $resized->save(Storage::disk($this->disk)->path($newPath), 85);
                Log::info("Variant created: {$newPath}");
            }

            $image->save($originalPath, 85);
        } catch (\Exception $e) {
            Log::error("Image processing failed: " . $e->getMessage());
            throw $e;
        }
    }

    protected function generateVariantPath(string $original, string $variant): string
    {
        $path = pathinfo($original);
        return "{$path['dirname']}/{$path['filename']}-{$variant}.{$path['extension']}";
    }
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\BannerRequest;
use App\Services\Admin\BannerService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Banner;

class BannerController extends BaseController
{

    public function __construct(protected BannerService $service) {
        $this->middleware('auth:admin');
        $this->middleware('can:banner.read')->only('index');
        $this->middleware('can:banner.create')->only(['create', 'store']);
        $this->middleware('can:banner.update')->only(['edit', 'update', 'bannerStatus', 'updateOrderLevel']);
        $this->middleware('can:banner.delete')->only('destroy');
    }



    public function index(Request $request)
    {
        $filters = $request->only('status', 'title');
        return view('admin.banner.index', [
            'banners' => $this->service->getBanners($filters),
            'filters' => $filters,
        ]);
    }



    public function create(){
        return view('admin.banner.form');
    }

  
    public function store(BannerRequest $request): JsonResponse
    {
        $banner = $this->service->storeBanner($request->validated());
        return $this->successJson('Banner created!', $banner, 201);
    }




    public function edit(Banner $banner)
    {
        return view('admin.banner.form', ['banner' => $banner]);
    }



    public function update(BannerRequest $request, Banner $banner): JsonResponse
    {
        $updated = $this->service->updateBanner($banner->id, $request->validated());
        return $this->successJson('Banner updated!', $updated);
    }



    public function destroy(Banner $banner)
    {
        $this->service->deleteBanner($banner->id);
        return redirect()->back()->with('success', 'Banner deleted permanently!');
    }



    public function bannerStatus(Request $request): JsonResponse
    {
        $request->validate(['status_id' => 'required|exists:banners,id']);
        $newStatus = $this->service->toggleStatus($request->status_id);
        return $this->successJson('Status updated', ['new_status' => $newStatus]);
    }



    public function updateOrderLevel(Request $request): JsonResponse
    {
        $request->validate([
            'id'          => 'required|exists:banners,id',
            'order_level' => 'required|integer|min:0',
        ]);
        $this->service->updateOrderLevel($request->id, $request->order_level);
        return $this->successJson('Order updated!');
    }

    
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\ServiceRequest;
use App\Services\Admin\ServiceService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Models\Service;

class ServiceController extends BaseController
{
    public function __construct(protected ServiceService $service) {
       $this->middleware('auth:admin');
       $this->middleware('can:service.read')->only('index');
       $this->middleware('can:service.create')->only(['create', 'store']);
       $this->middleware('can:service.update')->only(['edit', 'update', 'serviceStatus', 'updateOrderLevel']);
       $this->middleware('can:service.delete')->only('destroy');
   }

   public function index(Request $request){
    $filters = $request->only('status', 'title');
    return view('admin.service.index', [
        'services' => $this->service->getServices($filters),
        'filters' => $filters,
    ]);
}

public function create(){
    return view('admin.service.form');
}

public function store(ServiceRequest $request): JsonResponse
{
    $service = $this->service->storeService($request->validated());
    return $this->successJson('Service created!', $service, 201);
}

public function edit(Service $service){
    return view('admin.service.form', ['service' => $service]);
}

public function update(ServiceRequest $request, Service $service): JsonResponse
{
    $updated = $this->service->updateService($service->id, $request->validated());
    return $this->successJson('Service updated!', $updated);
}

public function destroy(Service $service){
    $this->service->deleteService($service->id);
    return redirect()->back()->with('success', 'Service deleted permanently!');
}

public function serviceStatus(Request $request): JsonResponse
{
    $request->validate(['status_id' => 'required|exists:services,id']);
    $newStatus = $this->service->toggleStatus($request->status_id);
    return $this->successJson('Status updated', ['new_status' => $newStatus]);
}

public function updateOrderLevel(Request $request): JsonResponse
{
    $request->validate([
        'id' => 'required|exists:services,id',
        'order_level' => 'required|integer|min:0',
    ]);
    $this->service->updateOrderLevel($request->id, $request->order_level);
    return $this->successJson('Order updated!');
}
}

<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\Admin\SettingRequest;
use App\Services\Admin\SettingService;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;

class SettingController extends BaseController
{
    public function __construct(protected SettingService $service)
    {
        $this->middleware('auth:admin');
        $this->middleware('can:setting.read')->only('index');
        $this->middleware('can:setting.update')->only('update');
    }

    public function index(): View
    {

        $setting = $this->service->getSettings();
        return view('admin.settings.index', compact('setting'));
    }

    public function update(SettingRequest $request): JsonResponse
    {

        $this->service->updateSettings($request->validated());
        return $this->successJson('Settings updated successfully!');
    }
}


banner index is 

@extends('layouts.app')

@section('title', 'Manage Banners')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Banners" subTitle="Banner List" :breadcrumbItems="['Dashboard', 'Banners']"/>

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">🖼️ Banners</h6>
            <a href="{{ route('admin.banner.create') }}" class="btn btn-light btn-sm">
                <i class="bi bi-plus-lg"></i> Create New
            </a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.banner.search')</div>
            <div class="row">@include('admin.banner.table')</div>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.banner.status") }}', 'Banner status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.banner.order-level") }}', 'Banner order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush


banner form is 

@extends('layouts.app')

@section('title', isset($banner) ? 'Edit Banner' : 'Create Banner')

@section('content')
<main class="page-content">
    <x-breadcrumb
        title="Manage Banners"
        subTitle="{{ isset($banner) ? 'Update Banner' : 'Create Banner' }}"
        :breadcrumbItems="['Dashboard', 'Banners']"
    />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">
                <i class="bi bi-images me-2"></i>
                {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
            </h6>
            <a href="{{ route('admin.banner.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left me-1"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="bannerForm" method="POST" enctype="multipart/form-data"
                  action="{{ isset($banner) ? route('admin.banner.update', $banner->id) : route('admin.banner.store') }}">
                @csrf
                @if(isset($banner)) @method('PUT') @endif

                <div class="row g-3">
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Banner Content</h5>
                                <div class="row g-3">

                         
                                    <x-input-field 
                                        type="text" 
                                        name="title" 
                                        label="Title" 
                                        :value="old('title', $banner->title ?? '')" 
                                        cols="col-12" 
                                        required 
                                        placeholder="e.g., Summer Sale 2026"
                                        title="Enter a short, attention-grabbing headline"/>

                              
                                    <x-input-field 
                                        type="text" 
                                        name="subtitle" 
                                        label="Subtitle" 
                                        :value="old('subtitle', $banner->subtitle ?? '')" 
                                        cols="col-12" 
                                        placeholder="e.g., Up to 50% off selected items"
                                        title="Optional supporting text shown below the title"/>

                                
                                    <x-input-field 
                                        type="textarea" 
                                        name="description" 
                                        label="Description" 
                                        :value="old('description', $banner->description ?? '')" 
                                        cols="col-12" 
                                        rows="3" 
                                        editor="true" 
                                        placeholder="Add details, call-to-action, or promotional text..."
                                        title="Optional detailed content (supports rich text formatting)"/>

                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3 border-bottom pb-2">Settings</h5>
                                <div class="row g-3">

                                 
                                    <x-input-field 
                                        type="number" 
                                        name="order_level" 
                                        label="Display Order" 
                                        :value="old('order_level', $banner->order_level ?? '0')" 
                                        cols="col-12" 
                                        min="0" 
                                        placeholder="0 = Highest priority"
                                        title="Lower numbers display first. Use 0 for top priority."/>

                               
                                    <div class="col-12">
                                        <label class="form-label fw-semibold" for="image">Banner Image</label>
                                        <input 
                                            type="file" 
                                            name="image" 
                                            id="image"
                                            class="form-control" 
                                            accept="image/png, image/jpeg, image/webp" 
                                            onchange="previewImage(this, 'imagePreview')"
                                            title="Upload banner image: JPG, PNG, or WebP format">
                                       
                                    </div>

                             
                                    <div class="col-12 text-center">
                                        <img 
                                            src="{{ isset($banner) && $banner->image_url ? $banner->image_url : asset('default/noimage.png') }}" 
                                            alt="Banner Preview" 
                                            class="img-fluid preview-image border" 
                                            id="imagePreview" 
                                            style="max-height: 150px; width: auto; object-fit: cover;">
                                        <small class="text-muted d-block mt-1" id="imageHint">
                                            {{ isset($banner) && $banner->image ? 'Current image' : 'No image selected' }}
                                        </small>
                                    </div>

                                    {{-- Submit button --}}
                                    <div class="col-12 mt-4 pt-2 border-top">
                                        <button type="submit" class="btn btn-primary w-100 py-2">
                                            <i class="bi bi-save me-2"></i> {{ isset($banner) ? 'Update Banner' : 'Create Banner' }}
                                        </button>
                                    </div>
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#bannerForm').on('submit', function(e) {
            e.preventDefault();
            $('.text-danger').remove();
            $('.is-invalid').removeClass('is-invalid');
            
            const formData = new FormData(this);
            const url = $(this).attr('action');
            const submitBtn = $(this).find('button[type="submit"]');
            const originalBtnText = submitBtn.html();
            
            submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Processing...');

            $.ajax({
                type: 'POST',
                url: url,
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                success: function(response) {
                    toastr.success(response.message);
                    setTimeout(() => { window.location.href = '{{ route("admin.banner.index") }}'; }, 1500);
                },
                error: function(xhr) {
                    submitBtn.prop('disabled', false).html(originalBtnText);
                    if (xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            const input = $('[name="' + field + '"]');
                            input.addClass('is-invalid').after('<div class="invalid-feedback d-block">' + errors[0] + '</div>');
                        });
                        toastr.error('Please fix the form errors');
                    } else {
                        toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                    }
                }
            });
        });
    });
</script>
@endpush\
table <div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="120">Image</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th width="100">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($banners as $banner)
                <tr>

                    <td>
                        <img src="{{ $banner->image_url }}" width="80" height="50" style="object-fit: cover;">
                    </td>

                    <td>{{ $banner->title }}</td>

                    <td>{{ Str::limit($banner->subtitle, 30) }}</td>

                    <td>
                        <input type="number" name="order_level"
                        value="{{ $banner->order_level }}"
                        data-id="{{ $banner->id }}"
                        data-original="{{ $banner->order_level }}"
                        class="form-control form-control-sm order-level-input"
                        style="width: 70px;">
                    </td>

                    <td>
                        <form class="status-form" data-id="{{ $banner->id }}">
                            @csrf
                            <input type="hidden" name="status_id" value="{{ $banner->id }}">
                            <input type="checkbox" {{ $banner->status ? 'checked' : '' }}
                            data-toggle="toggle"
                            data-onstyle="success"
                            data-offstyle="danger"
                            data-size="sm"
                            data-width="50">
                        </form>
                    </td>
                    
                    <td>
                        <div class="btn-group btn-group-sm">

                            <a href="{{ route('admin.banner.edit', $banner->id) }}" class="btn btn-primary text-light">
                                <i class="bi bi-pencil"></i>
                            </a>
                            
                            <button type="button" class="btn btn-danger" onclick="confirmDelete(event, 'deleteForm{{ $banner->id }}')">
                                <i class="bi bi-trash"></i>
                            </button>
                        </div>
                        <form action="{{ route('admin.banner.destroy', $banner->id) }}" method="POST" id="deleteForm{{ $banner->id }}" style="display: none;">
                            @csrf
                            @method('DELETE')
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" class="text-center py-4 text-muted">No banners found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    @if($banners->hasPages())
    <nav class="d-flex justify-content-end mt-3">
        {{ $banners->appends(request()->except('page'))->links() }}
    </nav>
    @endif
</div> and search is <div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="title" id="searchInput" class="form-control form-control-sm"
                   placeholder="🔍 Search by title..." value="{{ $filters['title'] ?? '' }}">
        </div>
        <div class="col-md-4">
            <select name="status" id="statusSelect" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="1" {{ ($filters['status'] ?? '') == '1' ? 'selected' : '' }}>✅ Active</option>
                <option value="0" {{ ($filters['status'] ?? '') == '0' ? 'selected' : '' }}>❌ Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.banner.index') }}" class="btn btn-primary w-100 text-white btn-sm" title="Reset Filters">
                <i class="bi bi-x-circle"></i>
            </a>
        </div>
    </form>
</div> same as service 


@extends('layouts.app')
@section('title', 'Manage Services')
@section('content')
<main class="page-content">
    <x-breadcrumb title="Manage Services" subTitle="Service List" :breadcrumbItems="['Dashboard', 'Services']"/>
    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">⚙️ Service List</h6>
            <a href="{{ route('admin.service.create') }}" class="btn btn-light btn-sm"><i class="bi bi-plus-lg"></i> Create New</a>
        </div>
        <div class="card-body bg-light p-3">
            <div class="row mb-3">@include('admin.service.search')</div>
            <div class="row">@include('admin.service.table')</div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    $(document).ready(function() {
        AdminCRUD.initStatusToggle('{{ route("admin.service.status") }}', 'Service status updated!');
        AdminCRUD.initOrderLevel('{{ route("admin.service.order-level") }}', 'Service order updated!');
        AdminCRUD.initFilterAutoSubmit('#filterForm', 300);
    });
</script>
@endpush

<div class="col-12">
    <div class="table-responsive">
        <table class="table table-hover table-striped align-middle">
            <thead class="table-success">
                <tr>
                    <th width="80">Image</th>
                    <th>Title</th>
                    <th>Subtitle</th>
                    <th width="80">Order</th>
                    <th width="100">Status</th>
                    <th width="120">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($services as $service)
                    <tr>

                        <td>
                            <img src="{{ $service->image_url }}" width="60" height="40" style="object-fit: cover;">
                        </td>

                        <td>
                            <strong>{{ $service->title }}</strong>
                            <br><small class="text-muted">/{{ $service->slug }}</small>
                        </td>

                        <td>{{ Str::limit($service->subtitle, 30) }}</td>

                        <td>
                            <input type="number" name="order_level" value="{{ $service->order_level }}" 
                                   data-id="{{ $service->id }}" class="form-control form-control-sm order-level-input" style="width: 60px;">
                        </td>

                        <td>
                            <form class="status-form" data-id="{{ $service->id }}">
                                @csrf
                                <input type="hidden" name="status_id" value="{{ $service->id }}">
                                <input type="checkbox" {{ $service->status ? 'checked' : '' }} 
                                       data-toggle="toggle" data-onstyle="success" data-offstyle="danger" data-size="sm">
                            </form>
                        </td>

                        <td>
                            <div class="btn-group btn-group-sm">
                                <a href="{{ route('admin.service.edit', $service->id) }}" class="btn btn-outline-primary"><i class="bi bi-pencil"></i></a>
                                <button type="button" class="btn btn-outline-danger" onclick="confirmDelete(event, 'deleteForm{{ $service->id }}')"><i class="bi bi-trash"></i></button>
                            </div>
                            <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST" id="deleteForm{{ $service->id }}" style="display: none;">@csrf @method('DELETE')</form>
                        </td>
                        
                    </tr>
                @empty
                    <tr><td colspan="6" class="text-center py-4 text-muted">No services found</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($services->hasPages())
        <nav class="d-flex justify-content-end mt-3">{{ $services->appends($filters ?? [])->links() }}</nav>
    @endif
</div>

@extends('layouts.app')
@section('title', isset($service) ? 'Edit Service' : 'Create Service')

@section('content')
<main class="page-content">
    <x-breadcrumb title="Service" subTitle="{{ isset($service) ? 'Update Service' : 'Create Service' }}" :breadcrumbItems="['Dashboard', 'Service']" />

    <div class="card mb-4">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h6 class="mb-0">{{ isset($service) ? 'Update Service' : 'Create Service' }}</h6>
            <a href="{{ route('admin.service.index') }}" class="btn btn-light btn-sm">
                <i class="bi bi-arrow-left"></i> Back to List
            </a>
        </div>

        <div class="card-body bg-light p-3">
            <form id="serviceForm" method="POST" enctype="multipart/form-data" 
                  action="{{ isset($service) ? route('admin.service.update', $service->id) : route('admin.service.store') }}">
                @csrf
                @if(isset($service)) @method('PUT') @endif
                
                <div class="row g-3">
             
                    <div class="col-lg-8">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Service Information</h5>
                                <div class="row g-3">
                                    <x-input-field type="text" name="title" label="Service Title" :value="old('title', $service->title ?? '')" cols="col-6" required placeholder="Enter service title" />
                                    <x-input-field type="text" name="subtitle" label="Subtitle" :value="old('subtitle', $service->subtitle ?? '')" cols="col-6" placeholder="Enter subtitle" />
                                    <x-input-field type="textarea" name="short_content" label="Short Content" :value="old('short_content', $service->short_content ?? '')" cols="col-12" rows="3" placeholder="Brief description..." />
                                    <x-input-field type="textarea" name="long_content" label="Long Content" :value="old('long_content', $service->long_content ?? '')" cols="col-12" rows="6" placeholder="Detailed description..." editor="true"/>

                                          <div class="col-12 mt-3 pt-3 border-top">
                                        <h6 class="mb-3">SEO Settings</h6>
                                        <div class="row g-3">
                                            <x-input-field 
                                                type="text" 
                                                name="meta_keywords" 
                                                label="Meta Keywords" 
                                                :value="old('meta_keywords', $service->meta_keywords ?? '')" 
                                                cols="col-12" 
                                                placeholder="Comma separated keywords"/>

                                            <x-input-field 
                                                type="text" 
                                                name="meta_description" 
                                                label="Meta Description" 
                                                :value="old('meta_description', $service->meta_description ?? '')" 
                                                cols="col-12" 
                                                placeholder="SEO description (150-160 chars)"/>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

              
                    <div class="col-lg-4">
                        <div class="card shadow-sm h-100">
                            <div class="card-body">
                                <h5 class="card-title mb-3">Settings & Media</h5>
                                <div class="row g-3">




                                    <x-input-field type="text" name="icon" label="Font Icon" :value="old('icon', $service->icon ?? 'fas fa-plane')" cols="col-12"  placeholder="fas fa-plane" />


                                    <x-input-field type="number" name="order_level" label="Display Order" :value="old('order_level', $service->order_level ?? '0')" cols="col-12" min="0" placeholder="0 = highest priority" />
                                    
                                    <div class="col-12">
                                        <label class="form-label">Main Image</label>
                                        <input type="file" name="image" class="form-control" accept="image/*" onchange="previewImage(this, 'imagePreview')">
                                        <small class="text-muted">Max: 2MB</small>
                                    </div>

                                    <div class="col-12 text-center">
                                        <img src="{{ isset($service) && $service->image ? $service->image_url : asset('default/noimage.png') }}" alt="Preview" class="img-fluid rounded preview-image" id="imagePreview" style="max-height: 150px; width: auto;">
                                    </div>

                                    <div class="col-12 mt-2">
                                        <label class="form-label">Feature Image</label>
                                        <input type="file" name="feature_image" class="form-control" accept="image/*" onchange="previewImage(this, 'featureImagePreview')">
                                        <small class="text-muted">Max: 3MB</small>
                                    </div>

                                    <div class="col-12 text-center">
                                        <img src="{{ isset($service) && $service->feature_image ? $service->feature_image_url : asset('default/noimage.png') }}" alt="Preview" class="img-fluid rounded preview-image" id="featureImagePreview" style="max-height: 150px; width: auto;">
                                    </div>

                                    <div class="col-12 mt-4">
                                        <button type="submit" class="btn btn-primary w-100">
                                            <i class="bi bi-save"></i> {{ isset($service) ? 'Update Service' : 'Create Service' }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

       
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-light">
                        <h5 class="mb-0">🔄 Process Steps</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3 mb-3">
                            <div class="col-md-6">

                                <x-input-field type="text" name="process_title" label="Process Title" :value="old('process_title', $service->process_title ?? '')" placeholder="e.g., How It Works" />
                            </div>
                            <div class="col-md-6">
                                <x-input-field type="text" name="process_sub_title" label="Process Sub Title" :value="old('process_sub_title', $service->process_sub_title ?? '')" placeholder="Brief description" />
                            </div>
                        </div>
                        
                        <div id="processItemsContainer">
                            @php $processItems = old('process_item', $service->process_item ?? []); @endphp
                            @if(is_array($processItems) && count($processItems) > 0)
                                @foreach($processItems as $index => $item)
                                    @include('admin.service._process_item', ['index' => $index, 'item' => $item])
                                @endforeach
                            @else
                                @include('admin.service._process_item', ['index' => 0, 'item' => null])
                            @endif
                        </div>
                        
                        <button type="button" class="btn btn-secondary btn-sm mt-2" id="addProcessItem">
                            <i class="bi bi-plus-circle"></i> Add Process Step
                        </button>
                    </div>
                </div>

                
                <div class="card mt-4 shadow-sm">
                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">✨ Highlight Titles</h5>
                        <button type="button" class="btn btn-primary btn-sm addHighlightTitle">
                            <i class="bi bi-plus-circle"></i> Add Title
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="highlightTitlesContainer">
                            @php 
                                $highlightTitles = old('highlight.sections', $service->highlight['sections'] ?? []); 
                            @endphp
                            @if(is_array($highlightTitles) && count($highlightTitles) > 0)
                                @foreach($highlightTitles as $index => $title)
                                    @include('admin.service._highlight_title', ['index' => $index, 'title' => $title])
                                @endforeach
                            @else
                                @include('admin.service._highlight_title', ['index' => 0, 'title' => null])
                            @endif
                        </div>
                    </div>
                </div>

            </form>
        </div>
    </div>
</main>
@endsection

@push('scripts')

<script id="processItemTemplate" type="text/x-custom-template">
    <div class="card card-body mb-3 border processItem bg-light">
        <div class="d-flex justify-content-between mb-2">
            <span class="fw-bold">Step #<span class="stepNumber">1</span></span>
            <button type="button" class="btn btn-sm btn-danger removeProcessItem">Remove</button>
        </div>
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Title</label>
                <input type="text" name="process_item[__INDEX__][title]" class="form-control" placeholder="Step title">
            </div>
            <div class="col-md-6">
                <label class="form-label">Image</label>
                <input type="file" name="process_item[__INDEX__][image]" class="form-control" accept="image/*">
            </div>
            <div class="col-12">
                <label class="form-label">Content</label>
                <textarea name="process_item[__INDEX__][content]" class="form-control" rows="2" placeholder="Brief description"></textarea>
            </div>
        </div>
    </div>
</script>


<script id="highlightTitleTemplate" type="text/x-custom-template">
    <div class="input-group mb-2 highlightTitleItem">
        <input type="text" name="highlight[sections][]" class="form-control" placeholder="Enter highlight title..." value="">
        <button type="button" class="btn btn-outline-danger removeHighlightTitle" title="Remove">
            <i class="bi bi-trash"></i>
        </button>
    </div>
</script>

<script>
$(document).ready(function() {
    
    // AJAX Form Submission
    $('#serviceForm').on('submit', function(e) {
        e.preventDefault();
        $('.text-danger').remove();
        $('.is-invalid').removeClass('is-invalid');
        
        let formData = new FormData(this);
        let url = $(this).attr('action');
        let submitBtn = $(this).find('button[type="submit"]');
        
        submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split"></i> Processing...');
        
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            contentType: false,
            processData: false,
            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
            success: function(response) {
                toastr.success(response.message);
                setTimeout(() => { window.location.href = '{{ route("admin.service.index") }}'; }, 1500);
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html('<i class="bi bi-save"></i> {{ isset($service) ? "Update" : "Create" }} Service');
                if (xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(field, errors) {
                        let input = $('[name="' + field + '"]');
                        input.addClass('is-invalid');
                        input.after('<div class="text-danger small">' + errors[0] + '</div>');
                    });
                    toastr.error('Please fix the form errors');
                } else {
                    toastr.error(xhr.responseJSON?.message || 'Something went wrong');
                }
            }
        });
    });


    let processIndex = {{ count(old('process_item', $service->process_item ?? [])) }};
    
    $('#addProcessItem').on('click', function() {
        let template = $('#processItemTemplate').html();
        template = template.replace(/__INDEX__/g, processIndex);
        template = template.replace(/Step #<span class="stepNumber">1<\/span>/, `Step #<span class="stepNumber">${processIndex + 1}</span>`);
        $('#processItemsContainer').append(template);
        processIndex++;
        updateProcessStepNumbers();
    });
    
    $('#processItemsContainer').on('click', '.removeProcessItem', function() {
        $(this).closest('.processItem').remove();
        updateProcessStepNumbers();
    });
    
    function updateProcessStepNumbers() {
        $('#processItemsContainer .processItem').each(function(index) {
            $(this).find('.stepNumber').text(index + 1);
        });
    }


    let highlightIndex = {{ count(old('highlight.sections', $service->highlight['sections'] ?? [])) }};
    
    $('.addHighlightTitle').on('click', function() {
        let template = $('#highlightTitleTemplate').html();
        template = template.replace(/__INDEX__/g, highlightIndex);
        $('.highlightTitlesContainer').append(template);
        highlightIndex++;
    });
    
    $('.highlightTitlesContainer').on('click', '.removeHighlightTitle', function() {
        $(this).closest('.highlightTitleItem').remove();
    });
});
</script>
@endpush


<div class="col-12">
    <form id="filterForm" method="GET" class="row g-3 mb-3">
        <div class="col-md-6">
            <input type="text" name="title" class="form-control form-control-sm" placeholder="🔍 Search by title..." value="{{ old('title', $filters['title'] ?? '') }}">
        </div>
        <div class="col-md-4">
            <select name="status" class="form-select form-select-sm">
                <option value="">All Status</option>
                <option value="1" {{ old('status', $filters['status'] ?? '') == '1' ? 'selected' : '' }}>✅ Active</option>
                <option value="0" {{ old('status', $filters['status'] ?? '') == '0' ? 'selected' : '' }}>❌ Inactive</option>
            </select>
        </div>
        <div class="col-md-2">
            <a href="{{ route('admin.service.index') }}" class="btn btn-primary w-100 text-white btn-sm"><i class="bi bi-x-circle"></i></a>
        </div>
    </form>
</div>

<div class="input-group mb-2 highlightTitleItem">
    <input type="text" name="highlight[sections][]" class="form-control" 
           placeholder="Enter highlight title..." 
           value="{{ old("highlight.sections.$index", $title ?? '') }}">
    <button type="button" class="btn btn-outline-danger removeHighlightTitle" title="Remove">
        <i class="bi bi-trash"></i>
    </button>
</div>

<div class="card card-body mb-3 border processItem bg-light">
    <div class="d-flex justify-content-between mb-2">
        <span class="fw-bold">Step #{{ $index + 1 }}</span>
        <button type="button" class="btn btn-sm btn-danger removeProcessItem">Remove</button>
    </div>
    <div class="row g-3">
        <div class="col-md-6">
            <label class="form-label">Title</label>
            <input type="text" name="process_item[{{ $index }}][title]" class="form-control"
                   value="{{ old("process_item.$index.title", $item['title'] ?? '') }}" placeholder="Step title">
        </div>
        <div class="col-md-6">
            <label class="form-label">Image</label>
            <input type="file" name="process_item[{{ $index }}][image]" class="form-control" accept="image/*">

            @if(isset($item['image']) && is_string($item['image']) && !empty($item['image']))
                <small class="text-muted d-block mt-1">Current: {{ basename($item['image']) }}</small>
            @elseif(isset($item['image']) && is_array($item['image']) && !empty($item['image']['name']))
                <small class="text-muted d-block mt-1">New file: {{ $item['image']['name'] }}</small>
            @endif
        </div>
        <div class="col-12">
            <label class="form-label">Content</label>
            <textarea name="process_item[{{ $index }}][content]" class="form-control" rows="2" placeholder="Brief description">{{ old("process_item.$index.content", $item['content'] ?? '') }}</textarea>
        </div>
    </div>
</div>


and setting index is 

@extends('layouts.app')

@section('title', 'System Configuration')

@section('content')
<link rel="stylesheet" type="text/css" href="{{ asset('admin_assets/css/tab.css') }}">

<main class="page-content pb-5">
    <x-breadcrumb 
        title="Settings" 
        subTitle="System Configuration" 
        :breadcrumbItems="['Dashboard', 'Settings']" 
    />
    
    <div class="card shadow-sm border-0">
        <div class="card-header bg-custom text-white d-flex align-items-center justify-content-between py-2">
            <h5 class="mb-0 text-light">
                <i class="bi bi-gear-fill me-2"></i>System Settings
            </h5>
            <span class="badge bg-light text-dark">
                <i class="bi bi-shield-check me-1"></i>
                {{ auth('admin')->user()->role?->display_name ?? 'Admin' }}
            </span>
        </div>
        
        <form id="updateSetting" method="POST" enctype="multipart/form-data">
            @csrf
            
            <div class="card-body p-0 bg-light">
                <div class="row g-0">
                    <div class="col-md-3 bg-white border-end">
                        <div class="p-4">
                            <div class="mb-4">
                                <h5 class="fw-bold text-dark d-flex align-items-center gap-2">
                                    <i class="bi bi-gear-fill text-primary"></i> Configuration
                                </h5>
                                <p class="small text-muted mb-0">Manage your system preferences</p>
                            </div>
                            
                            <div class="settings-nav-wrapper" id="v-pills-tab" role="tablist">
                                <button class="settings-nav-btn active" data-bs-toggle="pill" data-bs-target="#general" type="button" role="tab" aria-selected="true">
                                    <div class="icon-box"><i class="bi bi-sliders"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">General</span>
                                        <span class="nav-subtext">Basic Info & Contact</span>
                                    </div>
                                </button>

                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#media" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-images"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">Media</span>
                                        <span class="nav-subtext">Logos & Images</span>
                                    </div>
                                </button>

                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#smtp" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-envelope-paper"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">SMTP / Mail</span>
                                        <span class="nav-subtext">Email Configuration</span>
                                    </div>
                                </button>

                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#social" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-share"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">Social Links</span>
                                        <span class="nav-subtext">Profile URLs</span>
                                    </div>
                                </button>

                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#api" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-code-square"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">API & Integrations</span>
                                        <span class="nav-subtext">Google, FB, Analytics</span>
                                    </div>
                                </button>


                         
                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#seo" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-google"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">SEO</span>
                                        <span class="nav-subtext">Meta Tags</span>
                                    </div>
                                </button>

                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#information" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-file-text"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">Information</span>
                                        <span class="nav-subtext">Content Blocks</span>
                                    </div>
                                </button>

                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#additional" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-collection-play"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">Process Info</span>
                                        <span class="nav-subtext">Why Choose Us</span>
                                    </div>
                                </button>

                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#work" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-briefcase"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">Work Info</span>
                                        <span class="nav-subtext">Working Process</span>
                                    </div>
                                </button>

                                <button class="settings-nav-btn" data-bs-toggle="pill" data-bs-target="#counter" type="button" role="tab" aria-selected="false">
                                    <div class="icon-box"><i class="bi bi-building"></i></div>
                                    <div class="nav-text-container">
                                        <span class="nav-title">Counter Info</span>
                                        <span class="nav-subtext">Statistics</span>
                                    </div>
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="col-md-9 p-4 bg-white overflow-auto" style="min-height: 600px;">
                        @include('admin.settings.tab-content')
                    </div>
                </div>
            </div>
            
            <div class="p-4 bg-white border-top">
                <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                        <i class="bi bi-info-circle me-1"></i>
                        Changes are saved automatically
                    </small>
                    <button type="submit" class="btn btn-primary px-4">
                        <i class="bi bi-save me-2"></i>Save Changes
                    </button>
                </div>
            </div>
        </form>
    </div>
</main>
@endsection

@push('scripts')
<script>
    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const preview = document.getElementById(previewId);
                if (preview) {
                    preview.src = e.target.result;
                    preview.classList.remove('d-none');
                }
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    $('#updateSetting').submit(function(e) {
        e.preventDefault();
        $(document).find("span.text-danger").remove();
        $('.form-control').removeClass('is-invalid');
        
        const formData = new FormData(this);
        const submitBtn = $(this).find('button[type="submit"]');
        const originalBtnText = submitBtn.html();
        
        submitBtn.prop('disabled', true).html('<i class="bi bi-hourglass-split me-1"></i> Saving...');
        
        $.ajax({
            type: 'POST',
            url: "{{ route('admin.settings.update') }}",
            data: formData,
            contentType: false,
            processData: false,
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                'Accept': 'application/json'
            },
            success: function(response) {
                toastr.success(response.message);
                submitBtn.prop('disabled', false).html(originalBtnText);
            },
            error: function(xhr) {
                submitBtn.prop('disabled', false).html(originalBtnText);
                
                if (xhr.status === 422 && xhr.responseJSON?.errors) {
                    $.each(xhr.responseJSON.errors, function(field_name, error) {
                        let element = $('[name="' + field_name + '"]');
                        
                        if (element.length === 0) {
                            const baseName = field_name.split('[')[0];
                            element = $('[name^="' + baseName + '"]').first();
                        }
                        
                        if (element.length) {
                            element.addClass('is-invalid');
                            element.after('<span class="text-danger small d-block mt-1">' + error[0] + '</span>');
                        }
                    });
                    toastr.error('Please fix the errors below');
                } else {
                    const errorMsg = xhr.responseJSON?.message || 'Failed to update settings';
                    toastr.error(errorMsg);
                }
            }
        });
    });

    document.addEventListener('DOMContentLoaded', function() {
        function createRowHTML(index, itemName) {
            // Context-aware placeholders based on which tab is adding the item
            let iconPlaceholder = "e.g., bi bi-check-circle";
            let titlePlaceholder = "e.g., Feature Title";
            let contentPlaceholder = "Briefly describe this item...";

            if (itemName === 'work_item') {
                iconPlaceholder = "e.g., bi bi-1-circle-fill";
                titlePlaceholder = "e.g., Step 1: Book Ride";
                contentPlaceholder = "Describe this working process step...";
            } else if (itemName === 'counter_item') {
                iconPlaceholder = "e.g., bi bi-people-fill";
                titlePlaceholder = "e.g., 500+";
                contentPlaceholder = "e.g., Happy Customers";
            }

            return `
            <div class="row item-row align-items-start mb-3 border-bottom pb-3">
                <div class="col-md-6 mb-2">
                    <label class="small text-muted">Icon Class</label>
                    <input type="text" 
                           name="${itemName}[${index}][icon]" 
                           class="form-control form-control-sm" 
                           placeholder="${iconPlaceholder}">
                </div>
                <div class="col-md-6 mb-2">
                    <label class="small text-muted">Title</label>
                    <input type="text" 
                           name="${itemName}[${index}][title]" 
                           class="form-control form-control-sm" 
                           placeholder="${titlePlaceholder}">
                </div>
                <div class="col-md-10 mb-2">
                    <label class="small text-muted">Content</label>
                    <textarea name="${itemName}[${index}][content]" 
                              class="form-control form-control-sm" 
                              rows="2" 
                              placeholder="${contentPlaceholder}"></textarea>
                </div>
                <div class="col-md-2 pt-4 text-center">
                    <button type="button" 
                            class="btn btn-outline-danger btn-sm remove-item-btn w-100">
                        <i class="bi bi-trash"></i>
                    </button>
                </div>
            </div>`;
        }
        
        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.add-item-btn');
            if (!btn) return;
            
            const tabPane = btn.closest('.tab-pane');
            if (!tabPane) return;
            
            const tabId = tabPane.getAttribute('id');
            let itemName = 'process_item';
            
            if (tabId === 'work') itemName = 'work_item';
            if (tabId === 'counter') itemName = 'counter_item';
            
            const index = Date.now();
            const displayContainer = tabPane.querySelector('.itemDisplay');
            
            if (displayContainer) {
                displayContainer.insertAdjacentHTML('beforeend', createRowHTML(index, itemName));
            }
        });

        document.addEventListener('click', function(e) {
            const btn = e.target.closest('.remove-item-btn');
            if (!btn) return;
            
            const row = btn.closest('.item-row');
            if (row) row.remove();
        });

        const tabButtons = document.querySelectorAll('.settings-nav-btn');
        tabButtons.forEach(button => {
            button.addEventListener('shown.bs.tab', function() {
                tabButtons.forEach(btn => btn.setAttribute('aria-selected', 'false'));
                this.setAttribute('aria-selected', 'true');
                
                const contentArea = document.querySelector('.overflow-auto');
                if (contentArea) contentArea.scrollTop = 0;
            });
        });

        document.addEventListener('keydown', function(e) {
            if (e.key !== 'ArrowDown' && e.key !== 'ArrowUp') return;
            
            const activeBtn = document.querySelector('.settings-nav-btn.active');
            if (!activeBtn) return;
            
            const buttons = Array.from(tabButtons);
            const currentIndex = buttons.indexOf(activeBtn);
            const direction = e.key === 'ArrowDown' ? 1 : -1;
            const nextIndex = (currentIndex + direction + buttons.length) % buttons.length;
            
            buttons[nextIndex].click();
            buttons[nextIndex].focus();
            e.preventDefault();
        });
    });
</script>
@endpush

tap is 

<div class="tab-content h-100">
    
 
    <div class="tab-pane fade show active" id="general">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">General Information</h6>
            <p class="text-muted small mb-0">Update basic contact details and map configuration.</p>
        </div>
        
        <div class="row g-3">
            <x-input-field name="system_name" label="System Name" value="{{ old('system_name', setting('system_name', config('app.name'))) }}" cols="col-md-6" placeholder="e.g., EzRide Admin Panel" />
            <x-input-field name="email" label="Primary Email" type="email" value="{{ old('email', setting('email', '')) }}" cols="col-md-6" placeholder="admin@ezride.com" />
            <x-input-field name="extra_email" label="Secondary Email" type="email" value="{{ old('extra_email', setting('extra_email', '')) }}" cols="col-md-6" placeholder="support@ezride.com" />
            <x-input-field name="phone" label="Primary Phone" value="{{ old('phone', setting('phone', '')) }}" cols="col-md-6" placeholder="+1 (234) 567-890" />
            <x-input-field name="extra_phone" label="Secondary Phone" value="{{ old('extra_phone', setting('extra_phone', '')) }}" cols="col-md-6" placeholder="+1 (234) 567-891" />
            <x-input-field name="address" label="Address" value="{{ old('address', setting('address', '')) }}" cols="col-md-6" placeholder="123 Business Ave, City, Country" />
            <x-input-field name="opening_hr" label="Opening Hours" value="{{ old('opening_hr', setting('opening_hr', '')) }}" cols="col-md-6" placeholder="e.g., Mon - Fri: 9:00 AM - 6:00 PM" />
            <x-input-field name="work_hours" label="Work Hours" value="{{ old('work_hours', setting('work_hours', '')) }}" cols="col-md-6" placeholder="e.g., 24/7 Support Available" />
            
            <div class="col-12">
                <x-input-field name="google_map" label="Google Map Embed Link" type="url" value="{{ old('google_map', setting('google_map', '')) }}" placeholder="Paste your Google Maps iframe embed URL here" />
            </div>
            
            <x-input-field name="footer_copyright" label="Copyright Text" value="{{ old('footer_copyright', setting('footer_copyright', '')) }}" placeholder="© 2026 EzRide. All rights reserved." />
        </div>
    </div>

    {{-- TAB: MEDIA --}}
    <div class="tab-pane fade" id="media">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Media Management</h6>
            <p class="text-muted small mb-0">Upload images for your site layout.</p>
        </div>
        
        <div class="row g-4">
            @php
            $mediaFields = [
            'logo' => ['label' => 'Website Logo', 'hint' => 'PNG/JPG. Recommended: 200x60px'],
            'favicon' => ['label' => 'Favicon', 'hint' => 'ICO/PNG. Recommended: 32x32px'],
            'loader' => ['label' => 'Home About Section Image', 'hint' => 'Image used in the homepage about section'],
            'bg_image' => ['label' => 'About Page Background', 'hint' => 'Background image for the About page'],
            'footer_gateway_img' => ['label' => 'Review Section Background', 'hint' => 'Background image for the reviews section'],
            'image1' => ['label' => 'Footer Logo', 'hint' => 'Alternative logo for the footer'],
            'breadcrumb' => ['label' => 'Breadcrumb Background (Desktop)', 'hint' => 'Wide background image for desktop breadcrumbs'],
            'image2' => ['label' => 'Breadcrumb Background (Mobile)', 'hint' => 'Vertical background image for mobile breadcrumbs']
            ];
            @endphp
            
            @foreach($mediaFields as $field => $config)
            <div class="col-md-6">
                <label class="form-label fw-bold small text-uppercase text-muted">
                    {{ $config['label'] }}
                </label>
                <small class="text-muted d-block mb-2">{{ $config['hint'] }}</small>
                
                <input type="file" name="{{ $field }}" class="form-control mb-2" onchange="previewImage(this, 'prev-{{ $field }}')">
                
                <div class="border rounded p-2 text-center bg-light d-flex align-items-center justify-content-center" style="min-height: 100px;">
                    @php
                    $imagePath = old($field, setting($field, null));
                    $imageUrl = $imagePath && is_string($imagePath) 
                    ? (filter_var($imagePath, FILTER_VALIDATE_URL) ? $imagePath : asset('storage/' . $imagePath))
                    : asset('default/noimage.png');
                    @endphp
                    <img src="{{ $imageUrl }}" id="prev-{{ $field }}" class="img-fluid mh-100" style="max-height: 100px; object-fit: contain;">
                </div>
            </div>
            @endforeach
        </div>
    </div>

    {{-- TAB: SMTP --}}
    <div class="tab-pane fade" id="smtp">
        <div class="card shadow-sm border-0 bg-light mb-4">
            <div class="card-body">
                <h5 class="mb-4">📧 SMTP Configuration Guidelines</h5>
                <div class="alert alert-warning">
                    <strong>⚠️ Warning:</strong> Incorrect settings may prevent emails from being sent.
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <h6 class="text-primary">🔒 Non-SSL (TLS)</h6>
                        <ul class="list-group mb-3">
                            <li class="list-group-item">Port: <strong>587</strong>, Encryption: <strong>tls</strong></li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6 class="text-success">🛡️ SSL</h6>
                        <ul class="list-group mb-3">
                            <li class="list-group-item">Port: <strong>465</strong>, Encryption: <strong>ssl</strong></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Mail Configuration</h6>
        </div>
        
        <div class="row g-3 shadow-sm border-0 bg-light p-3">
            <x-input-field name="mail_transport" label="Mail Transport" value="{{ old('mail_transport', setting('mail_transport', 'smtp')) }}" cols="col-md-6" placeholder="e.g., smtp" />
            <x-input-field name="mail_host" label="SMTP Host" value="{{ old('mail_host', setting('mail_host', '')) }}" cols="col-md-6" placeholder="e.g., smtp.gmail.com" />
            <x-input-field name="mail_port" label="Port" type="number" value="{{ old('mail_port', setting('mail_port', '587')) }}" cols="col-md-6" placeholder="587" />
            <x-input-field name="mail_username" label="Username" value="{{ old('mail_username', setting('mail_username', '')) }}" cols="col-md-6" placeholder="your-email@gmail.com" />
            <x-input-field name="mail_password" label="Password" type="text" value="{{ old('mail_password', setting('mail_password', '')) }}" cols="col-md-6" placeholder="Your email password or app password" />
            <x-input-field name="mail_encryption" label="Encryption" value="{{ old('mail_encryption', setting('mail_encryption', 'tls')) }}" cols="col-md-6" placeholder="tls or ssl" />
            <x-input-field name="mail_from" label="From Email" value="{{ old('mail_from', setting('mail_from', '')) }}" cols="col-md-6" placeholder="noreply@ezride.com" />
            <x-input-field name="mail_from_name" label="From Name" value="{{ old('mail_from_name', setting('mail_from_name', '')) }}" cols="col-md-6" placeholder="EzRide System" />
            
            <div class="col-12 mt-2">
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-0" type="checkbox" name="smtp_check" value="1" {{ old('smtp_check', setting('smtp_check', false)) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2 fw-bold">Enable SMTP</label>
                </div>
            </div>
        </div>
    </div>

    {{-- TAB: SOCIAL --}}
    <div class="tab-pane fade" id="social">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Social Links</h6>
        </div>
        
        <div class="row g-3">
            <x-input-field name="facebook" label="Facebook URL" value="{{ old('facebook', setting('facebook', '')) }}" cols="col-md-12" placeholder="https://facebook.com/yourpage" />
            <x-input-field name="twitter" label="Twitter/X URL" value="{{ old('twitter', setting('twitter', '')) }}" cols="col-md-12" placeholder="https://twitter.com/yourhandle" />
            <x-input-field name="linkedin" label="LinkedIn URL" value="{{ old('linkedin', setting('linkedin', '')) }}" cols="col-md-12" placeholder="https://linkedin.com/in/yourprofile" />
            <x-input-field name="instagram" label="Instagram URL" value="{{ old('instagram', setting('instagram', '')) }}" cols="col-md-12" placeholder="https://instagram.com/yourprofile" />
            <x-input-field name="youtube" label="YouTube URL" value="{{ old('youtube', setting('youtube', '')) }}" cols="col-md-12" placeholder="https://youtube.com/yourchannel" />
            <x-input-field name="google" label="Google+ URL" value="{{ old('google', setting('google', '')) }}" cols="col-md-12" placeholder="https://plus.google.com/yourprofile" />
            <x-input-field name="yelp" label="Yelp URL" value="{{ old('yelp', setting('yelp', '')) }}" cols="col-md-12" placeholder="https://yelp.com/yourbusiness" />
        </div>
    </div>

    {{-- TAB: API --}}
    <div class="tab-pane fade" id="api">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">API & Third Party</h6>
        </div>
        
        <div class="row g-3">
            <h6 class="col-12 text-dark fw-bold">Google</h6>
            <x-input-field name="google_analytic_id" label="Analytics ID" value="{{ old('google_analytic_id', setting('google_analytic_id', '')) }}" cols="col-md-6" placeholder="G-XXXXXXXXXX" />
            <x-input-field name="google_client_id" label="Login Client ID" value="{{ old('google_client_id', setting('google_client_id', '')) }}" cols="col-md-6" placeholder="xxxx.apps.googleusercontent.com" />
            <x-input-field name="google_client_secret" label="Login Secret" value="{{ old('google_client_secret', setting('google_client_secret', '')) }}" cols="col-md-6" placeholder="GOCSPX-xxxxxxxx" />
            <x-input-field name="google_redirect" label="Login Redirect URI" value="{{ old('google_redirect', setting('google_redirect', '')) }}" cols="col-md-6" placeholder="https://yourdomain.com/auth/google/callback" />
            
            <h6 class="col-12 text-dark fw-bold mt-3">Facebook</h6>
            <x-input-field name="facebook_analytic_id" label="Pixel ID" value="{{ old('facebook_analytic_id', setting('facebook_analytic_id', '')) }}" cols="col-md-6" placeholder="123456789012345" />
            <x-input-field name="facebook_client_id" label="Login Client ID" value="{{ old('facebook_client_id', setting('facebook_client_id', '')) }}" cols="col-md-6" placeholder="1234567890" />
            <x-input-field name="facebook_client_secret" label="Login Secret" value="{{ old('facebook_client_secret', setting('facebook_client_secret', '')) }}" cols="col-md-6" placeholder="abcdef1234567890" />
            <x-input-field name="facebook_redirect" label="Login Redirect URI" value="{{ old('facebook_redirect', setting('facebook_redirect', '')) }}" cols="col-md-6" placeholder="https://yourdomain.com/auth/facebook/callback" />
            
            <h6 class="col-12 text-dark fw-bold mt-3">Recaptcha</h6>
            <x-input-field name="recaptcha_site_key" label="Site Key" value="{{ old('recaptcha_site_key', setting('recaptcha_site_key', '')) }}" cols="col-md-6" placeholder="6Lc..." />
            <x-input-field name="recaptcha_secret_key" label="Secret Key" value="{{ old('recaptcha_secret_key', setting('recaptcha_secret_key', '')) }}" cols="col-md-6" placeholder="6Lc..." />
            
            <div class="col-12 mt-2">
                <div class="form-check form-switch ps-0">
                    <input class="form-check-input ms-0" type="checkbox" name="is_recaptcha" value="1" {{ old('is_recaptcha', setting('is_recaptcha', false)) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2 fw-bold">Enable Recaptcha</label>
                </div>
            </div>
        </div>
    </div>





    {{-- TAB: SEO --}}
    <div class="tab-pane fade" id="seo">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Search Engine Optimization</h6>
        </div>
        
        <div class="row g-3">
            <div class="col-12">
                <x-input-field name="meta_author" label="Meta Author" value="{{ old('meta_author', setting('meta_author', '')) }}" placeholder="EzRide Team" />
            </div>
            <div class="col-12">
                <x-input-field name="meta_title" label="Meta Title" value="{{ old('meta_title', setting('meta_title', '')) }}" placeholder="EzRide - Smart Ride Sharing Solution" />
            </div>
            <div class="col-12">
                <x-input-field name="meta_keywords" label="Keywords" value="{{ old('meta_keywords', setting('meta_keywords', '')) }}" placeholder="ride sharing, taxi app, ezride, transport" />
            </div>
            <div class="col-12">
                <label class="form-label text-uppercase text-muted small fw-bold">Meta Description</label>
                <textarea name="meta_description" class="form-control" rows="4" placeholder="EzRide offers fast, reliable, and affordable ride-sharing services...">{{ old('meta_description', setting('meta_description', '')) }}</textarea>
            </div>
        </div>
    </div>

    {{-- TAB: INFORMATION --}}
    <div class="tab-pane fade" id="information">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Information Content</h6>
        </div>
        
        <div class="row g-3">
            <div class="col-12">
                <label class="form-label text-uppercase text-muted small fw-bold">Home About Info</label>
                <textarea name="info1" class="form-control editor" rows="3" placeholder="Write a compelling introduction for your homepage about section...">{{ old('info1', setting('info1', '')) }}</textarea>
            </div>

            <div class="col-12">
                <label class="form-label text-uppercase text-muted small fw-bold">About Page Info</label>
                <textarea name="info2" class="form-control editor" rows="3" placeholder="Tell your company's story, mission, and vision on the about page...">{{ old('info2', setting('info2', '')) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label text-uppercase text-muted small fw-bold">Our Mission</label>
                <textarea name="info3" class="form-control" rows="3" placeholder="e.g., To revolutionize urban transportation...">{{ old('info3', setting('info3', '')) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label text-uppercase text-muted small fw-bold">Our Vision</label>
                <textarea name="info4" class="form-control" rows="3" placeholder="e.g., To be the world's most trusted ride-sharing platform...">{{ old('info4', setting('info4', '')) }}</textarea>
            </div>

            <div class="col-md-4">
                <label class="form-label text-uppercase text-muted small fw-bold">Our Values</label>
                <textarea name="info5" class="form-control" rows="3" placeholder="e.g., Safety, Reliability, Customer First...">{{ old('info5', setting('info5', '')) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label text-uppercase text-muted small fw-bold">Other Info 1</label>
                <textarea name="info6" class="form-control" rows="3" placeholder="Additional information block 1...">{{ old('info6', setting('info6', '')) }}</textarea>
            </div>

            <div class="col-md-6">
                <label class="form-label text-uppercase text-muted small fw-bold">Other Info 2</label>
                <textarea name="info7" class="form-control" rows="3" placeholder="Additional information block 2...">{{ old('info7', setting('info7', '')) }}</textarea>
            </div>
        </div>
    </div>

    {{-- TAB: PROCESS INFO --}}
    <div class="tab-pane fade" id="additional">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Process Information</h6>
        </div>
        
        <div class="row g-4">
            <div class="col-md-12">
                <label class="form-label fw-bold">Process Main Title</label>
                <input type="text" name="process_title" class="form-control" value="{{ old('process_title', setting('process_title', '')) }}" placeholder="e.g., How It Works">
            </div>
            
            <div class="col-md-12">
                <label class="form-label fw-bold">Process Sub Title</label>
                <textarea name="process_sub_title" class="form-control form-control-sm" rows="4" placeholder="e.g., Book a ride in just 3 simple steps and enjoy your journey...">{{ old('process_sub_title', setting('process_sub_title', '')) }}</textarea>
            </div>
            
            <div class="col-12">
                <h6 class="fw-bold text-dark mb-3">Process Items</h6>
                <div class="item-container border rounded p-3 bg-light">
                    <div class="itemDisplay">
                        @php
                        $processItems = old('process_item', setting('process_item', []));
                        $processItems = is_array($processItems) ? $processItems : [];
                        @endphp
                        @foreach($processItems as $index => $item)
                        <div class="row item-row align-items-start mb-3 border-bottom pb-3">
                            <div class="col-md-6 mb-2">
                                <label class="small text-muted">Icon Class</label>
                                <input type="text" name="process_item[{{ $index }}][icon]" class="form-control form-control-sm" value="{{ e($item['icon'] ?? '') }}" placeholder="e.g., bi bi-check-circle">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="small text-muted">Title</label>
                                <input type="text" name="process_item[{{ $index }}][title]" class="form-control form-control-sm" value="{{ e($item['title'] ?? '') }}" placeholder="e.g., Feature Title">
                            </div>
                            <div class="col-md-10 mb-2">
                                <label class="small text-muted">Content</label>
                                <textarea name="process_item[{{ $index }}][content]" class="form-control form-control-sm" rows="2" placeholder="Briefly describe this item...">{{ e($item['content'] ?? '') }}</textarea>
                            </div>
                            <div class="col-md-2 pt-4 text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn w-100"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <button type="button" class="btn btn-primary add-item-btn"><i class="bi bi-plus-circle"></i> Add New Item</button>
            </div>
        </div>
    </div>

    {{-- TAB: WORK INFO --}}
    <div class="tab-pane fade" id="work">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Working Information</h6>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Work Main Title</label>
                <input type="text" name="work_title" class="form-control" value="{{ old('work_title', setting('work_title', '')) }}" placeholder="e.g., Our Working Process">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold">Work Sub Title</label>
                <input type="text" name="work_sub_title" class="form-control" value="{{ old('work_sub_title', setting('work_sub_title', '')) }}" placeholder="e.g., Seamless experience from start to finish">
            </div>
            
            <div class="col-12">
                <h6 class="fw-bold text-dark mb-3">Work Items</h6>
                <div class="item-container border rounded p-3 bg-light">
                    <div class="itemDisplay">
                        @php
                        $workItems = old('work_item', setting('work_item', []));
                        $workItems = is_array($workItems) ? $workItems : [];
                        @endphp
                        @foreach($workItems as $index => $item)
                        <div class="row item-row align-items-start mb-3 border-bottom pb-3">
                            <div class="col-md-6 mb-2">
                                <label class="small text-muted">Icon Class</label>
                                <input type="text" name="work_item[{{ $index }}][icon]" class="form-control form-control-sm" value="{{ e($item['icon'] ?? '') }}" placeholder="e.g., bi bi-1-circle-fill">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="small text-muted">Title</label>
                                <input type="text" name="work_item[{{ $index }}][title]" class="form-control form-control-sm" value="{{ e($item['title'] ?? '') }}" placeholder="e.g., Step 1: Book Ride">
                            </div>
                            <div class="col-md-10 mb-2">
                                <label class="small text-muted">Content</label>
                                <textarea name="work_item[{{ $index }}][content]" class="form-control form-control-sm" rows="2" placeholder="Describe this working process step...">{{ e($item['content'] ?? '') }}</textarea>
                            </div>
                            <div class="col-md-2 pt-4 text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn w-100"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <button type="button" class="btn btn-primary add-item-btn"><i class="bi bi-plus-circle"></i> Add New Item</button>
            </div>
        </div>
    </div>

    {{-- TAB: COUNTER INFO --}}
    <div class="tab-pane fade" id="counter">
        <div class="border-bottom pb-3 mb-4">
            <h6 class="text-primary text-uppercase fw-bold">Counter Information</h6>
        </div>
        
        <div class="row g-4">
            <div class="col-md-6">
                <label class="form-label fw-bold">Counter Main Title</label>
                <input type="text" name="counter_title" class="form-control" value="{{ old('counter_title', setting('counter_title', '')) }}" placeholder="e.g., Our Achievements">
            </div>
            
            <div class="col-md-6">
                <label class="form-label fw-bold">Counter Sub Title</label>
                <input type="text" name="counter_sub_title" class="form-control" value="{{ old('counter_sub_title', setting('counter_sub_title', '')) }}" placeholder="e.g., Numbers that speak for themselves">
            </div>
            
            <div class="col-12">
                <h6 class="fw-bold text-dark mb-3">Counter Items</h6>
                <div class="item-container border rounded p-3 bg-light">
                    <div class="itemDisplay">
                        @php
                        $counterItems = old('counter_item', setting('counter_item', []));
                        $counterItems = is_array($counterItems) ? $counterItems : [];
                        @endphp
                        @foreach($counterItems as $index => $item)
                        <div class="row item-row align-items-start mb-3 border-bottom pb-3">
                            <div class="col-md-6 mb-2">
                                <label class="small text-muted">Icon Class</label>
                                <input type="text" name="counter_item[{{ $index }}][icon]" class="form-control form-control-sm" value="{{ e($item['icon'] ?? '') }}" placeholder="e.g., bi bi-people-fill">
                            </div>
                            <div class="col-md-6 mb-2">
                                <label class="small text-muted">Title</label>
                                <input type="text" name="counter_item[{{ $index }}][title]" class="form-control form-control-sm" value="{{ e($item['title'] ?? '') }}" placeholder="e.g., 500+">
                            </div>
                            <div class="col-md-10 mb-2">
                                <label class="small text-muted">Content</label>
                                <textarea name="counter_item[{{ $index }}][content]" class="form-control form-control-sm" rows="2" placeholder="e.g., Happy Customers">{{ e($item['content'] ?? '') }}</textarea>
                            </div>
                            <div class="col-md-2 pt-4 text-center">
                                <button type="button" class="btn btn-outline-danger btn-sm remove-item-btn w-100"><i class="bi bi-trash"></i></button>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            
            <div class="col-12">
                <button type="button" class="btn btn-primary add-item-btn"><i class="bi bi-plus-circle"></i> Add New Item</button>
            </div>
        </div>
    </div>

</div>


<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class BannerRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'       => 'required|string|max:255',
            'subtitle'    => 'nullable|string|max:255',
            'image'       => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'description' => 'nullable|string',
            'order_level' => 'nullable|integer|min:0',
            'status'      => 'nullable|boolean',
        ];
    }
}

<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class ServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

    public function rules(): array
    {
        $serviceId = $this->route('service')?->id;
        
        return [
            'title'             => 'required|string|max:255',
            'subtitle'          => 'nullable|string|max:255',
            'icon'     => 'nullable|string',
            'short_content'     => 'nullable|string',
            'long_content'      => 'nullable|string',
            'slug'              => $serviceId 
                ? 'nullable|string|max:255|unique:services,slug,' . $serviceId 
                : 'nullable|string|max:255|unique:services,slug',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'feature_image'     => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'process_title'     => 'nullable|string|max:255',
            'process_sub_title' => 'nullable|string|max:255',
            'process_item'      => 'nullable|array',
            'highlight'         => 'nullable|array',
            'order_level'       => 'nullable|integer|min:0',
            'status'            => 'nullable|boolean',
            'meta_keywords'     => 'nullable|string|max:255',
            'meta_description'  => 'nullable|string|max:500',
        ];
    }
}


<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
  
    public function authorize(): bool
    {
        return auth('admin')->check();
    }

   
    public function rules(): array
    {
        $rules = [];

      
        $imageFields = [
            'logo',
            'favicon',
            'loader',
            'footer_gateway_img',
            'bg_image',
            'breadcrumb',
            'image1',
            'image2'
        ];

        foreach ($imageFields as $field) {
            $rules[$field] = 'nullable|image|mimes:jpg,jpeg,png,webp';
        }

        // General fields
        $rules['system_name'] = 'nullable|string|max:191';
        $rules['email'] = 'nullable|email|max:191';
        $rules['extra_email'] = 'nullable|email|max:191';
        $rules['phone'] = 'nullable|string|max:50';
        $rules['extra_phone'] = 'nullable|string|max:50';
        $rules['address'] = 'nullable|string';
        $rules['opening_hr'] = 'nullable|string|max:100';
        $rules['work_hours'] = 'nullable|string|max:100';
        $rules['google_map'] = 'nullable|string';
        $rules['footer_copyright'] = 'nullable|string|max:191';

        // Social links
        $socialFields = ['facebook', 'twitter', 'linkedin', 'instagram', 'youtube', 'google', 'yelp'];
        foreach ($socialFields as $field) {
            $rules[$field] = 'nullable|url|max:191';
        }

        // SEO fields
        $rules['meta_author'] = 'nullable|string|max:191';
        $rules['meta_title'] = 'nullable|string|max:191';
        $rules['meta_keywords'] = 'nullable|string|max:191';
        $rules['meta_description'] = 'nullable|string|max:500';

        // Info blocks (1-7)
        for ($i = 1; $i <= 7; $i++) {
            $rules["info{$i}"] = 'nullable|string';
        }

        // SMTP fields
        $rules['mail_transport'] = 'nullable|string|max:50';
        $rules['mail_host'] = 'nullable|string|max:191';
        $rules['mail_port'] = 'nullable|integer';
        $rules['mail_username'] = 'nullable|string|max:191';
        $rules['mail_password'] = 'nullable|string|max:191';
        $rules['mail_encryption'] = 'nullable|string|max:10';
        $rules['mail_from'] = 'nullable|email|max:191';
        $rules['mail_from_name'] = 'nullable|string|max:191';
        $rules['smtp_check'] = 'nullable|boolean';

        // Recaptcha
        $rules['recaptcha_site_key'] = 'nullable|string|max:191';
        $rules['recaptcha_secret_key'] = 'nullable|string|max:191';
        $rules['is_recaptcha'] = 'nullable|boolean';

        // Google API
        $rules['google_analytic_id'] = 'nullable|string|max:50';
        $rules['google_client_id'] = 'nullable|string|max:191';
        $rules['google_client_secret'] = 'nullable|string|max:191';
        $rules['google_redirect'] = 'nullable|url|max:191';
        $rules['is_google'] = 'nullable|boolean';

        // Facebook API
        $rules['facebook_analytic_id'] = 'nullable|string|max:50';
        $rules['facebook_client_id'] = 'nullable|string|max:191';
        $rules['facebook_client_secret'] = 'nullable|string|max:191';
        $rules['facebook_redirect'] = 'nullable|url|max:191';
        $rules['is_facebook'] = 'nullable|boolean';

        // Process/Work/Counter dynamic items
        $rules['process_title'] = 'nullable|string|max:191';
        $rules['process_sub_title'] = 'nullable|string';
        $rules['process_item'] = 'nullable|array';

        $rules['work_title'] = 'nullable|string|max:191';
        $rules['work_sub_title'] = 'nullable|string';
        $rules['work_item'] = 'nullable|array';

        $rules['counter_title'] = 'nullable|string|max:191';
        $rules['counter_sub_title'] = 'nullable|string';
        $rules['counter_item'] = 'nullable|array';


        return $rules;
    }

   
    public function messages(): array
    {
        return [
            'email.email' => 'Please enter a valid email address',
            'google_map.url' => 'Please enter a valid Google Map embed URL',
            'facebook.url' => 'Please enter a valid Facebook URL',
            'twitter.url' => 'Please enter a valid Twitter URL',
            'linkedin.url' => 'Please enter a valid LinkedIn URL',
            'instagram.url' => 'Please enter a valid Instagram URL',
            'youtube.url' => 'Please enter a valid YouTube URL',
        ];
    }
}

yes ma chai maile email marketing kasari garne hola 