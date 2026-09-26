@extends('Layout.admin')
@section('title', 'Order #' . $order->id)

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
    <div class="d-flex align-items-center gap-3">
        <a href="{{ route('admin.orders.index') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;">
            <i class="fa-solid fa-arrow-left"></i> Back to Orders
        </a>
        <div>
            <h4 class="mb-0" style="font-weight:700;">
                Order <span style="color:var(--accent);">#{{ $order->id }}</span>
            </h4>
            <small class="text-secondary">Placed on {{ $order->created_at->format('F d, Y \a\t h:i A') }}</small>
        </div>
    </div>
    <div class="d-flex gap-2">
        <button onclick="window.print()" class="btn btn-outline-light btn-sm" style="display:inline-flex;align-items:center;gap:6px;">
            <i class="fa-solid fa-print"></i> Print Invoice
        </button>
    </div>
</div>

@if(session('message'))
<div style="background:rgba(74,222,128,0.12);border:1px solid rgba(74,222,128,0.3);border-radius:8px;padding:12px 18px;margin-bottom:20px;color:#4ade80;font-size:14px;">
    <i class="fa-solid fa-circle-check me-2"></i>{{ session('message') }}
</div>
@endif

<!-- Status Control Card -->
<div class="admin_card mb-4">
    <div class="admin_card_body">
        <div class="d-flex justify-content-between align-items-center flex-wrap gap-3">
            <div class="d-flex align-items-center gap-3">
                <span class="text-secondary" style="font-size:13px;text-transform:uppercase;letter-spacing:0.5px;">Order Status:</span>
                @if($order->status === 'completed')
                    <span class="badge bg-success px-3 py-2" style="font-size:13px;"><i class="fa-solid fa-circle-check me-1"></i> Completed</span>
                @elseif($order->status === 'processing')
                    <span class="badge bg-primary px-3 py-2" style="font-size:13px;"><i class="fa-solid fa-arrows-rotate me-1"></i> Processing</span>
                @elseif($order->status === 'cancelled')
                    <span class="badge bg-danger px-3 py-2" style="font-size:13px;"><i class="fa-solid fa-ban me-1"></i> Cancelled</span>
                @else
                    <span class="badge bg-warning text-dark px-3 py-2" style="font-size:13px;"><i class="fa-solid fa-clock me-1"></i> Pending</span>
                @endif
            </div>

            <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="d-flex align-items-center gap-2">
                @csrf
                @method('PUT')
                <span class="text-secondary" style="font-size:13px;">Change Status:</span>
                <select name="status" class="form-select form-select-sm" style="background:#1e2029;color:#fff;border-color:var(--border-color);width:160px;">
                    <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                    <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                    <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
                <button type="submit" class="admin_btn_primary" style="padding:6px 16px;font-size:13px;">Update</button>
            </form>
        </div>
    </div>
</div>

<div class="row g-4 mb-4">
    <!-- Customer Info -->
    <div class="col-lg-6">
        <div class="admin_card h-100">
            <div class="admin_card_header d-flex align-items-center gap-2">
                <i class="fa-solid fa-user" style="color:var(--accent);"></i> Customer Details
            </div>
            <div class="admin_card_body" style="font-size:14px;line-height:1.9;">
                <div><span class="text-secondary">Full Name:</span> <strong>{{ $order->first_name }} {{ $order->last_name }}</strong></div>
                <div><span class="text-secondary">Email:</span> <a href="mailto:{{ $order->email }}" style="color:#60a5fa;text-decoration:none;">{{ $order->email }}</a></div>
                <div><span class="text-secondary">Phone:</span> <a href="tel:{{ $order->phone }}" style="color:#cbd5e1;text-decoration:none;">{{ $order->phone }}</a></div>
                @if($order->company_name)
                    <div><span class="text-secondary">Company:</span> {{ $order->company_name }}</div>
                @endif
                @if($order->user)
                    <div><span class="text-secondary">Registered Account:</span> User #{{ $order->user_id }} ({{ $order->user->email }})</div>
                @endif
            </div>
        </div>
    </div>

    <!-- Shipping & Payment -->
    <div class="col-lg-6">
        <div class="admin_card h-100">
            <div class="admin_card_header d-flex align-items-center gap-2">
                <i class="fa-solid fa-truck" style="color:var(--accent);"></i> Shipping & Payment
            </div>
            <div class="admin_card_body" style="font-size:14px;line-height:1.9;">
                <div><span class="text-secondary">Delivery Address:</span> {{ $order->address }}</div>
                <div><span class="text-secondary">City, Country:</span> {{ $order->city }}, {{ $order->country }}</div>
                <div><span class="text-secondary">Payment Method:</span> 
                    <span class="badge bg-secondary ms-1">{{ $order->payment_method }}</span>
                </div>
                @if($order->order_notes)
                    <div class="mt-2 p-3 rounded" style="background:rgba(255,255,255,0.02);border:1px solid var(--border-color);font-size:13px;">
                        <span class="text-secondary">Customer Notes:</span><br>
                        {{ $order->order_notes }}
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Order Items -->
<div class="admin_card mb-4">
    <div class="admin_card_header d-flex align-items-center justify-content-between">
        <div class="d-flex align-items-center gap-2">
            <i class="fa-solid fa-boxes-stacked" style="color:var(--accent);"></i> Order Items ({{ $order->items->count() }})
        </div>
    </div>
    <div class="admin_card_body p-0">
        <div class="table-responsive">
            <table style="width:100%;border-collapse:collapse;">
                <thead>
                    <tr style="border-bottom:1px solid var(--border-color);background:rgba(255,255,255,0.02);">
                        <th style="padding:14px 20px;font-size:12px;text-transform:uppercase;color:var(--text-muted);font-weight:600;">Product</th>
                        <th style="padding:14px 20px;font-size:12px;text-transform:uppercase;color:var(--text-muted);font-weight:600;text-align:center;">Unit Price</th>
                        <th style="padding:14px 20px;font-size:12px;text-transform:uppercase;color:var(--text-muted);font-weight:600;text-align:center;">Quantity</th>
                        <th style="padding:14px 20px;font-size:12px;text-transform:uppercase;color:var(--text-muted);font-weight:600;text-align:right;">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $item)
                    <tr style="border-bottom:1px solid var(--border-color);">
                        <td style="padding:14px 20px;">
                            <div class="d-flex align-items-center gap-3">
                                <div style="width:50px;height:50px;border-radius:8px;overflow:hidden;border:1px solid var(--border-color);background:#1a1c23;flex-shrink:0;">
                                    <img src="{{ $item->product->image_url ?? asset('images/cards.png') }}" 
                                         alt="{{ $item->product_name }}" 
                                         style="width:100%;height:100%;object-fit:cover;">
                                </div>
                                <div>
                                    <div style="font-weight:600;font-size:14px;color:#fff;">{{ $item->product_name }}</div>
                                    @if($item->product)
                                        <div style="font-size:12px;color:var(--text-muted);">
                                            Category: {{ $item->product->category->name ?? 'General' }}
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td style="padding:14px 20px;text-align:center;font-weight:600;color:var(--accent);font-size:14px;">
                            ${{ number_format($item->price, 2) }}
                        </td>
                        <td style="padding:14px 20px;text-align:center;">
                            <span class="badge bg-dark border border-secondary" style="font-size:13px;padding:6px 12px;">
                                &times; {{ $item->quantity }}
                            </span>
                        </td>
                        <td style="padding:14px 20px;text-align:right;font-weight:700;color:#fff;font-size:15px;">
                            ${{ number_format($item->subtotal, 2) }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>

<!-- Financial Summary -->
<div class="row justify-content-end">
    <div class="col-lg-5">
        <div class="admin_card">
            <div class="admin_card_header">Order Summary</div>
            <div class="admin_card_body" style="font-size:14px;">
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Subtotal</span>
                    <strong>${{ number_format($order->subtotal, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-secondary">Shipping</span>
                    <strong>{{ $order->shipping_fee > 0 ? '$' . number_format($order->shipping_fee, 2) : 'Free Shipping' }}</strong>
                </div>
                <hr style="border-color:var(--border-color);margin:14px 0;">
                <div class="d-flex justify-content-between align-items-center" style="font-size:16px;">
                    <strong style="color:var(--accent);">Total Amount:</strong>
                    <strong style="color:var(--accent);font-size:20px;">${{ number_format($order->total_amount, 2) }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
