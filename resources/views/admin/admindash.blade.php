@extends('Layout.admin')
@section('title', 'Admin Dashboard')

@section('content')

    <!-- Welcome Hero Banner -->
    <div class="admin_hero_banner">
        <div>
            <h3>Welcome back, {{ session('admin_username', 'Administrator') }} 👋</h3>
            <p>Here is what is happening across Crest &amp; Clove today. Manage your store performance, orders, inventory alerts, and storefront content in real-time.</p>
        </div>
        <div class="d-flex flex-column flex-sm-row gap-2 align-items-start align-items-sm-center">
            <div class="admin_hero_date">
                <i class="fa-regular fa-calendar-days text-warning"></i>
                <span>{{ date('l, F j, Y') }}</span>
            </div>
            <a href="{{ route('admin.products.create') }}" class="admin_btn_primary text-nowrap">
                <i class="fa-solid fa-plus"></i> Add Product
            </a>
        </div>
    </div>

    <!-- Stat Metric Cards -->
    <div class="admin_stat_cards">
        <!-- Revenue Card -->
        <div class="admin_stat_card">
            <div class="admin_stat_header">
                <h5>Total Revenue</h5>
                <div class="admin_stat_icon_badge">
                    <i class="fa-solid fa-coins"></i>
                </div>
            </div>
            <div class="stat_value">${{ number_format($totalRevenue ?? 0, 2) }}</div>
            <div class="admin_stat_footer">
                <span class="stat_tag positive"><i class="fa-solid fa-arrow-trend-up me-1"></i>Completed</span>
                <span>From fulfilled orders</span>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="admin_stat_card">
            <div class="admin_stat_header">
                <h5>Total Orders</h5>
                <div class="admin_stat_icon_badge">
                    <i class="fa-solid fa-cart-shopping"></i>
                </div>
            </div>
            <div class="stat_value">{{ $totalOrders ?? 0 }}</div>
            <div class="admin_stat_footer">
                @if(($pendingOrders ?? 0) > 0)
                    <span class="stat_tag warning">{{ $pendingOrders }} Pending</span>
                @else
                    <span class="stat_tag positive">All clear</span>
                @endif
                <a href="{{ route('admin.orders.index') }}" class="ms-auto" style="font-size:12px;">View orders &rarr;</a>
            </div>
        </div>

        <!-- Products Card -->
        <div class="admin_stat_card">
            <div class="admin_stat_header">
                <h5>Store Products</h5>
                <div class="admin_stat_icon_badge">
                    <i class="fa-solid fa-box"></i>
                </div>
            </div>
            <div class="stat_value">{{ $totalProducts ?? 0 }}</div>
            <div class="admin_stat_footer">
                @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                    <span class="stat_tag warning">{{ $lowStockProducts->count() }} low stock</span>
                @else
                    <span class="stat_tag positive">Healthy stock</span>
                @endif
                <a href="{{ route('admin.products.index') }}" class="ms-auto" style="font-size:12px;">Catalog &rarr;</a>
            </div>
        </div>

        <!-- Customers Card -->
        <div class="admin_stat_card">
            <div class="admin_stat_header">
                <h5>Customers</h5>
                <div class="admin_stat_icon_badge">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <div class="stat_value">{{ $totalCustomers ?? 0 }}</div>
            <div class="admin_stat_footer">
                <span class="stat_tag info">Registered</span>
                <a href="{{ route('admin.customers.index') }}" class="ms-auto" style="font-size:12px;">Manage &rarr;</a>
            </div>
        </div>

        <!-- Inquiries Card -->
        <div class="admin_stat_card">
            <div class="admin_stat_header">
                <h5>Messages</h5>
                <div class="admin_stat_icon_badge">
                    <i class="fa-solid fa-envelope-open-text"></i>
                </div>
            </div>
            <div class="stat_value">{{ $totalMessages ?? 0 }}</div>
            <div class="admin_stat_footer">
                <span class="stat_tag info">Inquiries</span>
                <a href="{{ route('admin.contacts.index') }}" class="ms-auto" style="font-size:12px;">Inbox &rarr;</a>
            </div>
        </div>
    </div>

    <!-- Main Content 2-Column Grid -->
    <div class="row g-4">
        <!-- Left Column: Recent Orders & Quick CMS -->
        <div class="col-lg-8">
            <!-- Recent Orders Widget -->
            <div class="admin_card">
                <div class="admin_card_header">
                    <div>
                        <i class="fa-solid fa-clock-rotate-left"></i>
                        <span>Recent Orders</span>
                    </div>
                    <a href="{{ route('admin.orders.index') }}" class="admin_btn_gold_outline" style="padding:4px 12px;font-size:12px;">
                        View All <i class="fa-solid fa-chevron-right ms-1" style="font-size:10px;"></i>
                    </a>
                </div>
                <div class="admin_card_body p-0">
                    <div class="table-responsive">
                        <table class="admin_table mb-0" style="min-width:650px;">
                            <thead>
                                <tr>
                                    <th>Order #</th>
                                    <th>Customer</th>
                                    <th>Items</th>
                                    <th>Total</th>
                                    <th>Status</th>
                                    <th>Date</th>
                                    <th class="text-end">Details</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if(isset($recentOrders) && $recentOrders->count() > 0)
                                    @foreach($recentOrders as $order)
                                        <tr>
                                            <td style="font-weight:700;color:var(--accent-gold);">
                                                #{{ $order->id }}
                                            </td>
                                            <td>
                                                <div style="font-weight:600;color:#1a1a1a;">
                                                    {{ $order->first_name }} {{ $order->last_name }}
                                                </div>
                                                <div style="font-size:11px;color:var(--text-muted);">{{ $order->email }}</div>
                                            </td>
                                            <td>
                                                <span class="badge" style="background:#f3ede2;color:#787267;border:1px solid #e0d7c7;">
                                                    {{ $order->items ? $order->items->count() : 0 }} items
                                                </span>
                                            </td>
                                            <td style="font-weight:700;color:#1a1a1a;">
                                                ${{ number_format($order->total_amount, 2) }}
                                            </td>
                                            <td>
                                                @php
                                                    $st = strtolower($order->status ?? 'pending');
                                                @endphp
                                                <span class="badge_status {{ $st }}">
                                                    <i class="fa-solid fa-circle" style="font-size:6px;"></i>
                                                    {{ ucfirst($order->status ?? 'pending') }}
                                                </span>
                                            </td>
                                            <td style="font-size:12px;color:var(--text-muted);">
                                                {{ $order->created_at ? $order->created_at->format('M j, Y') : 'N/A' }}
                                            </td>
                                            <td class="text-end">
                                                <a href="{{ route('admin.orders.show', $order->id) }}" class="admin_btn_secondary" style="padding:4px 10px;font-size:12px;">
                                                    <i class="fa-solid fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="7" class="text-center py-5 text-muted">
                                            <div style="font-size:36px;color:#2a3142;margin-bottom:12px;">
                                                <i class="fa-solid fa-cart-shopping"></i>
                                            </div>
                                            <div style="font-size:14px;font-weight:500;color:var(--text-secondary);">No orders received yet</div>
                                            <div style="font-size:12px;color:var(--text-muted);margin-top:4px;">When customers complete checkouts, their orders will appear here.</div>
                                        </td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Website CMS Quick Management Grid -->
            <div class="admin_card">
                <div class="admin_card_header">
                    <div>
                        <i class="fa-solid fa-sliders"></i>
                        <span>Website Content &amp; Pages (CMS)</span>
                    </div>
                    <span style="font-size:12px;color:var(--text-muted);font-weight:normal;">Live Storefront Editors</span>
                </div>
                <div class="admin_card_body">
                    <div class="quick_action_grid">
                        <a href="{{ route('admin.homepage.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-house"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">Homepage</div>
                                <div class="quick_action_desc">Hero, banners &amp; promo text</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.shop.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-store"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">Shop Page</div>
                                <div class="quick_action_desc">Categories banner &amp; intro</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.collections.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-layer-group"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">Collections</div>
                                <div class="quick_action_desc">Curated season showcases</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.products.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-box"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">Products Catalog</div>
                                <div class="quick_action_desc">Prices, photos, stock quantity</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.categories.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-box-open"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">Categories</div>
                                <div class="quick_action_desc">Product groups &amp; filters</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.about-us.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-star"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">About Us</div>
                                <div class="quick_action_desc">Story, values &amp; team</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.journal.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-book-open"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">Journal &amp; Blog</div>
                                <div class="quick_action_desc">Articles, news &amp; guides</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.contact-cms.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-address-book"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">Contact Page</div>
                                <div class="quick_action_desc">Address, email &amp; phone</div>
                            </div>
                        </a>

                        <a href="{{ route('admin.testimonials.index') }}" class="quick_action_tile">
                            <div class="quick_action_icon">
                                <i class="fa-solid fa-comments"></i>
                            </div>
                            <div>
                                <div class="quick_action_title">Testimonials</div>
                                <div class="quick_action_desc">Customer quotes &amp; ratings</div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Right Column: Low Stock Alerts & Quick Tools -->
        <div class="col-lg-4">
            <!-- Inventory Alerts -->
            <div class="admin_card">
                <div class="admin_card_header">
                    <div>
                        <i class="fa-solid fa-triangle-exclamation text-warning"></i>
                        <span>Stock Alerts</span>
                    </div>
                    @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                        <span class="badge bg-warning text-dark">{{ $lowStockProducts->count() }} Low</span>
                    @endif
                </div>
                <div class="admin_card_body p-0">
                    @if(isset($lowStockProducts) && $lowStockProducts->count() > 0)
                        <ul class="list-group list-group-flush" style="background:transparent;">
                            @foreach($lowStockProducts as $low)
                                <li class="list-group-item d-flex align-items-center justify-content-between py-3 px-3 border-secondary"
                                    style="background:transparent;border-color:var(--border-color)!important;">
                                    <div class="d-flex align-items-center gap-3 min-w-0">
                                        <div style="width:38px;height:38px;border-radius:8px;background:var(--input-bg);border:1px solid var(--border-color);display:flex;align-items:center;justify-content:center;overflow:hidden;flex-shrink:0;">
                                            <img src="{{ $low->image_url }}" alt="{{ $low->name }}" style="width:100%;height:100%;object-fit:cover;">
                                        </div>
                                        <div class="text-truncate">
                                            <div style="font-size:13.5px;font-weight:600;color:#1a1a1a;" class="text-truncate">
                                                {{ $low->name }}
                                            </div>
                                            <div style="font-size:12px;color:var(--accent-gold);">
                                                ${{ number_format($low->price, 2) }}
                                            </div>
                                        </div>
                                    </div>
                                    <div class="d-flex align-items-center gap-2 flex-shrink-0 ms-2">
                                        <span class="badge_status lowstock" style="font-size:11px;">
                                            {{ $low->stock_quantity }} left
                                        </span>
                                        <a href="{{ route('admin.products.edit', $low->id) }}" class="admin_btn_secondary" style="padding:4px 8px;font-size:11px;" title="Restock / Edit">
                                            <i class="fa-solid fa-pen"></i>
                                        </a>
                                    </div>
                                </li>
                            @endforeach
                        </ul>
                    @else
                        <div class="p-4 text-center text-muted">
                            <i class="fa-solid fa-circle-check text-success fs-3 mb-2 d-block"></i>
                            <div style="font-size:13px;color:var(--text-secondary);font-weight:500;">All products in stock</div>
                            <div style="font-size:11.5px;color:var(--text-muted);margin-top:2px;">No products are currently critically low.</div>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Quick Management Shortcuts -->
            <div class="admin_card">
                <div class="admin_card_header">
                    <div>
                        <i class="fa-solid fa-bolt"></i>
                        <span>Quick Shortcuts</span>
                    </div>
                </div>
                <div class="admin_card_body d-flex flex-column gap-2">
                    <a href="{{ route('admin.products.create') }}" class="admin_btn_primary justify-content-center">
                        <i class="fa-solid fa-circle-plus"></i> Add New Product
                    </a>
                    <a href="{{ route('admin.contacts.index') }}" class="admin_btn_secondary justify-content-center">
                        <i class="fa-solid fa-inbox"></i> View Inquiries ({{ $totalMessages ?? 0 }})
                    </a>
                    <a href="{{ route('admin.profile') }}" class="admin_btn_secondary justify-content-center">
                        <i class="fa-solid fa-key"></i> Change Admin Password
                    </a>
                    <a href="{{ url('/') }}" target="_blank" class="admin_btn_gold_outline justify-content-center">
                        <i class="fa-solid fa-arrow-up-right-from-square"></i> Visit Public Storefront
                    </a>
                </div>
            </div>

            <!-- System Overview Card -->
            <div class="admin_card">
                <div class="admin_card_header">
                    <div>
                        <i class="fa-solid fa-server"></i>
                        <span>System Status</span>
                    </div>
                    <span class="badge bg-success-subtle text-success border border-success" style="font-size:10px;padding:3px 8px;">
                        <i class="fa-solid fa-circle" style="font-size:6px;"></i> Live
                    </span>
                </div>
                <div class="admin_card_body py-2 px-3">
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;font-size:12.5px;">
                        <span class="text-muted">Platform</span>
                        <span class="fw-semibold text-dark">Crest &amp; Clove v2.4</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;font-size:12.5px;">
                        <span class="text-muted">Environment</span>
                        <span class="fw-semibold text-dark">{{ app()->environment() }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2 border-bottom" style="border-color:var(--border-color)!important;font-size:12.5px;">
                        <span class="text-muted">PHP Engine</span>
                        <span class="fw-semibold text-dark">{{ phpversion() }}</span>
                    </div>
                    <div class="d-flex justify-content-between py-2" style="font-size:12.5px;">
                        <span class="text-muted">Admin Session</span>
                        <span class="fw-semibold" style="color:var(--accent-gold);">{{ session('admin_username') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection