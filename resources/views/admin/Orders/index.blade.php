@extends('Layout.admin')
@section('title', 'Orders')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-1" style="font-weight:700;">Customer Orders</h4>
            <p class="text-secondary mb-0" style="font-size:13px;">View and manage customer purchases, payment status, and
                order items.</p>
        </div>
    </div>

    @if(session('message'))
        <div
            style="background:rgba(74,222,128,0.12);border:1px solid rgba(74,222,128,0.3);border-radius:8px;padding:12px 18px;margin-bottom:20px;color:#4ade80;font-size:14px;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('message') }}
        </div>
    @endif

    @if(session('error'))
        <div
            style="background:rgba(248,113,113,0.12);border:1px solid rgba(248,113,113,0.3);border-radius:8px;padding:12px 18px;margin-bottom:20px;color:#f87171;font-size:14px;">
            <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
        </div>
    @endif

    <!-- Quick Filter Tabs & Search -->
    <!-- Quick Filter Tabs & Search -->
    <div class="d-flex justify-content-between align-items-center mb-3 flex-wrap gap-3">
        <div class="d-flex flex-wrap gap-2">
            <a href="{{ route('admin.orders.index') }}"
                style="padding:6px 14px;border-radius:20px;font-size:13px;text-decoration:none;font-weight:600;border:1px solid {{ empty($status) ? 'var(--accent-gold)' : 'var(--border-color)' }};background:{{ empty($status) ? 'var(--accent-gold)' : '#ffffff' }};color:{{ empty($status) ? '#ffffff' : 'var(--text-secondary)' }};">
                All ({{ $statusCounts['all'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'pending']) }}"
                style="padding:6px 14px;border-radius:20px;font-size:13px;text-decoration:none;font-weight:600;border:1px solid {{ $status === 'pending' ? 'var(--warning-border)' : 'var(--border-color)' }};background:{{ $status === 'pending' ? 'var(--warning-bg)' : '#ffffff' }};color:{{ $status === 'pending' ? 'var(--warning)' : 'var(--text-secondary)' }};">
                Pending ({{ $statusCounts['pending'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'processing']) }}"
                style="padding:6px 14px;border-radius:20px;font-size:13px;text-decoration:none;font-weight:600;border:1px solid {{ $status === 'processing' ? 'var(--info-border)' : 'var(--border-color)' }};background:{{ $status === 'processing' ? 'var(--info-bg)' : '#ffffff' }};color:{{ $status === 'processing' ? 'var(--info)' : 'var(--text-secondary)' }};">
                Processing ({{ $statusCounts['processing'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'completed']) }}"
                style="padding:6px 14px;border-radius:20px;font-size:13px;text-decoration:none;font-weight:600;border:1px solid {{ $status === 'completed' ? 'var(--success-border)' : 'var(--border-color)' }};background:{{ $status === 'completed' ? 'var(--success-bg)' : '#ffffff' }};color:{{ $status === 'completed' ? 'var(--success)' : 'var(--text-secondary)' }};">
                Completed ({{ $statusCounts['completed'] ?? 0 }})
            </a>
            <a href="{{ route('admin.orders.index', ['status' => 'cancelled']) }}"
                style="padding:6px 14px;border-radius:20px;font-size:13px;text-decoration:none;font-weight:600;border:1px solid {{ $status === 'cancelled' ? 'var(--danger-border)' : 'var(--border-color)' }};background:{{ $status === 'cancelled' ? 'var(--danger-bg)' : '#ffffff' }};color:{{ $status === 'cancelled' ? 'var(--danger)' : 'var(--text-secondary)' }};">
                Cancelled ({{ $statusCounts['cancelled'] ?? 0 }})
            </a>
        </div>

        <form method="GET" action="{{ route('admin.orders.index') }}" class="d-flex gap-2">
            @if($status)
                <input type="hidden" name="status" value="{{ $status }}">
            @endif
            <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Search ID, name, email..."
                class="admin_form_control" style="font-size:13px;min-width:220px;">
            <button type="submit" class="admin_btn_primary" style="padding:6px 14px;font-size:13px;">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
            @if(!empty($search))
                <a href="{{ route('admin.orders.index', $status ? ['status' => $status] : []) }}"
                    class="admin_btn_secondary" style="font-size:13px;padding:6px 10px;">Clear</a>
            @endif
        </form>
    </div>

    <!-- Orders Table -->
    <div class="admin_card">
        <div class="admin_card_body p-0">
            <div class="table-responsive">
                <table class="admin_table table mb-0" style="width:100%;border-collapse:collapse;min-width:700px;vertical-align:middle;">
                    <thead>
                        <tr style="border-bottom:1px solid var(--border-color);background:rgba(255,255,255,0.02);">
                            <th
                                style="padding:14px 18px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;white-space:nowrap;">
                                Order</th>
                            <th
                                style="padding:14px 18px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;">
                                Customer</th>
                            <th
                                style="padding:14px 18px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;white-space:nowrap;">
                                Items</th>
                            <th
                                style="padding:14px 18px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;white-space:nowrap;">
                                Total</th>
                            <th
                                style="padding:14px 18px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;white-space:nowrap;">
                                Payment</th>
                            <th
                                style="padding:14px 18px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;white-space:nowrap;">
                                Status</th>
                            <th
                                style="padding:14px 18px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;white-space:nowrap;">
                                Date</th>
                            <th
                                style="padding:14px 18px;font-size:12px;text-transform:uppercase;letter-spacing:.5px;color:var(--text-muted);font-weight:600;text-align:right;white-space:nowrap;">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($orders as $order)
                            <tr>
                                <td style="padding:14px 18px;white-space:nowrap;">
                                    <a href="javascript:void(0)" data-bs-toggle="modal"
                                        data-bs-target="#orderModal{{ $order->id }}"
                                        style="font-weight:700;color:var(--accent-gold);font-size:14px;text-decoration:none;">
                                        #{{ $order->id }}
                                    </a>
                                </td>
                                <td style="padding:14px 18px;">
                                    <div style="font-weight:600;font-size:14px;color:#1a1a1a;">{{ $order->first_name }}
                                        {{ $order->last_name }}</div>
                                    <div style="font-size:12px;color:var(--text-muted);">{{ $order->email }} &bull;
                                        {{ $order->phone }}</div>
                                </td>
                                <td style="padding:14px 18px;white-space:nowrap;">
                                    <span class="badge" style="background:#f3ede2;color:#6b6355;border:1px solid #e0d7c7;font-weight:500;font-size:12px;">
                                        {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                                    </span>
                                </td>
                                <td style="padding:14px 18px;white-space:nowrap;">
                                    <span
                                        style="font-weight:700;color:#1a1a1a;font-size:14px;">${{ number_format($order->total_amount, 2) }}</span>
                                    <div style="font-size:11px;color:var(--text-muted);">Shipping:
                                        ${{ number_format($order->shipping_fee, 2) }}</div>
                                </td>
                                <td style="padding:14px 18px;white-space:nowrap;">
                                    @if($order->payment_method === 'Credit Card')
                                        <span class="badge_status processing">
                                            <i class="fa-regular fa-credit-card"></i> Credit Card
                                        </span>
                                    @elseif($order->payment_method === 'Cash on Delivery')
                                        <span class="badge_status pending">
                                            <i class="fa-solid fa-money-bill-wave"></i> COD
                                        </span>
                                    @else
                                        <span class="badge" style="background:#f3ede2;color:#6b6355;border:1px solid #e0d7c7;padding:4px 10px;border-radius:20px;font-size:12px;font-weight:600;">
                                            <i class="fa-solid fa-building-columns"></i> Bank Transfer
                                        </span>
                                    @endif
                                </td>
                                <td style="padding:14px 18px;white-space:nowrap;">
                                    <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="d-inline">
                                        @csrf
                                        @method('PUT')
                                        <select name="status" onchange="this.form.submit()" class="form-select form-select-sm" style="font-size:12px;font-weight:600;padding:4px 24px 4px 10px;border-radius:20px;cursor:pointer;width:auto;display:inline-block;">
                                            <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending</option>
                                            <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>Processing</option>
                                            <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                            <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                                        </select>
                                    </form>
                                </td>
                                <td style="padding:14px 18px;font-size:13px;color:var(--text-muted);white-space:nowrap;">
                                    {{ $order->created_at->format('M d, Y') }}
                                    <div style="font-size:11px;color:var(--text-muted);">
                                        {{ $order->created_at->format('h:i A') }}</div>
                                </td>
                                <td style="padding:14px 18px;text-align:right;white-space:nowrap;">
                                    <div style="display:flex;gap:8px;justify-content:flex-end;">
                                        <a href="{{ route('admin.orders.show', $order) }}" class="btn_admin_edit" style="font-size:12px;padding:6px 12px;">
                                            <i class="fa-solid fa-up-right-from-square"></i> Details
                                        </a>
                                        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}"
                                            onsubmit="return confirm('Are you sure you want to delete order #{{ $order->id }}?')">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn_admin_delete" style="padding:6px 10px;font-size:12px;">
                                                <i class="fa-solid fa-trash"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" style="padding:40px 20px;text-align:center;color:var(--text-muted);">
                                    <i class="fa-solid fa-cart-arrow-down fa-2x mb-3 d-block" style="opacity:0.4;"></i>
                                    No orders found matching your criteria.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($orders->hasPages())
                <div style="padding:16px 20px;border-top:1px solid var(--border-color);">
                    {{ $orders->links() }}
                </div>
            @endif
        </div>
    </div>

    <!-- ============================================== -->
    <!-- ORDER DETAIL MODALS (RENDERED OUTSIDE TABLE) -->
    <!-- ============================================== -->
    @foreach($orders as $order)
        <div class="modal fade" id="orderModal{{ $order->id }}" tabindex="-1" aria-labelledby="orderModalLabel{{ $order->id }}"
            aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
                <div class="modal-content"
                    style="background:#16181f;border:1px solid var(--border-color);color:#fff;border-radius:12px;">
                    <div class="modal-header" style="border-bottom:1px solid var(--border-color);padding:18px 24px;">
                        <div>
                            <h5 class="modal-title mb-0" id="orderModalLabel{{ $order->id }}" style="font-weight:700;">
                                Order Details <span style="color:var(--accent);">#{{ $order->id }}</span>
                            </h5>
                            <small style="color:var(--text-muted);">Placed on
                                {{ $order->created_at->format('F d, Y \a\t h:i A') }}</small>
                        </div>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body" style="padding:24px;">
                        <!-- Order Status & Quick Update -->
                        <div class="p-3 mb-4 rounded"
                            style="background:rgba(255,255,255,0.03);border:1px solid var(--border-color);">
                            <div class="d-flex justify-content-between align-items-center flex-wrap gap-2">
                                <div>
                                    <span class="text-secondary"
                                        style="font-size:12px;text-transform:uppercase;letter-spacing:0.5px;">Current
                                        Status</span>
                                    <div class="mt-1">
                                        @if($order->status === 'completed')
                                            <span class="badge bg-success px-3 py-2" style="font-size:13px;"><i
                                                    class="fa-solid fa-circle-check me-1"></i> Completed</span>
                                        @elseif($order->status === 'processing')
                                            <span class="badge bg-primary px-3 py-2" style="font-size:13px;"><i
                                                    class="fa-solid fa-arrows-rotate me-1"></i> Processing</span>
                                        @elseif($order->status === 'cancelled')
                                            <span class="badge bg-danger px-3 py-2" style="font-size:13px;"><i
                                                    class="fa-solid fa-ban me-1"></i> Cancelled</span>
                                        @else
                                            <span class="badge bg-warning text-dark px-3 py-2" style="font-size:13px;"><i
                                                    class="fa-solid fa-clock me-1"></i> Pending</span>
                                        @endif
                                    </div>
                                </div>
                                <form method="POST" action="{{ route('admin.orders.update', $order) }}"
                                    class="d-flex align-items-center gap-2">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm"
                                        style="background:#1e2029;color:#fff;border-color:var(--border-color);width:150px;">
                                        <option value="pending" {{ $order->status === 'pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="processing" {{ $order->status === 'processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="completed" {{ $order->status === 'completed' ? 'selected' : '' }}>Completed
                                        </option>
                                        <option value="cancelled" {{ $order->status === 'cancelled' ? 'selected' : '' }}>Cancelled
                                        </option>
                                    </select>
                                    <button type="submit" class="admin_btn_primary"
                                        style="padding:6px 14px;font-size:12px;">Update</button>
                                </form>
                            </div>
                        </div>

                        <!-- Customer & Shipping Grid -->
                        <div class="row g-3 mb-4">
                            <div class="col-md-6">
                                <div class="p-3 h-100 rounded"
                                    style="background:rgba(255,255,255,0.02);border:1px solid var(--border-color);">
                                    <h6
                                        style="font-weight:700;color:var(--accent);font-size:13px;text-transform:uppercase;margin-bottom:12px;">
                                        <i class="fa-solid fa-user me-1"></i> Customer Information
                                    </h6>
                                    <div style="font-size:13px;line-height:1.8;">
                                        <div><strong>Name:</strong> {{ $order->first_name }} {{ $order->last_name }}</div>
                                        <div><strong>Email:</strong> <a href="mailto:{{ $order->email }}"
                                                style="color:#60a5fa;text-decoration:none;">{{ $order->email }}</a></div>
                                        <div><strong>Phone:</strong> <a href="tel:{{ $order->phone }}"
                                                style="color:#cbd5e1;text-decoration:none;">{{ $order->phone }}</a></div>
                                        @if($order->company_name)
                                            <div><strong>Company:</strong> {{ $order->company_name }}</div>
                                        @endif
                                        @if($order->user)
                                            <div><strong>Account ID:</strong> User #{{ $order->user_id }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="p-3 h-100 rounded"
                                    style="background:rgba(255,255,255,0.02);border:1px solid var(--border-color);">
                                    <h6
                                        style="font-weight:700;color:var(--accent);font-size:13px;text-transform:uppercase;margin-bottom:12px;">
                                        <i class="fa-solid fa-location-dot me-1"></i> Shipping & Payment
                                    </h6>
                                    <div style="font-size:13px;line-height:1.8;">
                                        <div><strong>Address:</strong> {{ $order->address }}</div>
                                        <div><strong>City / Country:</strong> {{ $order->city }}, {{ $order->country }}</div>
                                        <div><strong>Payment Method:</strong>
                                            <span class="badge bg-secondary">{{ $order->payment_method }}</span>
                                        </div>
                                        @if($order->order_notes)
                                            <div class="mt-2 p-2 rounded"
                                                style="background:rgba(0,0,0,0.3);font-size:12px;color:#cbd5e1;">
                                                <strong>Notes:</strong> {{ $order->order_notes }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Ordered Items Table -->
                        <h6 style="font-weight:700;font-size:14px;margin-bottom:12px;color:#fff;">
                            <i class="fa-solid fa-boxes-stacked me-1" style="color:var(--accent);"></i> Order Items
                            ({{ $order->items->count() }})
                        </h6>
                        <div class="table-responsive rounded mb-4" style="border:1px solid var(--border-color);">
                            <table class="table table-dark table-hover mb-0" style="font-size:13px;">
                                <thead>
                                    <tr
                                        style="background:#1a1c23;color:var(--text-muted);font-size:11px;text-transform:uppercase;">
                                        <th style="padding:10px 14px;">Product</th>
                                        <th style="padding:10px 14px;text-align:center;">Price</th>
                                        <th style="padding:10px 14px;text-align:center;">Quantity</th>
                                        <th style="padding:10px 14px;text-align:right;">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($order->items as $item)
                                        <tr>
                                            <td style="padding:10px 14px;">
                                                <div class="d-flex align-items-center gap-3">
                                                    <div
                                                        style="width:42px;height:42px;border-radius:6px;overflow:hidden;border:1px solid var(--border-color);background:#121318;flex-shrink:0;">
                                                        <img src="{{ $item->product->image_url ?? asset('images/cards.png') }}"
                                                            alt="{{ $item->product_name }}"
                                                            style="width:100%;height:100%;object-fit:cover;">
                                                    </div>
                                                    <div>
                                                        <div style="font-weight:600;color:#fff;">{{ $item->product_name }}</div>
                                                        @if($item->product)
                                                            <small class="text-secondary">SKU: PRD-{{ $item->product_id }} &bull;
                                                                {{ $item->product->category->name ?? '' }}</small>
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td
                                                style="padding:10px 14px;text-align:center;vertical-align:middle;color:var(--accent);font-weight:600;">
                                                ${{ number_format($item->price, 2) }}
                                            </td>
                                            <td style="padding:10px 14px;text-align:center;vertical-align:middle;">
                                                <span class="badge bg-secondary">x{{ $item->quantity }}</span>
                                            </td>
                                            <td
                                                style="padding:10px 14px;text-align:right;vertical-align:middle;font-weight:700;color:#fff;">
                                                ${{ number_format($item->subtotal, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <!-- Financial Totals -->
                        <div class="row justify-content-end">
                            <div class="col-md-5">
                                <div class="p-3 rounded"
                                    style="background:rgba(255,255,255,0.03);border:1px solid var(--border-color);font-size:13px;">
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Items Subtotal:</span>
                                        <strong>${{ number_format($order->subtotal, 2) }}</strong>
                                    </div>
                                    <div class="d-flex justify-content-between mb-2">
                                        <span class="text-secondary">Shipping Fee:</span>
                                        <strong>{{ $order->shipping_fee > 0 ? '$' . number_format($order->shipping_fee, 2) : 'Free' }}</strong>
                                    </div>
                                    <hr style="border-color:var(--border-color);margin:10px 0;">
                                    <div class="d-flex justify-content-between" style="font-size:15px;">
                                        <strong style="color:var(--accent);">Grand Total:</strong>
                                        <strong
                                            style="color:var(--accent);font-size:17px;">${{ number_format($order->total_amount, 2) }}</strong>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer" style="border-top:1px solid var(--border-color);padding:14px 24px;">
                        <a href="{{ route('admin.orders.show', $order) }}" class="admin_btn_primary text-decoration-none"
                            style="padding:8px 18px;font-size:13px;">
                            <i class="fa-solid fa-print me-1"></i> Full Page / Invoice
                        </a>
                        <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach

@endsection