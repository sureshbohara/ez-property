<header class="top-header">
    <nav class="navbar navbar-expand">
        <div class="mobile-toggle-icon d-xl-none">
            <i class="bi bi-list"></i>
        </div>
        <div class="top-navbar-right ms-3 ms-auto">
            <ul class="navbar-nav align-items-center">
                <li class="nav-item">
                    <a id="darkModeButton" class="nav-link" href="javascript:void(0);">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <img id="moonIcon" src="{{ asset('default/moon_light.png') }}" class="user-img" alt="Theme">
                            <div class="user-name d-none d-sm-block">Light</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="{{ url('/') }}" target="_blank">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <img src="{{ asset('default/website.png') }}" class="user-img" alt="Website">
                            <div class="user-name d-none d-sm-block">View Website</div>
                        </div>
                    </a>
                </li>
                <li class="nav-item dropdown dropdown-large">
                    <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="#" data-bs-toggle="dropdown">
                        <div class="user-setting d-flex align-items-center gap-1">
                            <img src="{{ auth('admin')->user()->image_url }}" class="user-img" alt="User">
                            <div class="user-name d-none d-sm-block">{{ auth('admin')->user()->name }}</div>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <a class="dropdown-item" href="#">
                                <div class="d-flex align-items-center">
                                    <img src="{{ auth('admin')->user()->image_url }}" alt="Profile" class="rounded-circle" width="60" height="60">
                                    <div class="ms-3">
                                        <h6 class="mb-0">{{ auth('admin')->user()->name }}</h6>
                                        <small class="text-secondary">{{ auth('admin')->user()->role?->name }}</small>
                                    </div>
                                </div>
                            </a>
                        </li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="{{ route('admin.profile.update') }}"><i class="bi bi-person-fill me-2"></i>Update Profile</a></li>
                        <li><a class="dropdown-item" href="{{ route('admin.password.update') }}"><i class="bi bi-lock me-2"></i>Change Password</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li>
                            <form action="{{ route('admin.logout') }}" method="POST">
                                @csrf
                                <button type="submit" class="dropdown-item text-success">
                                    <i class="bi bi-box-arrow-right me-2"></i>Logout
                                </button>
                            </form>
                        </li>
                        
                      
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</header>