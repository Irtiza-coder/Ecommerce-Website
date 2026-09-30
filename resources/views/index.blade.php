@extends('Layout.main')
@section("content")
  <section class="hero_section">
    @php $hero = $cms['hero'] ?? null; @endphp
    <img src="{{ ($hero && $hero->image) ? asset('storage/' . $hero->image) : asset('images/Main_Page.png') }}" alt="Hero"
      class="img-fluid w-100" />
  </section>

  <section class="Welcome_section">
    @php $welcome = $cms['welcome'] ?? null; @endphp
    <div class="container">
      <div class="row align-items-center">
        <div class="col-sm-7 col-12">
          <div class="welcome_left">
            <p class="welcome_text">{{ ($welcome && $welcome->subtitle) ? $welcome->subtitle : 'Welcome To' }}</p>
            <h2 class="welcome_title">{!! ($welcome && $welcome->title) ? $welcome->title : 'CREST<span>&</span>CLOVE' !!}
            </h2>
          </div>
        </div>
        <div class="col-sm-5 col-12">
          <div class="welcome_right">
            <p>
              {{ ($welcome && $welcome->description && !str_contains($welcome->description, 'Lorem ipsum')) ? $welcome->description : 'Premium kitchenware crafted for everyday cooking — built to last, designed to impress.' }}
            </p>
            <div class="icons">
              <a href="" class="social_icon"><i class="fa-brands fa-facebook-f"></i></a>
              <a href="" class="social_icon active"><i class="fa-brands fa-x-twitter"></i></a>
              <a href="" class="social_icon"><i class="fa-brands fa-instagram"></i></a>
              <a href="" class="social_icon"><i class="fa-brands fa-linkedin-in"></i></a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="collections_section">
    <div class="container">
      <div class="row align-items-center mb-4">
        <div class="col-12 col-sm-8 col-lg-6 text-center text-sm-start">
          <h2 class="collections_title mb-0">Shop Our Collections</h2>
        </div>
        <div class="col-sm-4 col-lg-6 d-none d-sm-block">
          <div class="collections_arrows d-none d-sm-flex justify-content-end">
            <button type="button" class="arrow_btn" aria-label="Previous" onclick="mcScroll('collTrack', -1)">
              <i class="fa-solid fa-arrow-left"></i>
            </button>
            <button type="button" class="arrow_btn" aria-label="Next" onclick="mcScroll('collTrack', 1)">
              <i class="fa-solid fa-arrow-right"></i>
            </button>
          </div>
        </div>
      </div>

      <!-- ── COLLECTIONS CAROUSEL (from database products) ── -->
      <div class="multi-carousel" id="collCarousel">
        <button class="mc-btn mc-prev" onclick="mcScroll('collTrack', -1)" aria-label="Previous">
          &#8249;
        </button>
        <div class="mc-track" id="collTrack">
          @forelse($collectionProducts as $prod)
            <div class="mc-item">
              <div class="collection_card text-center" style="cursor:pointer;" data-url="{{ route('detail', $prod->slug) }}"
                onclick="window.location.href=this.dataset.url">
                <div class="collection_img imgchange">
                  <a href="{{ route('detail', $prod->slug) }}">
                    <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" />
                  </a>
                </div>
                <h3 class="collection_caption">{{ $prod->name }}</h3>
                <a href="{{ route('detail', $prod->slug) }}" class="shop_now_btn btn">Shop Now</a>
              </div>
            </div>
          @empty
            <p class="text-center text-secondary w-100 py-4">No products found.</p>
          @endforelse
        </div>
        <button class="mc-btn mc-next" onclick="mcScroll('collTrack', 1)" aria-label="Next">
          &#8250;
        </button>
      </div>
    </div>
  </section>

  <section class="feature_rows_section">
    @php
      $f1 = $cms['feature1'] ?? null;
      $f2 = $cms['feature2'] ?? null;
    @endphp
    <div class="container">
      <div class="row feature_row gx-2 gx-lg-5">
        <div class="col-6">
          <div class="feature_card">
            <div class="feature_img">
              <img src="{{ ($f1 && $f1->image) ? asset('storage/' . $f1->image) : asset('images/shop5.png') }}" alt="" />
            </div>
            <h3 class="feature_title">{{ ($f1 && $f1->title) ? $f1->title : 'Where Design Meets Precision' }}</h3>
            <p class="feature_text">
              {{ ($f1 && $f1->description && !str_contains($f1->description, 'Lorem ipsum')) ? $f1->description : 'Every piece is shaped with precision, blending function with timeless design.' }}
            </p>
            <a href="" class="shop_now_btn">Shop Now</a>
          </div>
        </div>
        <div class="col-6">
          <div class="feature_card">
            <div class="feature_img">
              <img src="{{ ($f2 && $f2->image) ? asset('storage/' . $f2->image) : asset('images/shop6.png') }}" alt="" />
            </div>
            <h3 class="feature_title">{{ ($f2 && $f2->title) ? $f2->title : "The Essential Chef's Companion" }}</h3>
            <p class="feature_text">
              {{ ($f2 && $f2->description && !str_contains($f2->description, 'Lorem ipsum')) ? $f2->description : 'From prep to plate, our tools are made to handle it all — without slowing you down.' }}
            </p>
            <a href="" class="shop_now_btn">Shop Now</a>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="brand_banner_section">
    @php $bb = $cms['brand_banner'] ?? null; @endphp
    <div class="brand_banner_img">
      <img src="{{ ($bb && $bb->image) ? asset('storage/' . $bb->image) : asset('images/image2.png') }}" alt="" />
    </div>
    <div class="brand_banner_overlay">
      <a href="/shop" class="banner_shop_btn">Shop Now</a>
      <h2 class="brand_banner_title">{{ ($bb && $bb->title) ? $bb->title : 'Crest&Clove' }}</h2>
    </div>
  </section>

  <section class="similar_products_section mt-5 mb-5">
    @php $shop = $cms['shop_section'] ?? null; @endphp
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section_title mb-2">{{ ($shop && $shop->title) ? $shop->title : 'Our Shop' }}</h2>
        <p class="section_subtitle mb-0">
          {{ ($shop && $shop->subtitle && !str_contains($shop->subtitle, 'Lorem ipsum')) ? $shop->subtitle : 'Explore our best-selling kitchenware, chosen for quality and everyday durability.' }}
        </p>
      </div>
      <div class="multi-carousel" id="prodCarousel">
        <button class="mc-btn mc-prev" onclick="mcScroll('prodTrack', -1)" aria-label="Previous">
          &#8249;
        </button>
        <div class="mc-track" id="prodTrack">
          @php
            $displayProducts = $featuredProducts->isNotEmpty() ? $featuredProducts : $shopProducts;
          @endphp
          @forelse($displayProducts as $prod)
            <div class="mc-item">
              <div class="product_card" style="cursor: pointer;" data-url="{{ route('detail', $prod->slug) }}"
                onclick="if(!event.target.closest('.add_cart')) window.location.href=this.dataset.url">
                <div class="product_img">
                  <a href="{{ route('detail', $prod->slug) }}">
                    <img src="{{ $prod->image_url }}" alt="{{ $prod->name }}" />
                  </a>
                </div>
                <div class="product_content">
                  <h3 class="product_name">
                    <a href="{{ route('detail', $prod->slug) }}"
                      class="text-decoration-none text-reset">{{ $prod->name }}</a>
                  </h3>
                  <p class="product_desc">
                    {{ $prod->short_description ?? 'Lorem ipsum dolor sit amet, consectetur adipisicing elit.' }}
                  </p>
                  <div class="product_bottom">
                    <span class="product_price">${{ number_format($prod->price, 2) }}</span>
                    <form action="{{ route('cart.add', $prod->id) }}" method="POST">
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
            <p class="text-center text-secondary w-100 py-4">No products available at this time.</p>
          @endforelse
        </div>
        <button class="mc-btn mc-next" onclick="mcScroll('prodTrack', 1)" aria-label="Next">
          &#8250;
        </button>
      </div>
    </div>
  </section>

  <section class="catalogue_section">
    @php $cat = $cms['catalogue'] ?? null; @endphp
    <div class="row g-0">
      <div class="col-lg-6">
        <div class="catalogue_left">
          <h2 class="catalogue_title">{{ ($cat && $cat->title) ? $cat->title : 'Browse Our 2026 Catalogue' }}</h2>
          <p class="catalogue_text">
            {{ ($cat && $cat->description && !str_contains($cat->description, 'Lorem ipsum')) ? $cat->description : 'Curated cookware and culinary essentials engineered for passionate home chefs and culinary experts.' }}
          </p>
          <a href="" class="shop_now_btn shop_now_btn_light">Shop Now</a>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="catalogue_img">
          <img src="{{ ($cat && $cat->image) ? asset('storage/' . $cat->image) : asset('images/073_Layer_14.png') }}"
            alt="Catalogue" />
        </div>
      </div>
    </div>
  </section>

  <section class="testimonials_section">
    @php $test = $cms['testimonials'] ?? null; @endphp
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section_title mb-2">{{ ($test && $test->title) ? $test->title : 'Our Happy Customers' }}</h2>
        <p class="section_subtitle mb-0">
          {{ ($test && $test->subtitle && !str_contains($test->subtitle, 'Lorem ipsum')) ? $test->subtitle : "Real feedback from customers who've made Crest & Clove part of their kitchen." }}
        </p>
      </div>

      <!-- ── TESTIMONIALS CAROUSEL (all screens) ── -->
      <div class="multi-carousel" id="testCarousel">
        <button class="mc-btn mc-prev" onclick="mcScroll('testTrack', -1)" aria-label="Previous">
          &#8249;
        </button>
        <div class="mc-track" id="testTrack" data-loop="false">
          @forelse($testimonials->take(3) as $item)
            <div class="mc-item">
              <div class="testimonial_card">
                <h4>{{ $item->name }}</h4>
                <span class="testimonial_role">{{ $item->role ?? 'Customer' }}</span>
                <p class="testimonial_text">
                  {{ $item->review }}
                </p>
                <div class="testimonial_bottom">
                  <div class="testimonial_stars">
                    @for($i = 1; $i <= 5; $i++)
                      <i class="{{ $i <= $item->rating ? 'fa-solid fa-star' : 'fa-regular fa-star' }}"></i>
                    @endfor
                  </div>
                  <img src="{{ $item->image_url }}" alt="{{ $item->name }}" />
                </div>
              </div>
            </div>
          @empty
            {{-- Fallback if no testimonials exist yet --}}
            <div class="mc-item">
              <div class="testimonial_card">
                <h4>Ann Peterson</h4>
                <span class="testimonial_role">Senior Director</span>
                <p class="testimonial_text">Exceptional quality and timeless aesthetic. The cookware performs reliably day in and day out.</p>
                <div class="testimonial_bottom">
                  <div class="testimonial_stars">
                    <i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
                      class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i>
                  </div>
                  <img src="{{ asset('images/Layer_23_copy_5.png') }}" alt="Ann Peterson" />
                </div>
              </div>
            </div>
          @endforelse

          <div class="mc-item">
            <a href="" class="view_all_panel" style="
                      min-height: 220px;
                      display: flex;
                      align-items: center;
                      justify-content: center;
                    ">
              <span class="view_all_btn">View All</span>
            </a>
          </div>
        </div>
        <button class="mc-btn mc-next" onclick="mcScroll('testTrack', 1)" aria-label="Next">
          &#8250;
        </button>
      </div>
    </div>
  </section>

  </body>

  </html>

@endsection