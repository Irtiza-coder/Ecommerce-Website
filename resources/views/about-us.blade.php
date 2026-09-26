@extends('Layout.main')
@section("content")
  @php
    $banner = $cms['about_banner'] ?? null;
    $story = $cms['about_story'] ?? null;
    $mission = $cms['about_mission'] ?? null;
    $vision = $cms['about_vision'] ?? null;
    $test = $cms['testimonials'] ?? null;
  @endphp
  <section class="page_banner">
    <div class="container-fluid px-0">
      <div class="row g-0">
        <div class="col-12">
          <img
            src="{{ ($banner && $banner->image) ? asset('storage/' . $banner->image) : asset('images/coll_cta_banner.png') }}"
            alt="Collections Banner" class="img-fluid w-100 banner_img" />
        </div>
      </div>
    </div>
  </section>

  <!-- Collections Title Section -->
  <section class="collections_heading_section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 text-center">
          <h1 class="collections_heading">{{ ($banner && $banner->title) ? $banner->title : 'About Us' }}</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="about_story_section section_pad">
    <div class="container">
      <div class="row align-items-center gx-5">
        <div class="col-lg-6 mb-4 mb-lg-0">
          <div class="about_img_frame">
            <img
              src="{{ ($story && $story->image) ? asset('storage/' . $story->image) : asset('images/about_wide.png') }}"
              alt="Our Story" />
          </div>
        </div>
        <div class="col-lg-6">
          <div class="about_text_card">
            <h2 class="feature_title_lg display_title">{{ ($story && $story->title) ? $story->title : 'Our Story'}}</h2>
            <p class="feature_text">
              {{ ($story && $story->description) ? $story->description : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
                                Duis aute irure dolor in reprehenderit in voluptate velit esse
                                cillum dolore eu fugiat nulla pariatur. Sint occaecat cupidatat
                                non proident, sunt in culpa qui officia deserunt mollit anim id
                                est laborum. Sed ut perspiciatis unde omnis iste natus error sit
                                voluptatem accusantium doloremque laudantium, totam rem aperiam,
                                eaque ipsa quae ab illo inventore veritatis quasi architecto
                                beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem
                                quia voluptas sit aspernatur aut odit aut fugit, sed quia
                                consequuntur magni dolores eos qui ratione voluptatem sequi
                                nesciunt.' }}
            </p>
            <div class="about_extra_text d-lg-none d-flex">
              <p class="feature_text">
                {{ ($story && $story->subtitle) ? $story->subtitle : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam.' }}
              </p>
            </div>
          </div>
        </div>
      </div>

      <div class="row mt-5">
        <div class="col-12">
          <div class="about_extra_text d-none d-lg-flex">
            <p class="feature_text">
              {{ ($story && $story->subtitle) ? $story->subtitle : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum. Sed ut perspiciatis unde omnis iste natus error sit voluptatem accusantium doloremque laudantium, totam rem aperiam, eaque ipsa quae ab illo inventore veritatis et quasi architecto beatae vitae dicta sunt explicabo. Nemo enim ipsam voluptatem quia voluptas sit aspernatur aut odit aut fugit, sed quia consequuntur magni dolores eos qui ratione voluptatem sequi nesciunt. Neque porro quisquam est, qui dolorem ipsum quia dolor sit amet, consectetur, adipisci velit, sed quia non numquam eius modi tempora incidunt ut labore et dolore magnam aliquam.' }}
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="about_mission_section section_pad">
    <div class="container">
      <div class="row align-items-center gx-5 mb-5">
        <div class="col-lg-6 order-lg-1 mb-4 mb-lg-0">
          <div class="about_text_block">
            <h2 class="feature_title_lg">{{ ($mission && $mission->title) ? $mission->title : 'Our Mission'}}</h2>
            <p class="feature_text">
              {{ ($mission && $mission->description) ? $mission->description : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
                                  Duis aute irure dolor in reprehenderit in voluptate velit esse
                                  cillum dolore eu fugiat nulla pariatur. Sint occaecat cupidatat
                                  non proident, sunt in culpa qui officia deserunt mollit anim id
                                  est laborum.' }}
            </p>
          </div>
        </div>
        <div class="col-lg-6 order-lg-2">
          <div class="d-flex justify-content-lg-end">
            <div class="about_img_frame framed">
              <img
                src="{{ $mission && $mission->image ? asset('storage/' . $mission->image) : asset('images/about_mission.png') }}"
                alt="Our Mission" />
            </div>
          </div>
        </div>
      </div>

      <div class="row align-items-center gx-5">
        <div class="col-lg-6 order-lg-2 mb-4 mb-lg-0">
          <div class="about_text_block">
            <h2 class="feature_title_lg">{{ ($vision && $vision->title) ? $vision->title : 'Our Vision'}}</h2>
            <p class="feature_text">
              {{ ($vision && $vision->description) ? $vision->description : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua
                                  Duis aute irure dolor in reprehenderit in voluptate velit esse
                                  cillum dolore eu fugiat nulla pariatur. Sint occaecat cupidatat
                                  non proident, sunt in culpa qui officia deserunt mollit anim id
                                  est laborum.' }}
            </p>
          </div>
        </div>
        <div class="col-lg-6 order-lg-1">
          <div class="d-flex justify-content-lg-start">
            <div class="about_img_frame framed">
              <img
                src="{{ ($vision && $vision->image) ? asset('storage/' . $vision->image) : asset('images/about_vision.png') }}"
                alt="Our Vision" />
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <section class="testimonials_section">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section_title mb-2">{{ ($test && $test->title) ? $test->title : 'Our Happy Customers' }}</h2>
        <p class="section_subtitle mb-0">
          {{ ($test && $test->subtitle) ? $test->subtitle : 'Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.' }}
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
            <div class="mc-item">
              <div class="testimonial_card">
                <h4>Ann Peterson</h4>
                <span class="testimonial_role">Senior Director</span>
                <p class="testimonial_text">
                  Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed
                  do eiusmod tempor incididunt ut labore et dolore magna aliqua.
                  Ut enim ad minim.
                </p>
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
@endsection