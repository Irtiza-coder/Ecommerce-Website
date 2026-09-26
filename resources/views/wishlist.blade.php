@extends('Layout.main')
@section("content")  

    <!-- Banner Image Section -->
    <section class="page_banner">
      <div class="container-fluid px-0">
        <div class="row g-0">
          <div class="col-12">
            <img
              src="{{ asset('images/coll_cta_banner.png') }}"
              alt="Collections Banner"
              class="img-fluid w-100 banner_img"
            />
          </div>
        </div>
      </div>
    </section>

    <!-- Wishlist Title Section -->
    <section class="collections_heading_section">
      <div class="container">
        <div class="row justify-content-center">
          <div class="col-12 text-center">
            <h1 class="collections_heading">MY WISHLIST</h1>
          </div>
        </div>
      </div>
    </section>

    <section class="cart_section section_pad mt-5">
      <div class="container">
        @if(session('message'))
          <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background:#ecfdf5; border-color:#a7f3d0; color:#065f46; border-radius:10px;">
            <i class="fa-solid fa-circle-check me-2"></i>{{ session('message') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
          </div>
        @endif

        <div class="row justify-content-center">
          <div class="col-lg-10">
            <div class="table-responsive">
              <table class="cart_table">
                <thead>
                  <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Stock Status</th>
                    <th class="text-center" style="width: 170px;">Add to Cart</th>
                    <th class="text-center" style="width: 70px;">Remove</th>
                  </tr>
                </thead>

                <tbody>
                  @forelse($products as $product)
                    <tr>
                      <td>
                        <div class="cart_product">
                          <img src="{{ $product->image_url }}" alt="{{ $product->name }}" style="width:65px; height:65px; object-fit:cover; border-radius:8px;" />
                          <div class="product_info">
                            <h5>
                              <a href="{{ route('detail', $product->slug) }}" class="text-decoration-none text-dark">
                                {{ $product->name }}
                              </a>
                            </h5>
                            <small class="text-muted">{{ $product->brand ?? 'Crest & Clove' }}</small>
                          </div>
                        </div>
                      </td>
                      <td>
                        <strong style="color:#b8935a; font-size:16px;">${{ number_format($product->price, 2) }}</strong>
                        @if($product->old_price)
                          <small class="text-muted text-decoration-line-through ms-1">${{ number_format($product->old_price, 2) }}</small>
                        @endif
                      </td>
                      <td>
                        @if($product->stock_status === 'In Stock')
                          <span class="badge bg-success bg-opacity-10 text-success rounded-pill px-3 py-1">In Stock</span>
                        @else
                          <span class="badge bg-danger bg-opacity-10 text-danger rounded-pill px-3 py-1">Out of Stock</span>
                        @endif
                      </td>
                      <td class="text-center">
                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                          @csrf
                          <input type="hidden" name="quantity" value="1">
                          <button type="submit" class="btn btn-sm" style="background:#b8935a; color:#fff; font-weight:600; font-size:12px; padding:8px 16px; border-radius:6px; border:none; transition:0.2s;" onmouseover="this.style.background='#9d7b42';" onmouseout="this.style.background='#b8935a';">
                            <i class="fa-solid fa-cart-shopping me-1"></i> Add To Cart
                          </button>
                        </form>
                      </td>
                      <td class="text-center">
                        <form action="{{ route('wishlist.remove', $product->id) }}" method="POST" style="display:inline-block; margin:0;" onsubmit="return confirm('Remove this item from your wishlist?')">
                          @csrf
                          <button type="submit"
                            style="width: 36px; height: 36px; border-radius: 8px; border: 1px solid rgba(239, 68, 68, 0.35); background: rgba(239, 68, 68, 0.1); color: #ef4444; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; font-size: 14px; transition: all 0.2s;"
                            onmouseover="this.style.background='#ef4444'; this.style.color='#ffffff';"
                            onmouseout="this.style.background='rgba(239, 68, 68, 0.1)'; this.style.color='#ef4444';"
                            title="Remove from wishlist">
                            <i class="fa-solid fa-trash-can"></i>
                          </button>
                        </form>
                      </td>
                    </tr>
                  @empty
                    <tr>
                      <td colspan="5" class="text-center py-5">
                        <i class="fa-regular fa-heart mb-3" style="font-size: 40px; color:#cbd5e1;"></i>
                        <p class="mb-3 text-muted">Your wishlist is currently empty.</p>
                        <a href="{{ route('shop') }}" class="continue_btn d-inline-block">
                          Explore Shop <i class="fa-solid fa-chevron-right ms-1"></i>
                        </a>
                      </td>
                    </tr>
                  @endforelse
                </tbody>
              </table>
            </div>

            <div class="row align-items-center mt-5">
              <div class="col-6 text-start">
                <a href="{{ route('shop') }}" class="continue_btn">
                  Continue Shopping <i class="fa-solid fa-chevron-right ms-1"></i>
                </a>
              </div>
              <div class="col-6 text-end">
                <a href="{{ route('cart.index') }}" class="checkout_btn" style="text-decoration:none;">
                  View Cart <i class="fa-solid fa-cart-shopping ms-1"></i>
                </a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
@endsection
