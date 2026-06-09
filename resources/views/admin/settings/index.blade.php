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