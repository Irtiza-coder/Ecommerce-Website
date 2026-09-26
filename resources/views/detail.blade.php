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
	<section class="collections_heading_section">
		<div class="container">
			<div class="row justify-content-center">
				<div class="col-12 text-center">
					<h1 class="collections_heading">DETAILS</h1>
				</div>
			</div>
		</div>
	</section>

	<section class="product_detail_section section_pad">
		<div class="container">
			<div class="row gx-5 align-items-start">
				<div class="col-lg-6">
					<div class="detail_single_img">
						<img src="{{ $product->image_url }}" alt="{{ $product->name }}">
					</div>
				</div>
				<div class="col-lg-6">
					<div class="detail_info">
						<h1 class="detail_title">{{ $product->name }}</h1>

						<div class="detail_price_row">
							@if($product->old_price)
								<span class="old_price">${{ number_format($product->old_price, 2) }}</span>
							@endif
							<span class="new_price">${{ number_format($product->price, 2) }}</span>
							<div class="detail_rating">
								<i class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
									class="fa-solid fa-star"></i><i class="fa-solid fa-star"></i><i
									class="fa-solid fa-star"></i>
								<span>45 Reviews</span>
							</div>
						</div>

						<p class="detail_meta_line"><strong>Brand :</strong> {{ $product->brand ?? 'N/A' }}</p>
						<p class="detail_meta_line"><strong>Availability :</strong> 
							@if($product->stock_status === 'In Stock' && $product->stock_quantity > 0)
								<span style="color:#16a34a;font-weight:600;"><i class="fa-solid fa-circle-check me-1"></i> In Stock ({{ $product->stock_quantity }} units available)</span>
							@else
								<span style="color:#dc2626;font-weight:600;"><i class="fa-solid fa-circle-xmark me-1"></i> Out of Stock</span>
							@endif
						</p>

						<p class="detail_desc">{{ $product->description }}</p>

						<div class="detail_action_row">
							@if($product->stock_status === 'In Stock' && $product->stock_quantity > 0)
								<form action="{{ route('cart.add', $product->id) }}" method="POST"
									class="d-flex align-items-center gap-3" style="display:inline-flex;">
									@csrf
									<div class="qty_selector">
										<button type="button" class="qty_btn minus"
											onclick="changeDetailQty(-1)">&minus;</button>
										<input type="number" name="quantity" id="detail_qty_input" class="qty_input" value="1"
											min="1" max="{{ $product->stock_quantity }}" style="width:50px; text-align:center;">
										<button type="button" class="qty_btn plus" onclick="changeDetailQty(1)">&plus;</button>
									</div>
									<button type="submit" class="add_to_cart_btn">
										Add to Cart
									</button>
								</form>
							@else
								<button type="button" class="add_to_cart_btn" disabled style="opacity:0.6;cursor:not-allowed;background:#999;border-color:#999;">
									Out of Stock
								</button>
							@endif
							@php
								$inWishlist = in_array($product->id, session('wishlist', []));
							@endphp
							<form action="{{ route('wishlist.toggle', $product->id) }}" method="POST"
								style="display:inline;">
								@csrf
								<button type="submit" class="wishlist_btn"
									title="{{ $inWishlist ? 'Remove from wishlist' : 'Add to wishlist' }}">
									@if($inWishlist)
										<i class="fa-solid fa-heart" style="color: #ef4444;"></i>
									@else
										<i class="fa-regular fa-heart"></i>
									@endif
								</button>
							</form>
						</div>

						<div class="detail_socials">
							<a href=""><i class="fa-brands fa-facebook-f"></i></a>
							<a href="" class=""><i class="fa-brands fa-x-twitter"></i></a>
							<a href=""><i class="fa-brands fa-linkedin-in"></i></a>
						</div>
					</div>
				</div>
			</div>
		</div>
	</section>


	<section class="similar_products_section mt-5">
		<div class="container">
			<div class="text-center mb-5">
				<h2 class="section_title mb-2">You May Also Like</h2>
				<p class="section_subtitle mb-0">
					Explore more premium kitchenware from our handcrafted collection.
				</p>
			</div>
			<div class="multi-carousel" id="prodCarousel">
				<button class="mc-btn mc-prev" onclick="mcScroll('prodTrack', -1)" aria-label="Previous">
					&#8249;
				</button>
				<div class="mc-track" id="prodTrack">
					@forelse($similar as $sp)
						<div class="mc-item">
							<div class="product_card" style="cursor: pointer;" data-url="{{ route('detail', $sp->slug) }}"
								onclick="if(!event.target.closest('.add_cart')) window.location.href=this.dataset.url">
								<div class="product_img">
									<a href="{{ route('detail', $sp->slug) }}">
										<img src="{{ $sp->image_url }}" alt="{{ $sp->name }}" />
									</a>
								</div>
								<div class="product_content">
									<h3 class="product_name">
										<a href="{{ route('detail', $sp->slug) }}"
											class="text-decoration-none text-reset">{{ $sp->name }}</a>
									</h3>
									<p class="product_desc">{{ $sp->short_description }}</p>
									<div class="product_bottom">
										<span class="product_price">${{ number_format($sp->price, 2) }}</span>
										<a href="{{ url('/cart') }}" class="add_cart">Add To Cart</a>
									</div>
								</div>
							</div>
						</div>
					@empty
						<p class="text-center text-secondary w-100">No products found.</p>
					@endforelse
				</div>
				<button class="mc-btn mc-next" onclick="mcScroll('prodTrack', 1)" aria-label="Next">
					&#8250;
				</button>
			</div>
		</div>
	</section>

	<script>
		function changeDetailQty(amount) {
			const input = document.getElementById('detail_qty_input');
			if (!input) return;
			let val = parseInt(input.value) || 1;
			val += amount;
			if (val < 1) val = 1;
			if (val > 99) val = 99;
			input.value = val;
		}
	</script>
@endsection