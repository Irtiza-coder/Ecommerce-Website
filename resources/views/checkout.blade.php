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
          <h1 class="collections_heading">CHECK OUT</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="checkout_section py-5">
    <div class="container">
      @if(session('error'))
        <div class="alert alert-danger mb-4">
          {{ session('error') }}
        </div>
      @endif

      @if($errors->any())
        <div class="alert alert-danger mb-4">
          <ul class="mb-0">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <form action="{{ route('order.place') }}" method="POST">
        @csrf
        <div class="row">
          <!-- Billing Details -->
          <div class="col-lg-7">
            <p class="login_text">
              Logged In As:
              <strong>{{ ($user->First_name ?? '') . ' ' . ($user->Last_name ?? '') }}</strong>
              ({{ $user->email ?? '' }})
            </p>

            <h2 class="checkout_title">BILLING DETAILS</h2>

            <div class="mb-3">
              <label>Country *</label>
              <input type="text" name="country" class="form-control" value="{{ old('country', 'Pakistan') }}" required />
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>First Name *</label>
                <input type="text" name="first_name" class="form-control"
                  value="{{ old('first_name', $user->First_name ?? '') }}" required />
              </div>

              <div class="col-md-6 mb-3">
                <label>Last Name *</label>
                <input type="text" name="last_name" class="form-control"
                  value="{{ old('last_name', $user->Last_name ?? '') }}" required />
              </div>
            </div>

            <div class="mb-3">
              <label>Company Name</label>
              <input type="text" name="company_name" class="form-control" value="{{ old('company_name') }}" />
            </div>

            <div class="mb-3">
              <label>Address *</label>
              <input type="text" name="address" class="form-control"
                placeholder="Street address, apartment, suite, unit, etc." value="{{ old('address') }}" required />
            </div>

            <div class="row">
              <div class="col-md-12 mb-3">
                <label>Town / City *</label>
                <input type="text" name="city" class="form-control" value="{{ old('city') }}" required />
              </div>
            </div>

            <div class="row">
              <div class="col-md-6 mb-3">
                <label>Email Address *</label>
                <input type="email" name="email" class="form-control" value="{{ old('email', $user->email ?? '') }}"
                  required />
              </div>

              <div class="col-md-6 mb-3">
                <label>Phone *</label>
                <input type="text" name="phone" class="form-control" value="{{ old('phone') }}" required />
              </div>
            </div>

            <div class="mb-3">
              <label>Order Notes</label>
              <textarea name="order_notes" rows="4" class="form-control"
                placeholder="Notes about your order, e.g. special delivery instructions.">{{ old('order_notes') }}</textarea>
            </div>
          </div>

          <!-- Right Side -->
          <div class="col-lg-5">
            <h2 class="checkout_title text-center">YOUR PAYMENT DETAILS</h2>

            <div class="payment_box">
              @foreach($cart as $item)
                <div class="payment_product">
                  <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" />

                  <div>
                    <h5>{{ $item['name'] }}</h5>
                    <p>Qty: {{ $item['quantity'] }} &times; ${{ number_format($item['price'], 2) }}</p>
                    <span>${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                  </div>
                </div>
              @endforeach
            </div>

            <!-- <div class="coupon_box">
                              YOU HAVE A COUPON ? CLICK HERE TO ENTER YOUR CODE
                            </div> -->

            <div class="price_box">
              <div class="price_row">
                <span>Subtotal</span>
                <span>${{ number_format($subtotal, 2) }}</span>
              </div>

              <div class="price_row">
                <span>Shipping</span>
                <span>{{ $shipping > 0 ? '$' . number_format($shipping, 2) : 'Free' }}</span>
              </div>

              <div class="price_row total">
                <span>Order Total</span>
                <span>${{ number_format($total, 2) }}</span>
              </div>
            </div>

            <div class="payment_method">
              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="payment_method" id="bank_transfer"
                  value="Direct Bank Transfer" checked>
                <label class="form-check-label" for="bank_transfer" style="cursor: pointer;">
                  <h5 class="d-inline mb-0">DIRECT BANK TRANSFER</h5>
                </label>
              </div>

              <p>Make your payment directly into our bank account. Please use your Order ID as the payment reference.</p>

              <div class="form-check mb-2">
                <input class="form-check-input" type="radio" name="payment_method" id="cod_payment"
                  value="Cash on Delivery">
                <label class="form-check-label" for="cod_payment" style="cursor: pointer;">
                  <h5 class="d-inline mb-0">CASH ON DELIVERY</h5>
                </label>
              </div>

              <div class="credit_card_heading mt-3">
                <div class="form-check">
                  <input class="form-check-input" type="radio" name="payment_method" id="card_payment"
                    value="Credit Card">
                  <label class="form-check-label" for="card_payment" style="cursor: pointer;">
                    <h5 class="d-inline mb-0">CREDIT CARD</h5>
                  </label>
                </div>
                <img src="{{ asset('images/cards.png') }}" alt="Payment Cards" />
              </div>

              <button type="submit" class="place_btn" style="border:none; cursor:pointer;">PLACE ORDER</button>
            </div>
          </div>
        </div>
      </form>
    </div>
  </section>
@endsection