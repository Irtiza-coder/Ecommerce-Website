@extends('Layout.main')
@section("content")

  <!-- Banner Image Section -->
  <section class="page_banner">
    <div class="container-fluid px-0">
      <div class="row g-0">
        <div class="col-12">
          <img src="{{ asset('images/coll_cta_banner.png') }}" alt="Collections Banner"
            class="img-fluid w-100 banner_img" />
        </div>
      </div>
    </div>
  </section>

  <!-- Collections Title Section -->
  <section class="collections_heading_section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 text-center">
          <h1 class="collections_heading">CART</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="cart_section section_pad mt-5">
    <div class="container">
      @if(session('message'))
        <div class="alert alert-success alert-dismissible fade show mb-4" role="alert"
          style="background:#e6f4ea; border-color:#b7e1cd; color:#137333;">
          <i class="fa-solid fa-circle-check me-2"></i>{{ session('message') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      @if(session('error'))
        <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert">
          <i class="fa-solid fa-circle-exclamation me-2"></i>{{ session('error') }}
          <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
      @endif

      <div class="row gx-5 pt-4">
        <div class="col-lg-8">
          <div class="table-responsive">
            <table class="cart_table">
              <thead>
                <tr>
                  <th>Item</th>
                  <th>Quantity</th>
                  <th>Unit Price</th>
                  <th>Sub Price</th>
                  <th>Action</th>
                </tr>
              </thead>

              <tbody>
                @forelse($cart as $id => $item)
                  <tr>
                    <td>
                      <div class="cart_product">
                        <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" />
                        <div class="product_info">
                          <h5>{{ $item['name'] }}</h5>
                        </div>
                      </div>
                    </td>
                    <td>
                      <div class="qty_selector">
                        <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline;">
                          @csrf
                          <input type="hidden" name="change" value="-1">
                          <button type="submit" class="qty_btn minus">
                            <i class="fa-solid fa-minus"></i>
                          </button>
                        </form>
                        <input type="text" value="{{ $item['quantity'] }}" readonly />
                        <form action="{{ route('cart.update', $id) }}" method="POST" style="display:inline;">
                          @csrf
                          <input type="hidden" name="change" value="1">
                          <button type="submit" class="qty_btn plus">
                            <i class="fa-solid fa-plus"></i>
                          </button>
                        </form>
                      </div>
                    </td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                    <td>
                      <form action="{{ route('cart.remove', $id) }}" method="POST" style="display:inline-block; margin:0;" onsubmit="return confirm('Remove this item from cart?')">
                        @csrf
                        <button type="submit"
                          style="width:36px; height:36px; border-radius:8px; border:1px solid rgba(239,68,68,0.3); background:rgba(239,68,68,0.1); color:#ef4444; display:inline-flex; align-items:center; justify-content:center; cursor:pointer; font-size:14px; transition:all 0.2s;"
                          onmouseover="this.style.background='#ef4444'; this.style.color='#ffffff';"
                          onmouseout="this.style.background='rgba(239,68,68,0.1)'; this.style.color='#ef4444';"
                          title="Remove Item">
                          <i class="fa-solid fa-trash-can"></i>
                        </button>
                      </form>
                    </td>
                  </tr>
                @empty
                  <tr>
                    <td colspan="5" class="text-center py-5">
                      <p class="mb-3 text-muted">Your cart is currently empty.</p>
                      <a href="{{ route('shop') }}" class="continue_btn d-inline-block">Continue Shopping <i
                          class="fa-solid fa-chevron-right"></i></a>
                    </td>
                  </tr>
                @endforelse
              </tbody>
            </table>
          </div>

          @if(count($cart) > 0)
            <div class="d-flex justify-content-between align-items-center mt-3">
              <form action="{{ route('cart.clear') }}" method="POST" onsubmit="return confirm('Clear entire cart?')">
                @csrf
                <button type="submit" class="btn btn-sm btn-outline-danger" style="border-radius:6px; font-size:12px;">
                  <i class="fa-solid fa-trash me-1"></i> Clear Cart
                </button>
              </form>
            </div>
          @endif

          <div class="row align-items-center mt-5 d-none d-lg-flex">
            <div class="col-md-6 text-start">
              <a href="{{ route('shop') }}" class="continue_btn">Continue Purchasing <i
                  class="fa-solid fa-chevron-right"></i></a>
            </div>

            <div class="col-md-6 text-end">
              @if(count($cart) > 0)
                <a href="{{ route('checkout') }}" class="checkout_btn">Proceed To Checkout</a>
              @endif
            </div>
          </div>
        </div>

        <div class="col-lg-4">
          <div class="cart_summary">
            <div class="summary_row">
              <span>Sub Total</span>
              <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="summary_row">
              <span>Shipping</span>
              <span>{{ $shipping > 0 ? '$' . number_format($shipping, 2) : 'Free' }}</span>
            </div>
            <div class="summary_row total_row">
              <strong>Total</strong>
              <strong>${{ number_format($total, 2) }}</strong>
            </div>
          </div>

          <div class="shipping_box mt-4">
            <div class="shipping_block">
              <h3>Shipping Info</h3>
              <p>{{ $subtotal > 200 ? 'Free Shipping (Orders over $200)' : 'Standard Courier ($15)' }}</p>
            </div>
          </div>

          <div class="col-12 mt-4 d-block d-lg-none">
            <div class="row align-items-center justify-content-between g-3">
              <div class="col-12 text-center">
                @if(count($cart) > 0)
                  <a href="{{ url('/checkout') }}" class="checkout_btn w-100 d-block text-center">Proceed To Checkout</a>
                @endif
              </div>
              <div class="col-12 text-center mt-3">
                <a href="{{ route('shop') }}" class="continue_btn">Continue Purchasing <i
                    class="fa-solid fa-chevron-right"></i></a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>
@endsection