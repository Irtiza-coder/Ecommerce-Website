@extends('Layout.main')
@section("content")

  @php
    $banner = $cms['shop_banner'] ?? null;
  @endphp

  <!-- Banner Image Section -->
  <section class="page_banner">
    <div class="container-fluid px-0">
      <div class="row g-0">
        <div class="col-12">
          <img
            src="{{ ($banner && $banner->image) ? asset('storage/' . $banner->image) : asset('images/coll_cta_banner.png') }}"
            alt="{{ ($banner && $banner->title) ? $banner->title : 'Shop Banner' }}" class="img-fluid w-100 banner_img" />
        </div>
      </div>
    </div>
  </section>

  <section class="collections_heading_section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 text-center">
          <h1 class="collections_heading">{{ ($banner && $banner->title) ? $banner->title : 'shop' }}</h1>
          @if($banner && $banner->subtitle)
            <p class="section_subtitle mt-2 mb-0" style="max-width: 600px; margin: 0 auto; color: #888;">
              {{ $banner->subtitle }}
            </p>
          @endif
        </div>
      </div>
    </div>
  </section>

  <section class="shop_section section_pad mt-5">
    <div class="container">

      <!-- Mobile filter dropdowns -->
      <form method="GET" action="{{ url('/shop') }}"
        class="shop_filter_dropdown_wrap mb-4 d-flex d-lg-none align-items-center justify-content-center gap-2 flex-nowrap w-100">
        <select name="category" onchange="this.form.submit()" class="form-select shop_filter_select"
          style="flex: 1; min-width: 0; max-width: 200px; border-color: #b8935a; font-family: Montserrat, sans-serif; font-size: 12px; padding: 8px 24px 8px 10px;">
          <option value="">Select Category</option>
          @foreach($categories as $cat)
            <option value="{{ $cat->id }}" {{ in_array($cat->id, (array) request('category', [])) ? 'selected' : '' }}>
              {{ $cat->name }}
            </option>
          @endforeach
        </select>
        <select name="price" onchange="this.form.submit()" class="form-select shop_filter_select"
          style="flex: 1; min-width: 0; max-width: 200px; border-color: #b8935a; font-family: Montserrat, sans-serif; font-size: 12px; padding: 8px 24px 8px 10px;">
          <option value="">Filter By Price</option>
          <option value="0-50" {{ in_array('0-50', (array) request('price', [])) ? 'selected' : '' }}>$0 – $50</option>
          <option value="50-100" {{ in_array('50-100', (array) request('price', [])) ? 'selected' : '' }}>$50 – $100
          </option>
          <option value="100-200" {{ in_array('100-200', (array) request('price', [])) ? 'selected' : '' }}>$100 – $200
          </option>
          <option value="200+" {{ in_array('200+', (array) request('price', [])) ? 'selected' : '' }}>$200+</option>
        </select>
      </form>

      <div class="row">
        <div class="col-lg-3 d-none d-lg-block">
          <aside class="shop_sidebar">
            <form method="GET" action="{{ url('/shop') }}" id="desktopFilterForm">
              <div class="filter_block">
                <h4>Categories</h4>
                @foreach($categories as $cat)
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="category[]" id="p{{ $cat->id }}"
                      value="{{ $cat->id }}" onchange="this.form.submit()" {{ in_array($cat->id, (array) request('category', [])) ? 'checked' : '' }} />
                    <label class="form-check-label" for="p{{ $cat->id }}">{{ $cat->name }}</label>
                  </div>
                @endforeach
              </div>
              <div class="filter_block">
                <h4>Price</h4>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="price[]" id="pr1" value="0-50"
                    onchange="this.form.submit()" {{ in_array('0-50', (array) request('price', [])) ? 'checked' : '' }} />
                  <label class="form-check-label" for="pr1">$0 &ndash; $50</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="price[]" id="pr2" value="50-100"
                    onchange="this.form.submit()" {{ in_array('50-100', (array) request('price', [])) ? 'checked' : '' }} />
                  <label class="form-check-label" for="pr2">$50 &ndash; $100</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="price[]" id="pr3" value="100-200"
                    onchange="this.form.submit()" {{ in_array('100-200', (array) request('price', [])) ? 'checked' : '' }} />
                  <label class="form-check-label" for="pr3">$100 &ndash; $200</label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="price[]" id="pr4" value="200+"
                    onchange="this.form.submit()" {{ in_array('200+', (array) request('price', [])) ? 'checked' : '' }} />
                  <label class="form-check-label" for="pr4">$200+</label>
                </div>
              </div>
            </form>
            @if(request('category') || request('price'))
              <a href="{{ url('/shop') }}" class="d-inline-block mt-2"
                style="font-size:13px; text-decoration:underline;">Clear Filters</a>
            @endif
          </aside>
        </div>

        <div class="col-12 col-lg-9">

          <div class="row g-4 product_grid">
            @forelse($products as $product)
              <div class="col-lg-4 col-md-6 col-12">
                <div class="product_card" style="cursor: pointer;" data-url="{{ route('detail', $product->slug) }}"
                  onclick="if(!event.target.closest('.add_cart')) window.location.href=this.dataset.url">
                  <div class="product_img">
                    <a href="{{ route('detail', $product->slug) }}">
                      <img src="{{ $product->image_url }}" alt="{{ $product->name }}" />
                    </a>
                  </div>
                  <div class="product_content">
                    <h3 class="product_name">
                      <a href="{{ route('detail', $product->slug) }}"
                        class="text-decoration-none text-reset">{{ $product->name }}</a>
                    </h3>
                    <p class="product_desc">{{ $product->short_description }}</p>
                    <div class="product_bottom">
                      <span class="product_price">${{ number_format($product->price, 2) }}</span>
                      <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="add_cart " style="border:none ; background-color : white">
                          Add to Cart
                        </button>
                      </form>
                    </div>
                  </div>
                </div>
              </div>
            @empty
              <div class="col-12 text-center py-5">
                <p class="text-secondary">No products match your filters.</p>
              </div>
            @endforelse
          </div>

          <div class="d-flex justify-content-center">
            {{ $products->onEachSide(1)->links('partials.pagination') }}
          </div>

        </div>
      </div>
    </div>
  </section>

  <style>
    .shop_pagination_nav {
      display: flex;
      align-items: center;
      justify-content: center;
      gap: 16px;
      margin-top: 48px;
      margin-bottom: 24px;
    }

    .shop_page_arrow {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      font-size: 20px;
      color: #6b7280;
      text-decoration: none;
      transition: color 0.2s ease;
      cursor: pointer;
      user-select: none;
      line-height: 1;
    }

    .shop_page_arrow:hover:not(.disabled) {
      color: #b08b57;
    }

    .shop_page_arrow.disabled {
      color: #d1d5db;
      cursor: default;
      pointer-events: none;
    }

    .shop_page_btn {
      display: inline-flex;
      align-items: center;
      justify-content: center;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      font-family: inherit;
      font-size: 14px;
      font-weight: 500;
      color: #4b5563;
      text-decoration: none;
      transition: all 0.2s ease;
      user-select: none;
    }

    .shop_page_btn:hover:not(.active) {
      color: #b08b57;
    }

    .shop_page_btn.active {
      background-color: #b08b57;
      color: #ffffff;
      font-weight: 600;
    }

    .shop_page_dots {
      color: #9ca3af;
      font-size: 14px;
      padding: 0 4px;
    }

    .product_bottom .add_cart {
      text-transform: uppercase;
      font-weight: 600;
      letter-spacing: 0.5px;
      text-decoration: underline;
    }
  </style>
@endsection