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
     
        
        <li class="{{ request()->routeIs('admin.dashboard') ? 'mm-active' : '' }}">
            <a href="{{ route('admin.dashboard') }}">
                <div class="parent-icon"><i class="bi bi-speedometer2"></i></div>
                <div class="menu-title">Dashboard</div>
            </a>
        </li>

    
        @canany(['page.read', 'post.read', 'service.read', 'fleet.read'])
            <li class="menu-label">Core Content</li>

            @can('page.read')
            <li class="{{ request()->routeIs('admin.page.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.page.index') }}">
                    <div class="parent-icon"><i class="bi bi-file-earmark-richtext"></i></div>
                    <div class="menu-title">Pages</div>
                </a>
            </li>
            @endcan

            @can('post.read')
            <li class="{{ request()->routeIs('admin.post.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.post.index') }}">
                    <div class="parent-icon"><i class="bi bi-newspaper"></i></div>
                    <div class="menu-title">Blog Posts</div>
                </a>
            </li>
            @endcan

            @can('service.read')
            <li class="{{ request()->routeIs('admin.service.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.service.index') }}">
                    <div class="parent-icon"><i class="bi bi-briefcase"></i></div>
                    <div class="menu-title">Services</div>
                </a>
            </li>
            @endcan

            @can('fleet.read')
            <li class="{{ request()->routeIs('admin.fleet.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.fleet.index') }}">
                    <div class="parent-icon"><i class="bi bi-car-front"></i></div>
                    <div class="menu-title">Fleet</div>
                </a>
            </li>
            @endcan
        @endcanany

  
        @canany(['banner.read', 'category.read', 'faq.read', 'review.read', 'gallery.read', 'team.read'])
            <li class="menu-label">Website Elements</li>

            <li class="{{ request()->routeIs(['admin.banner.*', 'admin.category.*', 'admin.faq.*', 'admin.review.*', 'admin.gallery.*', 'admin.team.*']) ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi bi-grid-3x3-gap"></i></div>
                    <div class="menu-title">Content Manager</div>
                </a>
                <ul>
                    @can('banner.read')
                    <li class="{{ request()->routeIs('admin.banner.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.banner.index') }}"><i class="bi bi-palette"></i> Banners</a>
                    </li>
                    @endcan

                    @can('category.read')
                    <li class="{{ request()->routeIs('admin.category.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.category.index') }}"><i class="bi bi-tags"></i> Categories</a>
                    </li>
                    @endcan

                    @can('faq.read')
                    <li class="{{ request()->routeIs('admin.faq.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.faq.index') }}"><i class="bi bi-question-circle"></i> FAQs</a>
                    </li>
                    @endcan

                    @can('review.read')
                    <li class="{{ request()->routeIs('admin.review.*') ? 'mm-active' : '' }}">
                        <a href="{{ route('admin.review.index') }}"><i class="bi bi-star"></i> Reviews</a>
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
        @endcanany

     
        @can('menu.read')
            <li class="menu-label">Navigation</li>
            <li class="{{ request()->routeIs('admin.menu.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.menu.index') }}">
                    <div class="parent-icon"><i class="bi bi-list-nested"></i></div>
                    <div class="menu-title">Menus</div>
                </a>
            </li>
        @endcan

        @canany(['marketing.read'])
            <li class="menu-label">Marketing</li>
            <li class="{{ request()->routeIs('admin.marketing.*') ? 'mm-active' : '' }}">
                <a href="{{ route('admin.marketing.index') }}">
                    <div class="parent-icon"><i class="bi bi-megaphone"></i></div> 
                    <div class="menu-title">Email Marketing</div>
                </a>
            </li>
         @endcan
 

   
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

     
        @canany(['setting.read'])
            <li class="menu-label">Configuration</li>

            <li class="{{ request()->routeIs(['admin.settings.*', 'admin.site.health', 'admin.login-activities.*']) ? 'mm-active' : '' }}">
                <a href="javascript:;" class="has-arrow">
                    <div class="parent-icon"><i class="bi bi-gear-wide"></i></div>
                    <div class="menu-title">System Settings</div>
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