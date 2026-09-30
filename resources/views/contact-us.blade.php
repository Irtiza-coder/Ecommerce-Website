@extends('Layout.main')
@section("content")  

@php
  $banner   = $cms['contact_banner'] ?? null;
  $header   = $cms['contact_header'] ?? null;
  $location = $cms['contact_location'] ?? null;
  $phone    = $cms['contact_phone'] ?? null;
  $email    = $cms['contact_email'] ?? null;
  $faq      = $cms['contact_form_intro'] ?? null;
@endphp

  <!-- Banner Image Section -->
  <section class="page_banner">
    <div class="container-fluid px-0">
      <div class="row g-0">
        <div class="col-12">
          <img src="{{ ($banner && $banner->image) ? asset('storage/' . $banner->image) : asset('images/coll_cta_banner.png') }}"
            alt="{{ ($banner && $banner->title) ? $banner->title : 'Contact Us Banner' }}"
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
          <h1 class="collections_heading">{{ ($banner && $banner->title) ? $banner->title : 'contact us' }}</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="contact_info_section section_pad">
    <div class="container">
      <div class="text-center mb-5">
        <h2 class="section_title">{{ ($header && $header->title) ? $header->title : 'Contact Details' }}</h2>
        <p class="section_subtitle">
          {{ ($header && $header->subtitle && !str_contains($header->subtitle, 'Dolor sit')) ? $header->subtitle : 'Have questions about our artisan products or orders? Our culinary concierge team is here to assist you.' }}
        </p>
      </div>

      <div class="row g-4 mb-5">
        <div class="col-lg-4">
          <div class="contact_info_card">
            <i class="fa-solid fa-location-dot"></i>
            <h4>{{ ($location && $location->title) ? $location->title : 'Location Address' }}</h4>
            <p>{!! ($location && $location->description && !str_contains($location->description, 'Ipsum dolor')) ? nl2br(e($location->description)) : '100 Artisan Way, Suite 400<br>Culinary District, NY 10001' !!}</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="contact_info_card">
            <i class="fa-solid fa-phone"></i>
            <h4>{{ ($phone && $phone->title) ? $phone->title : 'Phone Contact' }}</h4>
            <p>{!! ($phone && $phone->description && !str_contains($phone->description, '123 456 7890')) ? nl2br(e($phone->description)) : 'Tel: +92 300 1234567<br>Toll-Free: +1 (800) 555-0199' !!}</p>
          </div>
        </div>
        <div class="col-lg-4">
          <div class="contact_info_card">
            <i class="fa-solid fa-at"></i>
            <h4>{{ ($email && $email->title) ? $email->title : 'Email Contact' }}</h4>
            <p>{!! ($email && $email->description && !str_contains($email->description, 'Example.')) ? nl2br(e($email->description)) : 'support@crestandclove.com<br>concierge@crestandclove.com' !!}</p>
          </div>
        </div>
      </div>

      <div class="text-center mb-5">
        <h2 class="section_title">{{ ($faq && $faq->title) ? $faq->title : 'Have A Question For Us' }}</h2>
        <p class="section_subtitle">
          {{ ($faq && $faq->subtitle && !str_contains($faq->subtitle, 'Dolor sit')) ? $faq->subtitle : 'Fill out the form below and our team will get back to you within 24 business hours.' }}
        </p>
      </div>

      <form class="contact_form" method="POST" action="{{ route('contact.store') }}">
        @csrf
        <div class="row g-4">
          <div class="col-md-4">
            <label class="contact_label">Your Name</label>
            <input type="text" class="form-control contact_input" name="name" required>
          </div>
          <div class="col-md-4">
            <label class="contact_label">Mobile Number</label>
            <input type="text" name="mobile" class="form-control contact_input" required>
          </div>
          <div class="col-md-4">
            <label class="contact_label">Your Email Address</label>
            <input type="email" name="email" class="form-control contact_input" required>
          </div>
          <div class="col-12">
            <label class="contact_label">Your Message Here</label>
            <textarea name="message" class="form-control contact_input contact_textarea"></textarea>
          </div>
          <div class="col-12 text-center">
            <button type="submit" class="contact_submit_btn">Send Now</button>
          </div>
        </div>
      </form>
      @if(session('success'))
        <div class="alert alert-success text-center mt-4">{{ session('success') }}</div>
      @endif

    </div>
  </section>

@endsection