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