<aside class="sidebar">
    <button type="button" class="sidebar-close-btn">
        <iconify-icon icon="radix-icons:cross-2"></iconify-icon>
    </button>
    <div>
        <a href="index.html" class="sidebar-logo">
            <img src="{{ asset('admin_assets/images/logo.png') }}" alt="site logo" class="light-logo">
            <img src="{{ asset('admin_assets/images/logo-light.png') }}" alt="site logo" class="dark-logo">
            <img src="{{ asset('admin_assets/images/logo-icon.png') }}" alt="site logo" class="logo-icon">
        </a>
    </div>
    <div class="sidebar-menu-area">
        <ul class="sidebar-menu" id="sidebar-menu">
            <li>
                <a href="{{ route('admin-home') }}">
                    <iconify-icon icon="solar:home-smile-angle-outline" class="menu-icon"></iconify-icon>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-menu-group-title">Application</li>

            <li class="dropdown">
                <a href="javascript:void(0)">
                    <iconify-icon icon="iconoir:post" class="menu-icon"></iconify-icon>
                    <span>Blog</span>
                </a>
                <ul class="sidebar-submenu">
                    <li>
                        <a href="{{ route('all-posts') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Manage</a>
                    </li>
                    <li>
                        <a href="{{ route('all-categories') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Categories</a>
                    </li>
                    <li>
                        <a href="{{ route('all-tags') }}"><i
                                class="ri-circle-fill circle-icon text-primary-600 w-auto"></i>
                            Tags</a>
                    </li>
                </ul>
            </li>

            <li>
                <a href="{{ route('all-applications') }}">
                    <iconify-icon icon="mingcute:paper-line" class="menu-icon"></iconify-icon>
                    <span>Applications</span>
                </a>
            </li>

            <li>
                <a href="{{ route('all-plans') }}">
                    <iconify-icon icon="ph:package-light" class="menu-icon"></iconify-icon>
                    <span>Plans</span>
                </a>
            </li>
            <li>
                <a href="{{ route('all-withdrawals') }}">
                    <iconify-icon icon="ph:hand-withdraw" class="menu-icon"></iconify-icon>
                    <span>Withdrawals Requests</span>
                </a>
            </li>
            <li>
                <a href="{{ route('all-affiliates') }}">
                    <iconify-icon icon="solar:hand-money-linear" class="menu-icon"></iconify-icon>
                    <span>Manage Affiliates</span>
                </a>
            </li>
            <li>
                <a href="{{ route('all-users') }}">
                    <iconify-icon icon="ri:user-line" class="menu-icon"></iconify-icon>
                    <span>Manage Users</span>
                </a>
            </li>
            <li>
                <a href="{{ route('all-admins') }}">
                    <iconify-icon icon="ri:admin-line" class="menu-icon"></iconify-icon>
                    <span>Manage Admins</span>
                </a>
            </li>
            <li>
                <a href="{{ route('all-feedbacks') }}">
                    <iconify-icon icon="material-symbols-light:feedback-outline" class="menu-icon"></iconify-icon>
                    <span>Feedbacks</span>
                </a>
            </li>
            <li>
                <a href="{{ route('all-options') }}">
                    <iconify-icon icon="solar:settings-broken" class="menu-icon"></iconify-icon>
                    <span>Settings</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
