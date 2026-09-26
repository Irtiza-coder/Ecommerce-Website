<header>
    <div class="top_bar">
        <div class="container">
            <div class="row">
                <div class="col-4 col-lg-3">
                    <div class="top_bar_left">
                        <select class="form-select">
                            <option selected>select a location</option>
                            <option>dummy</option>
                            <option>dummy</option>
                            <option>dummy</option>
                        </select>
                        @php
                            $phone = ($topBarCms && $topBarCms->subtitle) ? $topBarCms->subtitle : '123 456 7890';
                        @endphp
                        <a href="tel:{{ preg_replace('/[^0-9+]/', '', $phone) }}"><i
                                class="fa-solid fa-phone"></i>{{ $phone }}</a>
                    </div>
                </div>
                <div class="col-4 col-lg-6">
                    <div class="top_bar_mid">
                        <p>
                            {{ ($topBarCms && $topBarCms->title) ? $topBarCms->title : 'FREE SHIPPING IN 🇺🇸 FOR THE LOWER 48 ON ORDERS OVER $200.00' }}
                        </p>
                    </div>
                </div>
                <div class="col-4 col-lg-3">
                    <ul>
                        <li>
                            <a href="{{ route('wishlist.index') }}">
                                <i class="fa-regular fa-heart"></i>wishlist
                                @php
                                    $wishCount = count(session('wishlist', []));
                                @endphp
                                @if($wishCount > 0)
                                    <span class="badge bg-warning text-dark rounded-pill ms-1"
                                        style="font-size:10px; padding:2px 6px;">{{ $wishCount }}</span>
                                @endif
                            </a>
                        </li>
                        @if(session('user_id'))
                            <li>
                                <a href="{{ route('dashboard') }}" title="My Dashboard">
                                    <i class="fa-solid fa-user-check" style="color:#b8935a;"></i>Hi,
                                    {{ Str::limit(session('user_name'), 10) }}
                                </a>
                            </li>

                        @else
                            <li>
                                <a href="/account"><i class="fa-regular fa-user"></i>Account</a>
                            </li>
                        @endif
                        <li>
                            <a href="{{ route('admin.login') }}" title="Admin Portal"
                                style="font-size:11px; opacity:0.8;">
                                <i class="fa-solid fa-shield-halved"></i>Admin
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="Second-Bar">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-6 col-lg-2">
                    <img src="{{ asset('images/logo.png') }}" alt="Logo" class="logo_img" />
                </div>
                <div class="col-6 d-lg-none text-end">
                    <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                        data-bs-target="#mainNavCollapse" aria-label="Toggle navigation">
                        <i class="fa-solid fa-bars"></i>
                    </button>
                </div>
                <div class="col-lg-7 order-3 order-lg-2">
                    <div class="mainNavCollapse" id="mainNavCollapse">
                        <ul class="second_bar_menu">
                            <li><a href="/" class="{{request()->is('/') ? 'active' : ''}}">Home</a></li>
                            <li>
                                <a href="/shop"
                                    class="{{ request()->is('shop*') || request()->is('detail*') ? 'active' : '' }}"
                                    data-bs-display="static">Shop</a>
                            </li>
                            <li class="dropdown">
                                <a href="/collections"
                                    class="dropdown-toggle {{request()->is('collections') ? 'active' : ''}}"
                                    data-bs-toggle="dropdown" data-bs-display="static">Collections</a>
                                <ul class="dropdown-menu">
                                    <li>
                                        <a class="dropdown-item" href="/collections">All Collections</a>
                                    </li>
                                    <li>
                                        <a class="dropdown-item" href="/shop">Best Sellers</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="/about-us" class="{{request()->is('about-us*') ? 'active' : ''}}">About Us</a>
                            </li>
                            <li><a href="/journal" class="{{request()->is('journal*') ? 'active' : ''}}">Journal</a>
                            </li>
                            <li><a href="/contact-us"
                                    class="{{request()->is('contact-us*') ? 'active' : ''}}">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-3 order-2 order-lg-3">
                    <div class="second_bar_cart">
                        <span>CART</span>
                        <a href="{{ route('cart.index') }}" class="cart_icon position-relative">
                            <i class="fa-solid fa-bag-shopping"></i>
                            @php
                                $cartCount = array_sum(array_column(session('cart', []), 'quantity'));
                            @endphp
                            @if($cartCount > 0)
                                <span class="cart_count">{{ $cartCount }}</span>
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>