@extends('Layout.admin')
@section('title', 'Customers')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div>
        <h4 class="mb-1" style="font-weight:700;">Customer Management</h4>
        <p class="text-secondary mb-0" style="font-size:13px;">View registered customer accounts, order history, and lifetime spending.</p>
    </div>
</div>

@if(session('message'))
<div style="background:rgba(74,222,128,0.12);border:1px solid rgba(74,222,128,0.3);border-radius:8px;padding:12px 18px;margin-bottom:20px;color:#4ade80;font-size:14px;">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('message') }}
</div>
@endif

<!-- Search & Counts -->
<div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
    <div style="font-size:14px;color:var(--text-muted);">
        Total Registered Customers: <strong style="color:#1a1a1a;">{{ $totalCustomers }}</strong>
    </div>

    <form method="GET" action="{{ route('admin.customers.index') }}" class="d-flex gap-2">
        <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search customer name or email..." 
               class="admin_form_control" style="font-size:13px;min-width:260px;">
        <button type="submit" class="admin_btn_primary" style="padding:6px 14px;font-size:13px;">
            <i class="fa-solid fa-magnifying-glass"></i>
        </button>
        @if(!empty($search))
            <a href="{{ route('admin.customers.index') }}" class="admin_btn_secondary" style="font-size:13px;padding:6px 12px;">Clear</a>
        @endif
    </form>
</div>

<!-- Customers Table -->
<div class="admin_card">
    <div class="admin_card_body p-0">
        <div class="table-responsive">
            <table class="admin_table mb-0" style="min-width:650px;">
                <thead>
                    <tr>
                        <th style="padding:14px 18px;">Customer</th>
                        <th style="padding:14px 18px;">Email</th>
                        <th style="padding:14px 18px;text-align:center;">Orders</th>
                        <th style="padding:14px 18px;">Total Spent</th>
                        <th style="padding:14px 18px;">Joined Date</th>
                        <th style="padding:14px 18px;text-align:right;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($customers as $customer)
                    <tr>
                        <td style="padding:14px 18px;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:38px;height:38px;border-radius:50%;background:var(--accent-gold-subtle);color:var(--accent-gold);display:flex;align-items:center;justify-content:center;font-weight:700;font-size:14px;border:1px solid rgba(184,147,90,0.25);flex-shrink:0;">
                                    {{ strtoupper(substr($customer->First_name, 0, 1)) }}
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:14px;color:#1a1a1a;">{{ $customer->First_name }} {{ $customer->Last_name }}</div>
                                    <small class="text-muted">User #{{ $customer->id }}</small>
                                </div>
                            </div>
                        </td>
                        <td style="padding:14px 18px;font-size:13px;">
                            <a href="mailto:{{ $customer->email }}" style="color:var(--accent-gold);text-decoration:none;">{{ $customer->email }}</a>
                        </td>
                        <td style="padding:14px 18px;text-align:center;">
                            <span class="badge" style="background:#f3ede2;color:#6b6355;border:1px solid #e0d7c7;font-size:12px;padding:5px 10px;">
                                {{ $customer->orders_count }} {{ Str::plural('order', $customer->orders_count) }}
                            </span>
                        </td>
                        <td style="padding:14px 18px;">
                            <strong style="color:var(--accent-gold);font-size:14px;">${{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}</strong>
                        </td>
                        <td style="padding:14px 18px;font-size:13px;color:var(--text-muted);">
                            {{ $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A' }}
                        </td>
                        <td style="padding:14px 18px;text-align:right;">
                            <button type="button" class="btn_admin_edit" data-bs-toggle="modal" data-bs-target="#customerModal{{ $customer->id }}">
                                <i class="fa-solid fa-eye me-1"></i> View Details
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" style="padding:40px 20px;text-align:center;color:var(--text-muted);">
                            <i class="fa-solid fa-users-slash fa-2x mb-3 d-block" style="opacity:0.4;"></i>
                            No registered customers found.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($customers->hasPages())
        <div style="padding:16px 20px;border-top:1px solid var(--border-color);">
            {{ $customers->links() }}
        </div>
        @endif
    </div>
</div>

<!-- Customer Modals -->
@foreach($customers as $customer)
<div class="modal fade" id="customerModal{{ $customer->id }}" tabindex="-1" aria-labelledby="customerModalLabel{{ $customer->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content" style="background:#ffffff;border:1px solid var(--border-color);color:#1a1a1a;border-radius:12px;box-shadow:var(--shadow-lg);">
            <div class="modal-header" style="border-bottom:1px solid var(--border-color);padding:18px 24px;background:#faf8f5;">
                <div class="d-flex align-items-center gap-3">
                    <div style="width:44px;height:44px;border-radius:50%;background:linear-gradient(135deg, #c8a96e 0%, #b8935a 100%);color:#ffffff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:18px;">
                        {{ strtoupper(substr($customer->First_name, 0, 1)) }}
                    </div>
                    <div>
                        <h5 class="modal-title mb-0" id="customerModalLabel{{ $customer->id }}" style="font-weight:700;color:#1a1a1a;">
                            {{ $customer->First_name }} {{ $customer->Last_name }}
                        </h5>
                        <small style="color:var(--text-muted);">Customer #{{ $customer->id }} &bull; Member since {{ $customer->created_at ? $customer->created_at->format('M d, Y') : 'N/A' }}</small>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" style="padding:24px;">
                <!-- Summary Stats -->
                <div class="row g-3 mb-4">
                    <div class="col-md-6">
                        <div class="p-3 rounded" style="background:#faf8f5;border:1px solid var(--border-color);">
                            <span class="text-muted" style="font-size:12px;text-transform:uppercase;font-weight:600;">Email Address</span>
                            <div style="font-size:14px;font-weight:600;color:#1a1a1a;margin-top:4px;">{{ $customer->email }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 rounded" style="background:#faf8f5;border:1px solid var(--border-color);">
                            <span class="text-muted" style="font-size:12px;text-transform:uppercase;font-weight:600;">Total Orders</span>
                            <div style="font-size:16px;font-weight:700;color:#1a1a1a;margin-top:4px;">{{ $customer->orders_count }}</div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="p-3 rounded" style="background:#faf8f5;border:1px solid var(--border-color);">
                            <span class="text-muted" style="font-size:12px;text-transform:uppercase;font-weight:600;">Total Spent</span>
                            <div style="font-size:16px;font-weight:700;color:var(--accent-gold);margin-top:4px;">${{ number_format($customer->orders_sum_total_amount ?? 0, 2) }}</div>
                        </div>
                    </div>
                </div>

                <!-- Recent Orders from this customer -->
                <h6 style="font-weight:700;font-size:14px;color:#1a1a1a;margin-bottom:12px;">
                    <i class="fa-solid fa-clock-rotate-left me-1" style="color:var(--accent-gold);"></i> Recent Orders
                </h6>
                <div class="table-responsive rounded" style="border:1px solid var(--border-color);">
                    <table class="admin_table mb-0" style="font-size:13px;">
                        <thead>
                            <tr>
                                <th style="padding:10px 14px;">Order ID</th>
                                <th style="padding:10px 14px;">Date</th>
                                <th style="padding:10px 14px;">Payment</th>
                                <th style="padding:10px 14px;">Status</th>
                                <th style="padding:10px 14px;text-align:right;">Total</th>
                                <th style="padding:10px 14px;text-align:right;">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($customer->orders()->latest()->take(5)->get() as $co)
                            <tr>
                                <td style="padding:10px 14px;"><strong style="color:var(--accent-gold);">#{{ $co->id }}</strong></td>
                                <td style="padding:10px 14px;">{{ $co->created_at->format('M d, Y') }}</td>
                                <td style="padding:10px 14px;">{{ $co->payment_method }}</td>
                                <td style="padding:10px 14px;">
                                    <span class="badge_status {{ strtolower($co->status ?? 'pending') }}">{{ $co->status }}</span>
                                </td>
                                <td style="padding:10px 14px;text-align:right;font-weight:700;color:#1a1a1a;">${{ number_format($co->total_amount, 2) }}</td>
                                <td style="padding:10px 14px;text-align:right;">
                                    <a href="{{ route('admin.orders.show', $co) }}" class="btn_admin_edit" style="font-size:11px;padding:3px 8px;">
                                        View
                                    </a>
                                </td>
                            </tr>
                            @empty
                            <tr>
                                <td colspan="6" class="text-center py-3 text-muted">No orders placed by this customer yet.</td>
                            </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer" style="border-top:1px solid var(--border-color);padding:14px 24px;background:#faf8f5;">
                <button type="button" class="admin_btn_secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
@endforeach

@endsection
