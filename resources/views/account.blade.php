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
					<h1 class="collections_heading">account</h1>
				</div>
			</div>
		</div>
	</section>

	<section class="account_section section_pad">
		<div class="container">

			@if(session('error') && !session('form'))
				<div class="row justify-content-center mb-4">
					<div class="col-12 col-lg-10">
						<div class="alert alert-danger text-center">{{ session('error') }}</div>
					</div>
				</div>
			@endif

			<div class="row justify-content-center align-items-start gx-3 gx-lg-4">
				<div class="col-12 col-sm-6 col-lg-5 mb-4 mb-sm-0">
					<div class="account_card">
						<h2 class="account_card_title">Login Your Account</h2>

						{{-- LOGIN ERRORS --}}
						@if($errors->login->any())
							<div class="alert alert-danger text-start mt-3 mb-3" style="font-size:13px; border-radius:8px;">
								<ul class="mb-0 ps-3">
									@foreach($errors->login->all() as $err)
										<li>{{ $err }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						@if(session('error') && session('form') == 'login')
							<div class="alert alert-danger text-center mt-3 mb-3" style="font-size:13px; border-radius:8px;">
								{{ session('error') }}
							</div>
						@endif

						@if(session('message') && session('form') == 'login')
							<div class="alert alert-success text-center mt-3 mb-3" style="font-size:13px; border-radius:8px;">
								{{ session('message') }}
							</div>
						@endif

						<form class="account_form" method="POST" action="{{ route('login') }}">
							@csrf
							<div class="mb-3">
								<input type="email" name="email" class="form-control account_input"
									placeholder="Email Address" value="{{ $errors->login->any() ? old('email') : '' }}" required>
								@if($errors->login->has('email'))
									<div class="text-danger mt-1" style="font-size:12px;">{{ $errors->login->first('email') }}
									</div>
								@endif
							</div>
							<div class="mb-4">
								<input type="password" name="password" class="form-control account_input"
									placeholder="Password" required>
								@if($errors->login->has('password'))
									<div class="text-danger mt-1" style="font-size:12px;">
										{{ $errors->login->first('password') }}</div>
								@endif
							</div>
							<button type="submit" class="account_submit_btn w-100">Log In</button>
							<div class="account_form_footer">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" id="rememberMe">
									<label class="form-check-label" for="rememberMe">Remind Me</label>
								</div>
								<a href="" class="forgot_link">Forgot Password?</a>
							</div>
						</form>
					</div>
				</div>

				<div class="col-12 col-sm-6 col-lg-5">
					<div class="account_card">
						<h2 class="account_card_title">Register Your Account</h2>

						{{-- REGISTER ERRORS --}}
						@if($errors->signup->any())
							<div class="alert alert-danger text-start mt-3 mb-3" style="font-size:13px; border-radius:8px;">
								<ul class="mb-0 ps-3">
									@foreach($errors->signup->all() as $err)
										<li>{{ $err }}</li>
									@endforeach
								</ul>
							</div>
						@endif

						@if(session('error') && session('form') == 'signup')
							<div class="alert alert-danger text-center mt-3 mb-3" style="font-size:13px; border-radius:8px;">
								{{ session('error') }}
							</div>
						@endif

						@if(session('message') && session('form') == 'signup')
							<div class="alert alert-success text-center mt-3 mb-3" style="font-size:13px; border-radius:8px;">
								{{ session('message') }}
							</div>
						@endif

						<!-- REGISTER FORM -->
						<form class="account_form" method="POST" action="{{ route('signup') }}">
							@csrf
							<div class="row">
								<div class="col-6 mb-3">
									<input type="text" name="first_name" value="{{ $errors->signup->any() ? old('first_name') : '' }}"
										class="form-control account_input" placeholder="First Name" required>
									@if($errors->signup->has('first_name'))
										<div class="text-danger mt-1" style="font-size:12px;">
											{{ $errors->signup->first('first_name') }}</div>
									@endif
								</div>
								<div class="col-6 mb-3">
									<input type="text" value="{{ $errors->signup->any() ? old('last_name') : '' }}" name="last_name"
										class="form-control account_input" placeholder="Last Name" required>
									@if($errors->signup->has('last_name'))
										<div class="text-danger mt-1" style="font-size:12px;">
											{{ $errors->signup->first('last_name') }}</div>
									@endif
								</div>
							</div>
							<div class="mb-3">
								<input type="email" value="{{ $errors->signup->any() ? old('email') : '' }}" name="email"
									class="form-control account_input" placeholder="Email Address" required>
								@if($errors->signup->has('email'))
									<div class="text-danger mt-1" style="font-size:12px;">{{ $errors->signup->first('email') }}
									</div>
								@endif
							</div>
							<div class="mb-3">
								<input type="password" name="password" class="form-control account_input"
									placeholder="Enter Password" required>
								@if($errors->signup->has('password'))
									<div class="text-danger mt-1" style="font-size:12px;">
										{{ $errors->signup->first('password') }}</div>
								@endif
							</div>
							<div class="mb-3">
								<input type="password" name="password_confirm" class="form-control account_input"
									placeholder="Retype Password" required>
								@if($errors->signup->has('password_confirm'))
									<div class="text-danger mt-1" style="font-size:12px;">
										{{ $errors->signup->first('password_confirm') }}</div>
								@endif
							</div>
							<p class="account_terms">By creating an account, You agree to our <a href="">Term &amp;
									Conditions</a></p>
							<button type="submit" class="account_submit_btn w-100">Create Account</button>
						</form>
					</div>
				</div>
			</div>
		</div>
	</section>

@endsection