<footer class="footer-section">
    @php
        $fc  = $footerCms['footer_contact']   ?? null;
        $fs  = $footerCms['footer_subscribe']  ?? null;
        $fso = $footerCms['footer_social']     ?? null;
        $fcp = $footerCms['footer_copyright']  ?? null;

        // Social links: stored as fb|tw|ig|li
        $socialLinks = explode('|', ($fso ? $fso->description : '#|#|#|#'));
        $fbUrl = $socialLinks[0] ?? '#';
        $twUrl = $socialLinks[1] ?? '#';
        $igUrl = $socialLinks[2] ?? '#';
        $liUrl = $socialLinks[3] ?? '#';

        // Contact: email|phone in description
        $contactParts = explode('|', ($fc ? $fc->description : 'loremipsum@gmail.com|(123)-456-7890'));
        $footerEmail  = $contactParts[0] ?? 'loremipsum@gmail.com';
        $footerPhone  = $contactParts[1] ?? '(123)-456-7890';
        $footerAddr   = ($fc && $fc->subtitle) ? $fc->subtitle : 'Lorem ipsum dolor sit amet consectetur adipisicing elit.';
    @endphp

    <div class="container">
        <div class="row">

            {{-- Contact Us --}}
            <div class="col-lg-4 col-md-6 col-12 footer-box text-center">
                <h3>{{ ($fc && $fc->title) ? $fc->title : 'Contact Us' }}</h3>

                <div class="contact-item">
                    <i class="bi bi-geo-alt"></i>
                    <span>{{ $footerAddr }}</span>
                </div>
                <div class="contact-item">
                    <i class="bi bi-envelope"></i>
                    <span>{{ $footerEmail }}</span>
                </div>
                <div class="contact-item">
                    <i class="bi bi-telephone"></i>
                    <span>{{ $footerPhone }}</span>
                </div>
            </div>

            {{-- Subscribe --}}
            <div class="col-lg-4 col-md-6 col-12 footer-box text-center">
                <h3>{{ ($fs && $fs->title) ? $fs->title : 'Subscribe' }}</h3>
                <p class="small-text">
                    {{ ($fs && $fs->subtitle) ? $fs->subtitle : 'Sign up for our newsletter to get up-to-date from us' }}
                </p>
                <form>
                    <input type="email" class="form-control subscribe-input" placeholder="Enter Your Email" />
                    <button type="submit" class="btn subscribe-btn w-100 mt-3">
                        SUBSCRIBE <i class="bi bi-arrow-right ms-2"></i>
                    </button>
                </form>
                <div class="social-icons mt-4">
                    @if($fbUrl !== '#') <a href="{{ $fbUrl }}" target="_blank"><i class="bi bi-facebook"></i></a>
                    @else <a href="#"><i class="bi bi-facebook"></i></a> @endif

                    @if($twUrl !== '#') <a href="{{ $twUrl }}" target="_blank"><i class="bi bi-twitter-x"></i></a>
                    @else <a href="#"><i class="bi bi-twitter-x"></i></a> @endif

                    @if($igUrl !== '#') <a href="{{ $igUrl }}" target="_blank"><i class="bi bi-instagram"></i></a>
                    @else <a href="#"><i class="bi bi-instagram"></i></a> @endif

                    @if($liUrl !== '#') <a href="{{ $liUrl }}" target="_blank"><i class="bi bi-linkedin"></i></a>
                    @else <a href="#"><i class="bi bi-linkedin"></i></a> @endif
                </div>
            </div>

            {{-- Quick Links --}}
            <div class="col-lg-4 col-md-12 col-12 footer-box text-center">
                <h3>Quick Links</h3>
                <ul class="footer-links">
                    <li><a href="/">Home</a></li>
                    <li><a href="/shop">Shop</a></li>
                    <li><a href="/collections">Collection</a></li>
                    <li><a href="/about-us">About</a></li>
                    <li><a href="/contact-us">Contact Us</a></li>
                </ul>
            </div>

        </div>
    </div>

    {{-- Bottom Footer --}}
    <div class="footer-bottom">
        <div class="container">
            <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                <p class="mb-3 mb-md-0">{{ ($fcp && $fcp->title) ? $fcp->title : '© 2026, All Rights Reserved' }}</p>
                <div class="payment-icons d-flex align-items-center gap-2">
                    <img src="{{ asset('images/payments/visa.svg') }}" alt="Visa" style="height: 24px; width: auto; object-fit: contain;" />
                    <img src="{{ asset('images/payments/mastercard.svg') }}" alt="MasterCard" style="height: 24px; width: auto; object-fit: contain;" />
                    <img src="{{ asset('images/payments/discover.svg') }}" alt="Discover" style="height: 24px; width: auto; object-fit: contain;" />
                    <img src="{{ asset('images/payments/paypal.svg') }}" alt="PayPal" style="height: 24px; width: auto; object-fit: contain;" />
                    <img src="{{ asset('images/payments/applepay.svg') }}" alt="Apple Pay" style="height: 24px; width: auto; object-fit: contain;" />
                </div>
            </div>
        </div>
    </div>
</footer>
