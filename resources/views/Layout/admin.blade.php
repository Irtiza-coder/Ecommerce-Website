<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel') | Crest & Clove</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    @yield('extra_styles')
</head>

<body>

    <div class="admin_sidebar_overlay" id="adminSidebarOverlay" onclick="toggleSidebar()"></div>

    <div class="admin_wrapper">

        <!-- Sidebar -->
        <div class="admin_sidebar" id="adminSidebar">
            <div class="admin_brand">
                <div class="admin_brand_logo_icon">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <div class="admin_brand_info">
                    <h4>Crest <span>&amp;</span> Clove</h4>
                    <span class="admin_badge_role"><i class="fa-solid fa-shield-halved me-1"></i> Admin Panel</span>
                </div>
            </div>

            <div class="admin_nav_section">
                <div class="admin_nav_label"><i class="fa-solid fa-compass"></i> Overview</div>
                <a href="{{ route('admin.dashboard') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fa-solid fa-gauge"></i> Dashboard
                </a>
                <a href="{{ url('/') }}" target="_blank" class="admin_nav_link">
                    <i class="fa-solid fa-arrow-up-right-from-square"></i> View Storefront
                </a>
            </div>

            <div class="admin_nav_section">
                <div class="admin_nav_label">Website Management</div>
                <a href="{{ route('admin.homepage.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.homepage.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-house"></i> Homepage Content
                </a>
                <a href="{{ route('admin.shop.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.shop.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-store"></i> Shop Page Content
                </a>
                <a href="{{ route('admin.collections.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.collections.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-layer-group"></i> Collections Content
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.products.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box"></i> Products
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.categories.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-box-open"></i> Categories
                </a>
                <a href="{{ route('admin.about-us.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.about-us.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-star"></i> About Us Content
                </a>
                <a href="{{ route('admin.journal.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.journal.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-book-open"></i> Journal Content
                </a>
                <a href="{{ route('admin.contact-cms.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.contact-cms.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-address-book"></i> Contact Us Content
                </a>
                <a href="{{ route('admin.testimonials.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.testimonials.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope"></i> Testimonials
                </a>

            </div>

            <div class="admin_nav_section">
                <div class="admin_nav_label">Sales & Customers</div>
                <a href="{{ route('admin.orders.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.orders.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-cart-shopping"></i> Orders
                </a>
                <a href="{{ route('admin.customers.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.customers.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-users"></i> Customers
                </a>
            </div>

            <div class="admin_nav_section">
                <div class="admin_nav_label">Communications</div>
                <a href="{{ route('admin.contacts.index') }}"
                    class="admin_nav_link {{ request()->routeIs('admin.contacts.*') ? 'active' : '' }}">
                    <i class="fa-solid fa-envelope-open-text"></i> Contact Inquiries
                </a>
            </div>
        </div>

        <!-- Main -->
        <div class="admin_main">
            <div class="admin_topbar">
                <div class="admin_topbar_left">
                    <button class="admin_sidebar_toggle" id="sidebarToggleBtn" onclick="toggleSidebar()" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                    <h2>
                        @yield('title', 'Dashboard')
                        <span class="page_badge">Admin</span>
                    </h2>
                </div>
                <div class="admin_user">
                    <a href="{{ route('admin.profile') }}" class="admin_profile_chip" title="Account Settings & Change Password">
                        <div class="admin_avatar">{{ strtoupper(substr(session('admin_username', 'A'), 0, 1)) }}</div>
                        <span style="font-weight:600;font-size:14px;">{{ session('admin_username') }}</span>
                        <i class="fa-solid fa-gear"></i>
                    </a>
                    <a href="{{ route('admin.logout') }}" class="btn-logout-admin">
                        <i class="fa-solid fa-arrow-right-from-bracket"></i>
                        <span>Log Out</span>
                    </a>
                </div>
            </div>

            <div class="admin_content">
                @if(session('message'))
                    <div class="alert alert-success">
                        <i class="fa-solid fa-circle-check fs-5"></i>
                        <div>{{ session('message') }}</div>
                    </div>
                @endif
                @if(isset($errors) && $errors->any())
                    <div class="alert alert-danger">
                        <i class="fa-solid fa-triangle-exclamation fs-5"></i>
                        <div>
                            <ul class="mb-0 ps-3">
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('adminSidebar');
            const overlay = document.getElementById('adminSidebarOverlay');
            if (sidebar) sidebar.classList.toggle('open');
            if (overlay) overlay.classList.toggle('active');
        }
    </script>
    @yield('extra_scripts')
</body>

</html>