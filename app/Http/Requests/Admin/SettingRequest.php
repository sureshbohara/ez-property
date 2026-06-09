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