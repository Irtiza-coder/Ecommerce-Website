@extends('Layout.main')
@section("content")

	<!-- Banner Image Section -->
	<section class="page_banner">
		<div class="container-fluid px-0">
			<div class="row g-0">
				<div class="col-12">
					<img src="{{ asset('images/coll_cta_banner.png') }}" alt="Collections Banner"
						class="img-fluid w-100 banner_img">
				</div>
			</div>
		</div>
	</section>

	<!-- Collections Title Section -->
	<section class="collections_heading_section mb-5">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 text-center">
					<h1 class="collections_heading">COLLECTIONS</h1>
				</div>
			</div>
		</div>
	</section>

	<section class="feature_rows_section ">
		<div class="container">
			<div class="row feature_row gx-2 gx-lg-5">
				<div class="col-6">
					<div class="feature_card">
						<div class="feature_img">
							<img src="{{ asset('images/shop5.png') }}" alt="" />
						</div>
						<h3 class="feature_title">Where Design Meets Precision</h3>
						<p class="feature_text">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
							eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
							enim ad minim veniam, quis nostrud exercitation.
						</p>
						<a href="" class="shop_now_btn">Shop Now</a>
					</div>
				</div>
				<div class="col-6">
					<div class="feature_card">
						<div class="feature_img">
							<img src="{{ asset('images/shop6.png') }}" alt="" />
						</div>
						<h3 class="feature_title">The Essential Chef's Companion</h3>
						<p class="feature_text">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
							eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
							enim ad minim veniam, quis nostrud exercitation.
						</p>
						<a href="" class="shop_now_btn">Shop Now</a>
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

			<div class="multi-carousel" id="collCarousel">
				<button class="mc-btn mc-prev" onclick="mcScroll('collTrack', -1)" aria-label="Previous">
					&#8249;
				</button>
				<div class="mc-track" id="collTrack">
					@forelse($collectionProducts as $prod)
						<div class="mc-item">
							<div class="collection_card text-center" style="cursor:pointer;"
								data-url="{{ route('detail', $prod->slug) }}"
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
	</section>

	<section class="brand_banner_section mb-5">
		<div class="brand_banner_img">
			<img src="{{ asset('images/image2.png') }}" alt="">
		</div>
		<div class="brand_banner_overlay">
			<a href="/shop" class="banner_shop_btn">Shop Now</a>
			<h2 class="brand_banner_title">Crest&amp;Clove</h2>
		</div>
	</section>

	<section class="feature_rows_section mb-5">
		<div class="container">
			<div class="row feature_row gx-2 gx-lg-5">
				<div class="col-6">
					<div class="feature_card">
						<div class="feature_img">
							<img src="{{ asset('images/shop5.png') }}" alt="" />
						</div>
						<h3 class="feature_title">Where Design Meets Precision</h3>
						<p class="feature_text">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
							eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
							enim ad minim veniam, quis nostrud exercitation.
						</p>
						<a href="" class="shop_now_btn">Shop Now</a>
					</div>
				</div>
				<div class="col-6">
					<div class="feature_card">
						<div class="feature_img">
							<img src="{{ asset('images/shop6.png') }}" alt="" />
						</div>
						<h3 class="feature_title">The Essential Chef's Companion</h3>
						<p class="feature_text">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do
							eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut
							enim ad minim veniam, quis nostrud exercitation.
						</p>
						<a href="" class="shop_now_btn">Shop Now</a>
					</div>
				</div>
			</div>
		</div>
	</section>
@endsection