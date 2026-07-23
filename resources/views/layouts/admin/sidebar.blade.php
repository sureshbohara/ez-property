<aside class="sidebar-wrapper" data-simplebar="true">
    <div class="sidebar-header">
        <div>
            <img src="{{ setting('logo_url') }}" class="logo-icon" alt="{{ config('app.name') }} Logo">
        </div>
        <div>
            <h4 class="logo-text">EZ DASH</h4>
        </div>
        <div class="toggle-icon ms-auto">
            <i class="bi bi-chevron-double-left"></i>
        </div>
    </div>

    <ul class="metismenu" id="menu">

        {{-- === OVERVIEW === --}}
        <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class="bi bi-speedometer2"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

        {{-- === PROPERTY & BOOKINGS === --}}
        @canany(['listing.read', 'amenity.read'])
        <li class="menu-label">Property & Bookings</li>

        <li class="{{ request()->routeIs('listing.booking.*') ? 'mm-active' : '' }}">
            <a href="{{ route('listing.booking.index') }}">
                <div class="parent-icon"><i class="bi bi-calendar-check-fill"></i></div>
                <div class="menu-title">Manage Bookings</div>
            </a>
        </li>
        
        <li class="{{ request()->routeIs(['listing.listing.*', 'listing.amenity.*','listing.availabilities.*']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-buildings"></i></div>
                <div class="menu-title">Listings Manager</div>
            </a>
            <ul>
                @can('listing.read')
                <li class="{{ request()->routeIs('listing.listing.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('listing.listing.index') }}"><i class="bi bi-house-door"></i> All Listings</a>
                </li>
                <li class="{{ request()->routeIs('listing.availabilities.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('listing.availabilities.index') }}"><i class="bi bi-calendar3"></i> Availabilities</a>
                </li>
                @endcan

                @can('amenity.read')
                <li class="{{ request()->routeIs('listing.amenity.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('listing.amenity.index') }}"><i class="bi bi-stars"></i> Amenities</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        {{-- === E-COMMERCE === --}}
        @canany(['brand.read', 'product.read', 'offer.read', 'coupon.read'])
        <li class="menu-label">E-Commerce</li>

        <li class="{{ request()->routeIs(['ecom.brand.*', 'ecom.product.*', 'ecom.product-attribute.*']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-cart3"></i></div>
                <div class="menu-title">Products</div>
            </a>
            <ul>
                @can('product.read')
                <li class="{{ request()->routeIs('ecom.product.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('ecom.product.index') }}"><i class="bi bi-box-seam"></i> All Products</a>
                </li>
                <li class="{{ request()->routeIs('ecom.product-attribute.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('ecom.product-attribute.index') }}"><i class="bi bi-sliders"></i> Attributes</a>
                </li>
                @endcan

                @can('brand.read')
                <li class="{{ request()->routeIs('ecom.brand.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('ecom.brand.index') }}"><i class="bi bi-bookmark-star"></i> Brands</a>
                </li>
                @endcan
            </ul>
        </li>

        @canany(['offer.read', 'coupon.read'])
        <li class="{{ request()->routeIs(['ecom.offer.*', 'ecom.coupon.*']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-gift"></i></div>
                <div class="menu-title">Promotions</div>
            </a>
            <ul>
                @can('offer.read')
                <li class="{{ request()->routeIs('ecom.offer.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('ecom.offer.index') }}"><i class="bi bi-percent"></i> Offers</a>
                </li>
                @endcan

                @can('coupon.read')
                <li class="{{ request()->routeIs('ecom.coupon.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('ecom.coupon.index') }}"><i class="bi bi-ticket-perforated"></i> Coupons</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany
        @endcanany

        {{-- === TOUR & TRAVEL === --}}
        @canany(['category.read', 'package.read'])
        <li class="menu-label">Tour & Travel</li>
        <li class="{{ request()->routeIs(['admin.category.*', 'admin.package.*', 'admin.fix-depature-package', 'admin.package.prices']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-globe-americas"></i></div>
                <div class="menu-title">Trip Manager</div>
            </a>
            <ul>
                @can('category.read')
                <li class="{{ request()->routeIs('admin.category.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.category.index') }}"><i class="bi bi-tags"></i> Categories</a>
                </li>
                @endcan

                @can('package.read')
                <li class="{{ request()->routeIs('admin.package.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.package.index') }}"><i class="bi bi-suitcase-lg"></i> Trip Packages</a>
                </li>
                <li class="{{ request()->routeIs('admin.fix-depature-package') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.fix-depature-package') }}"><i class="bi bi-calendar-event"></i> Fixed Departures</a>
                </li>
                <li class="{{ request()->routeIs('admin.package.prices') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.package.prices') }}"><i class="bi bi-currency-dollar"></i> Trip Pricing</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        {{-- === CONTENT MANAGEMENT === --}}
        @canany(['page.read', 'post.read', 'service.read', 'fleet.read', 'banner.read', 'faq.read', 'review.read', 'gallery.read', 'team.read', 'menu.read'])
        <li class="menu-label">Content Management</li>

        <li class="{{ request()->routeIs(['admin.page.*', 'admin.post.*']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-file-earmark-richtext"></i></div>
                <div class="menu-title">Pages & Blog</div>
            </a>
            <ul>
                @can('page.read')
                <li class="{{ request()->routeIs('admin.page.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.page.index') }}"><i class="bi bi-file-earmark-text"></i> Pages</a>
                </li>
                @endcan

                @can('post.read')
                <li class="{{ request()->routeIs('admin.post.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.post.index') }}"><i class="bi bi-newspaper"></i> Blog Posts</a>
                </li>
                @endcan
            </ul>
        </li>

        <li class="{{ request()->routeIs(['admin.service.*', 'admin.fleet.*']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-briefcase"></i></div>
                <div class="menu-title">Business</div>
            </a>
            <ul>
                @can('service.read')
                <li class="{{ request()->routeIs('admin.service.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.service.index') }}"><i class="bi bi-wrench-adjustable"></i> Services</a>
                </li>
                @endcan

                @can('fleet.read')
                <li class="{{ request()->routeIs('admin.fleet.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.fleet.index') }}"><i class="bi bi-car-front"></i> Fleet</a>
                </li>
                @endcan
            </ul>
        </li>

        <li class="{{ request()->routeIs(['admin.banner.*', 'admin.faq.*', 'admin.review.*', 'admin.gallery.*', 'admin.team.*']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                <div class="menu-title">Site Elements</div>
            </a>
            <ul>
                @can('banner.read')
                <li class="{{ request()->routeIs('admin.banner.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.banner.index') }}"><i class="bi bi-card-image"></i> Banners</a>
                </li>
                @endcan

                @can('faq.read')
                <li class="{{ request()->routeIs('admin.faq.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.faq.index') }}"><i class="bi bi-question-circle"></i> FAQs</a>
                </li>
                @endcan

                @can('review.read')
                <li class="{{ request()->routeIs('admin.review.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.review.index') }}"><i class="bi bi-star-half"></i> Reviews</a>
                </li>
                @endcan

                @can('gallery.read')
                <li class="{{ request()->routeIs('admin.gallery.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.gallery.index') }}"><i class="bi bi-images"></i> Gallery</a>
                </li>
                @endcan

                @can('team.read')
                <li class="{{ request()->routeIs('admin.team.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.team.index') }}"><i class="bi bi-people"></i> Team Members</a>
                </li>
                @endcan
            </ul>
        </li>

        @can('menu.read')
        <li class="{{ request()->routeIs('admin.menu.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.menu.index') }}">
                <div class="parent-icon"><i class="bi bi-menu-button-wide"></i></div>
                <div class="menu-title">Menus</div>
            </a>
        </li>
        @endcan
        @endcanany

        {{-- === MARKETING === --}}
        @canany(['marketing.read'])
        <li class="menu-label">Marketing</li>
        <li class="{{ request()->routeIs('admin.marketing.*') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.marketing.index') }}">
                <div class="parent-icon"><i class="bi bi-envelope-paper"></i></div>
                <div class="menu-title">Email Marketing</div>
            </a>
        </li>
        @endcanany

        {{-- === ADMINISTRATION === --}}
        @canany(['user.read', 'permission.read'])
        <li class="menu-label">Administration</li>
        <li class="{{ request()->routeIs(['admin.user.*', 'admin.permission.*']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-shield-lock"></i></div>
                <div class="menu-title">User Management</div>
            </a>
            <ul>
                @can('user.read')
                <li class="{{ request()->routeIs('admin.user.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.user.index') }}"><i class="bi bi-person-badge"></i> Admin Users</a>
                </li>
                @endcan

                @can('permission.read')
                <li class="{{ request()->routeIs('admin.permission.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.permission.index') }}"><i class="bi bi-key"></i> Roles & Permissions</a>
                </li>
                @endcan
            </ul>
        </li>
        @endcanany

        {{-- === SYSTEM === --}}
        @canany(['setting.read'])
        <li class="menu-label">System</li>
        <li class="{{ request()->routeIs(['admin.settings.*', 'admin.site.health', 'admin.login-activities.*']) ? 'mm-active' : '' }}">
            <a href="javascript:;" class="has-arrow">
                <div class="parent-icon"><i class="bi bi-gear-wide-connected"></i></div>
                <div class="menu-title">Settings</div>
            </a>
            <ul>
                <li class="{{ request()->routeIs('admin.settings.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.settings.index') }}"><i class="bi bi-sliders"></i> General Settings</a>
                </li>
                <li class="{{ request()->routeIs('admin.site.health') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.site.health') }}"><i class="bi bi-heart-pulse"></i> System Health</a>
                </li>
                <li class="{{ request()->routeIs('admin.login-activities.*') ? 'mm-active' : '' }}">
                    <a href="{{ route('admin.login-activities.index') }}"><i class="bi bi-clock-history"></i> Login Activities</a>
                </li>
            </ul>
        </li>
        @endcanany

    </ul>
</aside>