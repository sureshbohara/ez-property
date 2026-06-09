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