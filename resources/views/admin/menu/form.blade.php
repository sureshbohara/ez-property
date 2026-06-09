@extends('layouts.app')
@section('title', isset($menu) ? 'Edit Menu' : 'Create Menu')
@section('content')
<main class="page-content">
    <div class="container-fluid">
        <x-breadcrumb title="Manage Menus" 
                      subTitle="{{ isset($menu) ? 'Update Menu' : 'Create Menu' }}" 
                      :breadcrumbItems="['Dashboard', 'Menus']"/>
        
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header bg-custom text-white d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-list-ul me-2"></i>{{ isset($menu) ? 'Update' : 'Create' }} Menu</h5>
                        <a href="{{ route('admin.menu.index') }}" class="btn btn-light btn-sm">
                            <i class="bi bi-arrow-left me-1"></i>Back
                        </a>
                    </div>
                    <div class="card-body">
                        <form id="menuForm" method="POST" 
                              action="{{ isset($menu) ? route('admin.menu.update', $menu->id) : route('admin.menu.store') }}">
                            @csrf 
                            @if(isset($menu)) @method('PUT') @endif
                            
                            <div class="row">
                                <div class="col-lg-8">
                                    <div class="alert alert-info mb-3">
                                        <i class="bi bi-info-circle me-2"></i>
                                        Drag items to reorder. Nest items by dragging them right under a parent.
                                    </div>
                                    
                                    <div class="row">
                                        <div class="col-md-4 mb-3">
                                            <div class="accordion" id="menuItemsAccordion">
                                                <!-- Custom Links -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button" type="button" 
                                                                data-bs-toggle="collapse" data-bs-target="#collapseCustomLinks">
                                                            Custom Links
                                                        </button>
                                                    </h2>
                                                    <div id="collapseCustomLinks" class="accordion-collapse collapse show" 
                                                         data-bs-parent="#menuItemsAccordion">
                                                        <div class="accordion-body">
                                                            <div class="mb-2">
                                                                <input type="text" class="form-control form-control-sm" 
                                                                       id="customLinkUrl" placeholder="https://example.com">
                                                            </div>
                                                            <div class="mb-2">
                                                                <input type="text" class="form-control form-control-sm" 
                                                                       id="customLinkText" placeholder="Link Text">
                                                            </div>
                                                            <button type="button" class="btn btn-secondary btn-sm w-100" 
                                                                    id="addCustomLinkBtn">
                                                                <i class="bi bi-plus me-1"></i>Add
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Dynamic Routes -->
                                                <div class="accordion-item">
                                                    <h2 class="accordion-header">
                                                        <button class="accordion-button collapsed" type="button" 
                                                                data-bs-toggle="collapse" data-bs-target="#collapseRoutes">
                                                            <i class="bi bi-signpost-split me-2"></i>Routes
                                                        </button>
                                                    </h2>
                                                    <div id="collapseRoutes" class="accordion-collapse collapse" 
                                                         data-bs-parent="#menuItemsAccordion">
                                                        <div class="accordion-body" style="max-height: 300px; overflow-y: auto;">
                                                            @forelse($namedRoutes ?? [] as $route)
                                                                <div class="form-check mb-2">
                                                                    <input class="form-check-input route-check" type="checkbox" 
                                                                           value="{{ $route['uri'] }}" 
                                                                           data-route-name="{{ $route['name'] }}" 
                                                                           id="r_{{ $loop->index }}">
                                                                    <label class="form-check-label small" for="r_{{ $loop->index }}">
                                                                        <strong>{{ $route['name'] }}</strong> 
                                                                        <span class="text-muted">({{ $route['uri'] }})</span>
                                                                    </label>
                                                                </div>
                                                            @empty
                                                                <p class="text-muted small mb-0">No safe routes found.</p>
                                                            @endforelse
                                                            <button type="button" class="btn btn-secondary btn-sm w-100 mt-2" 
                                                                    id="addRoutesBtn">
                                                                <i class="bi bi-plus me-1"></i>Add Selected
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-8">
                                            <div class="border rounded p-3 bg-light" style="min-height: 400px;">
                                                <ul id="sortableMenu" class="list-unstyled mb-0">
                                                    @if(isset($menu) && $menu->items)
                                                        @foreach($menu->items->whereNull('parent_id')->sortBy('order') as $item)
                                                            @include('admin.menu.partials.menu-item', ['item' => $item])
                                                        @endforeach
                                                    @endif
                                                </ul>
                                                <p class="text-muted small mt-2 mb-0" id="emptyMessage" 
                                                   style="{{ (isset($menu) && $menu->items->count() > 0) ? 'display:none;' : '' }}">
                                                    <i class="bi bi-info-circle me-1"></i>Add items from left
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-lg-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <div class="mb-3">
                                                <label class="form-label">Menu Name <span class="text-danger">*</span></label>
                                                <input type="text" name="name" 
                                                       class="form-control @error('name') is-invalid @enderror" 
                                                       value="{{ old('name', $menu->name ?? 'Header Menu') }}" required>
                                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Menu Slug <span class="text-danger">*</span></label>
                                                <input type="text" name="slug" 
                                                       class="form-control @error('slug') is-invalid @enderror" 
                                                       value="{{ old('slug', $menu->slug ?? 'main-menu') }}" required>
                                                <small class="text-muted">e.g., main-menu</small>
                                                @error('slug')<div class="invalid-feedback">{{ $message }}</div>@enderror
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Location</label>
                                                <select name="location" class="form-select">
                                                    <option value="">-- Select Location --</option>
                                                    @foreach($locations ?? [] as $key => $label)
                                                        <option value="{{ $key }}" 
                                                                {{ old('location', $menu->location ?? '') == $key ? 'selected' : '' }}>
                                                            {{ $label }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label">Order</label>
                                                <input type="number" name="order_level" class="form-control" 
                                                       value="{{ old('order_level', $menu->order_level ?? '0') }}" min="0">
                                            </div>

                                            <div class="mb-3">
                                                <label class="form-label d-block">Status</label>
                                                <input type="hidden" name="status" value="0">
                                                <div class="form-check form-switch">
                                                    <input class="form-check-input" type="checkbox" name="status" 
                                                           id="statusSwitch" value="1" 
                                                           {{ (old('status', $menu->status ?? 1)) ? 'checked' : '' }}>
                                                    <label class="form-check-label" for="statusSwitch">Active</label>
                                                </div>
                                            </div>

                                            <button type="submit" class="btn btn-primary w-100 py-2">
                                                <i class="bi bi-save me-2"></i>{{ isset($menu) ? 'Update' : 'Create' }} Menu
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection

@push('styles')
<link rel="stylesheet" href="https://code.jquery.com/ui/1.13.2/themes/base/jquery-ui.css">
<style>
    .ui-sortable-handle { cursor: move; margin-bottom: 5px; }
    .menu-item-box { background: #fff; border: 1px solid #ddd; border-radius: 4px; padding: 10px; transition: all 0.2s; }
    .menu-item-box:hover { border-color: #999; box-shadow: 0 2px 4px rgba(0,0,0,0.1); }
    .sub-menu { margin-left: 30px; margin-top: 5px; border-left: 2px dashed #ddd; padding-left: 10px; }
    .ui-state-highlight { height: 40px; background: #e9ecef; border: 2px dashed #999; margin-bottom: 5px; border-radius: 4px; }
</style>
@endpush

@push('scripts')
<script src="https://code.jquery.com/ui/1.13.2/jquery-ui.min.js"></script>
<script>
    $(document).ready(function() {
        // Initialize sortable
        $("#sortableMenu, .sub-menu").sortable({
            placeholder: "ui-state-highlight",
            connectWith: "#sortableMenu, .sub-menu",
            tolerance: "pointer",
            cursor: "move",
            update: function() {
                $('#emptyMessage').toggle($('#sortableMenu').children('li').length === 0);
            }
        }).disableSelection();

        // Add custom link
        $('#addCustomLinkBtn').click(function() {
            const url = $('#customLinkUrl').val().trim();
            const title = $('#customLinkText').val().trim();
            if(url && title) {
                addItem(title, url, 'custom');
                $('#customLinkUrl,#customLinkText').val('');
            } else {
                toastr.warning('Please fill both URL and Text');
            }
        });

        // Add routes
        $('#addRoutesBtn').click(function() {
            $('.route-check:checked').each(function() {
                const name = $(this).data('route-name');
                const url = $(this).val();
                addItem(name, url, 'route');
                $(this).prop('checked', false);
            });
        });

        // Remove item
        $(document).on('click', '.remove-btn', function() {
            $(this).closest('li').remove();
        });

        // Form submit
        $('#menuForm').submit(function(e) {
            e.preventDefault();
            
            const formData = new FormData(this);
            formData.append('menu_items', JSON.stringify(serializeMenu()));
            formData.set('status', $('#statusSwitch').is(':checked') ? '1' : '0');
            
            const btn = $(this).find('button[type="submit"]');
            const originalText = btn.html();
            btn.prop('disabled', true).html('<span class="spinner-border spinner-border-sm me-2"></span>Saving...');
            
            $.ajax({
                type: 'POST',
                url: $(this).attr('action'),
                data: formData,
                contentType: false,
                processData: false,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
                success: function(res) {
                    toastr.success(res.message || 'Menu saved successfully!');
                    setTimeout(() => location.href = '{{ route("admin.menu.index") }}', 1000);
                },
                error: function(xhr) {
                    btn.prop('disabled', false).html(originalText);
                    if(xhr.responseJSON?.errors) {
                        $.each(xhr.responseJSON.errors, function(field, errors) {
                            $(`[name="${field}"]`).addClass('is-invalid')
                                .after(`<div class="invalid-feedback d-block">${errors[0]}</div>`);
                        });
                    }
                    toastr.error(xhr.responseJSON?.message || 'Failed to save menu');
                }
            });
        });

        // Functions
        function addItem(title, url, type) {
            const id = 'item_' + Date.now() + '_' + Math.random().toString(36).substr(2, 9);
            $('#sortableMenu').append(`
                <li class="ui-sortable-handle" data-title="${title}" data-url="${url}" data-type="${type}" id="${id}">
                    <div class="menu-item-box d-flex justify-content-between align-items-center">
                        <div class="d-flex align-items-center">
                            <i class="bi bi-grip-vertical text-muted me-2" style="cursor: move;"></i>
                            <div>
                                <strong>${title}</strong> 
                                <span class="badge bg-secondary ms-1">${type}</span>
                                <div class="text-muted small">${url}</div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-sm btn-outline-danger remove-btn">
                            <i class="bi bi-x"></i>
                        </button>
                    </div>
                    <ul class="sub-menu list-unstyled"></ul>
                </li>
            `);
            $('#emptyMessage').hide();
        }

        function serializeMenu($el = $('#sortableMenu')) {
            const items = [];
            $el.children('li').each(function(i) {
                const $item = $(this);
                const data = {
                    title: $item.data('title'),
                    url: $item.data('url'),
                    type: $item.data('type'),
                    order: i
                };
                if($item.children('.sub-menu').children('li').length > 0) {
                    data.children = serializeMenu($item.children('.sub-menu'));
                }
                items.push(data);
            });
            return items;
        }
    });
</script>
@endpush