@extends('Layout.dashboard')
@section('title', 'Dashboard')

@section('dash_content')

  @if(session('message'))
    <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background:#ecfdf5; border-color:#a7f3d0; color:#065f46; border-radius:10px; padding:16px 20px;">
      <i class="fa-solid fa-circle-check me-2" style="font-size:16px;"></i>
      <strong>Success!</strong> {{ session('message') }}
      <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
  @endif

  <div class="dash_topbar">
    <div>
      <h2>Welcome back, {{ $user->First_name }}! 👋</h2>
      <p class="text-muted mb-0" style="font-size:14px;">Here is what's happening with your account and recent orders.</p>
    </div>
    <a href="{{ route('logout') }}" class="btn-logout">
      <i class="fa-solid fa-power-off"></i> Log Out
    </a>
  </div>

  <!-- Stat cards -->
  <div class="stat_cards">
    <div class="stat_card">
      <h5>Total Orders</h5>
      <div class="stat_value">{{ $totalOrders }}</div>
    </div>
    <div class="stat_card">
      <h5>Total Spent</h5>
      <div class="stat_value">${{ number_format($totalSpent, 2) }}</div>
    </div>
    <div class="stat_card">
      <h5>Items in Cart</h5>
      <div class="stat_value">{{ count(session('cart', [])) }}</div>
    </div>
    <div class="stat_card">
      <h5>Account Status</h5>
      <div class="stat_value" style="font-size:18px; color:#16a34a; display:flex; align-items:center; gap:6px;">
        <i class="fa-solid fa-circle-check" style="font-size:14px;"></i> Active
      </div>
    </div>
  </div>

  <!-- Recent Orders -->
  <div class="dash_card mb-4" id="ordersSection">
    <div class="dash_card_header">
      <span><i class="fa-solid fa-box-open me-2" style="color:#b8935a;"></i> Recent Orders</span>
      <span class="badge bg-light text-dark">{{ $totalOrders }} Orders</span>
    </div>
    <div class="dash_card_body">
      <div class="table-responsive">
        <table class="dash_table">
          <thead>
            <tr>
              <th>Order #</th>
              <th>Date</th>
              <th>Items</th>
              <th>Payment</th>
              <th>Status</th>
              <th>Total</th>
              <th style="text-align:right;">Details</th>
            </tr>
          </thead>
          <tbody>
            @forelse($orders as $order)
              <tr>
                <td>
                  <strong style="color:#b8935a;">#{{ $order->id }}</strong>
                </td>
                <td>{{ $order->created_at->format('M d, Y') }}</td>
                <td>
                  <span style="font-size:13px; color:#64748b;">
                    {{ $order->items->count() }} {{ Str::plural('item', $order->items->count()) }}
                  </span>
                </td>
                <td>{{ $order->payment_method }}</td>
                <td>
                  @php
                    $statusClass = match(strtolower($order->status)) {
                        'completed' => 'status_completed',
                        'processing' => 'status_processing',
                        'cancelled' => 'status_cancelled',
                        default => 'status_pending'
                    };
                  @endphp
                  <span class="status_badge {{ $statusClass }}">
                    {{ $order->status }}
                  </span>
                </td>
                <td>
                  <strong style="color:#b8935a; font-size:15px;">
                    ${{ number_format($order->total_amount, 2) }}
                  </strong>
                </td>
                <td style="text-align:right;">
                  <button type="button" class="btn btn-sm btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#userOrderModal{{ $order->id }}" style="font-size:12px; border-radius:6px; padding:4px 10px;">
                    <i class="fa-solid fa-receipt me-1"></i> View Receipt
                  </button>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="text-center py-5">
                  <p class="text-muted mb-2">You haven't placed any orders yet.</p>
                  <a href="{{ route('shop') }}" class="btn btn-sm btn-outline-warning" style="color:#b8935a; border-color:#b8935a;">
                    Browse Products <i class="fa-solid fa-arrow-right ms-1"></i>
                  </a>
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <!-- Account Details Overview -->
  <div class="dash_card" id="accountDetailsSection">
    <div class="dash_card_header">
      <span><i class="fa-solid fa-user-shield me-2" style="color:#b8935a;"></i> Profile Overview</span>
      <a href="{{ route('user.profile') }}" class="btn btn-sm" style="background:#b8935a; color:#fff; font-weight:600; border-radius:6px; font-size:13px;">
        <i class="fa-solid fa-user-pen me-1"></i> Edit Profile & Password
      </a>
    </div>
    <div class="dash_card_body">
      <table class="dash_table">
        <tbody>
          <tr>
            <th style="width:220px;">Full Name</th>
            <td>{{ $user->First_name }} {{ $user->Last_name }}</td>
          </tr>
          <tr>
            <th>Email Address</th>
            <td>{{ $user->email }}</td>
          </tr>
          <tr>
            <th>Member Since</th>
            <td>{{ $user->created_at ? $user->created_at->format('F d, Y') : 'N/A' }}</td>
          </tr>
        </tbody>
      </table>
    </div>
  </div>

  <!-- Customer Order Modals -->
  @foreach($orders as $order)
  <div class="modal fade" id="userOrderModal{{ $order->id }}" tabindex="-1" aria-labelledby="userOrderModalLabel{{ $order->id }}" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
      <div class="modal-content" style="border-radius:12px; border:none; box-shadow:0 10px 30px rgba(0,0,0,0.15);">
        <div class="modal-header" style="background:#191c24; color:#fff; border-bottom:none; padding:18px 24px;">
          <div>
            <h5 class="modal-title mb-0" id="userOrderModalLabel{{ $order->id }}" style="font-weight:700;">
              Order Receipt <span style="color:#b8935a;">#{{ $order->id }}</span>
            </h5>
            <small style="color:#94a3b8;">Placed on {{ $order->created_at->format('M d, Y \a\t h:i A') }}</small>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body" style="padding:24px;">
          <!-- Status Banner -->
          <div class="d-flex justify-content-between align-items-center p-3 mb-4 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
            <div>
              <span class="text-muted" style="font-size:12px; text-transform:uppercase;">Payment & Status</span>
              <div class="mt-1">
                <span class="badge bg-dark me-2">{{ $order->payment_method }}</span>
                @php
                  $statusClass = match(strtolower($order->status)) {
                      'completed' => 'status_completed',
                      'processing' => 'status_processing',
                      'cancelled' => 'status_cancelled',
                      default => 'status_pending'
                  };
                @endphp
                <span class="status_badge {{ $statusClass }}">{{ $order->status }}</span>
              </div>
            </div>
            <div class="text-end">
              <span class="text-muted" style="font-size:12px; text-transform:uppercase;">Total Amount</span>
              <div style="font-weight:700; font-size:18px; color:#b8935a;">${{ number_format($order->total_amount, 2) }}</div>
            </div>
          </div>

          <!-- Shipping Details -->
          <div class="p-3 mb-4 rounded" style="background:#f8fafc; border:1px solid #e2e8f0; font-size:13px; line-height:1.7;">
            <strong style="color:#1e293b; display:block; margin-bottom:6px;"><i class="fa-solid fa-truck me-1" style="color:#b8935a;"></i> Shipping Address</strong>
            <div><strong>Recipient:</strong> {{ $order->first_name }} {{ $order->last_name }} ({{ $order->phone }})</div>
            <div><strong>Address:</strong> {{ $order->address }}, {{ $order->city }}, {{ $order->country }}</div>
            @if($order->order_notes)
              <div class="mt-2 text-muted"><strong>Order Notes:</strong> {{ $order->order_notes }}</div>
            @endif
          </div>

          <!-- Items Table -->
          <h6 style="font-weight:700; color:#1e293b; margin-bottom:12px;"><i class="fa-solid fa-boxes-stacked me-1" style="color:#b8935a;"></i> Ordered Items ({{ $order->items->count() }})</h6>
          <div class="table-responsive rounded mb-4" style="border:1px solid #e2e8f0;">
            <table class="table mb-0" style="font-size:13px;">
              <thead style="background:#f1f5f9;">
                <tr>
                  <th style="padding:10px 14px;">Product</th>
                  <th style="padding:10px 14px; text-align:center;">Price</th>
                  <th style="padding:10px 14px; text-align:center;">Qty</th>
                  <th style="padding:10px 14px; text-align:right;">Subtotal</th>
                </tr>
              </thead>
              <tbody>
                @foreach($order->items as $item)
                  <tr>
                    <td style="padding:10px 14px;">
                      <div class="d-flex align-items-center gap-3">
                        <div style="width:40px; height:40px; border-radius:6px; overflow:hidden; border:1px solid #e2e8f0; flex-shrink:0;">
                          <img src="{{ $item->product->image_url ?? asset('images/cards.png') }}" alt="{{ $item->product_name }}" style="width:100%; height:100%; object-fit:cover;">
                        </div>
                        <div>
                          <strong>{{ $item->product_name }}</strong>
                          @if($item->product && $item->product->slug)
                            <div><a href="{{ route('detail', $item->product->slug) }}" target="_blank" style="font-size:11px; color:#b8935a; text-decoration:none;">View Product <i class="fa-solid fa-arrow-up-right-from-square"></i></a></div>
                          @endif
                        </div>
                      </div>
                    </td>
                    <td style="padding:10px 14px; text-align:center; vertical-align:middle;">${{ number_format($item->price, 2) }}</td>
                    <td style="padding:10px 14px; text-align:center; vertical-align:middle;"><span class="badge bg-light text-dark border">x{{ $item->quantity }}</span></td>
                    <td style="padding:10px 14px; text-align:right; vertical-align:middle; font-weight:700;">${{ number_format($item->subtotal, 2) }}</td>
                  </tr>
                @endforeach
              </tbody>
            </table>
          </div>

          <!-- Totals -->
          <div class="row justify-content-end">
            <div class="col-md-5">
              <div class="p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0; font-size:13px;">
                <div class="d-flex justify-content-between mb-1">
                  <span class="text-muted">Subtotal:</span>
                  <strong>${{ number_format($order->subtotal, 2) }}</strong>
                </div>
                <div class="d-flex justify-content-between mb-1">
                  <span class="text-muted">Shipping:</span>
                  <strong>{{ $order->shipping_fee > 0 ? '$' . number_format($order->shipping_fee, 2) : 'Free Shipping' }}</strong>
                </div>
                <hr style="margin:8px 0;">
                <div class="d-flex justify-content-between" style="font-size:15px;">
                  <strong style="color:#b8935a;">Grand Total:</strong>
                  <strong style="color:#b8935a;">${{ number_format($order->total_amount, 2) }}</strong>
                </div>
              </div>
            </div>
          </div>
        </div>
        <div class="modal-footer" style="border-top:1px solid #e2e8f0; padding:12px 24px;">
          <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="fa-solid fa-print me-1"></i>Print Receipt</button>
          <button type="button" class="btn btn-secondary btn-sm" data-bs-dismiss="modal">Close</button>
        </div>
      </div>
    </div>
  </div>
  @endforeach

@endsection