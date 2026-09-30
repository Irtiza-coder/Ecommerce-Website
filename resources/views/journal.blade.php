@extends('Layout.main')
@section("content")  

@php
    $banner = $cms['journal_banner'] ?? null;
    $post1  = $cms['journal_post1']  ?? null;
    $post2  = $cms['journal_post2']  ?? null;
    $post3  = $cms['journal_post3']  ?? null;
@endphp

  <!-- Banner Image Section -->
  <section class="page_banner">
    <div class="container-fluid px-0">
      <div class="row g-0">
        <div class="col-12">
          <img src="{{ ($banner && $banner->image) ? asset('storage/' . $banner->image) : asset('images/coll_cta_banner.png') }}" alt="Collections Banner" class="img-fluid w-100 banner_img" />
        </div>
      </div>
    </div>
  </section>

  <!-- Collections Title Section -->
  <section class="collections_heading_section">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-12 text-center">
          <h1 class="collections_heading">{{ ($banner && $banner->title) ? $banner->title : 'journal' }}</h1>
        </div>
      </div>
    </div>
  </section>

  <section class="journal_alt_section section_pad">
    <div class="container">

      <!-- Post 1 -->
      <div class="row align-items-stretch gx-2 gx-lg-5 journal_alt_row">
        <div class="col-6 mb-4 mb-lg-0">
          <div class="journal_alt_img">
            <img src="{{ ($post1 && $post1->image) ? asset('storage/' . $post1->image) : asset('images/journal_featured.png') }}" alt="{{ $post1->title ?? 'Cooking & Techniques' }}">
          </div>
        </div>
        <div class="col-6">
          <div class="journal_alt_card">
            <h3 class="journal_alt_title">{!! ($post1 && $post1->title) ? nl2br(e($post1->title)) : 'Cooking<br>&amp; Techniques' !!}</h3>
            <p class="journal_alt_text">{{ ($post1 && $post1->description && !str_contains($post1->description, 'Lorem ipsum')) ? $post1->description : 'Mastering the art of heat control, seasoning cast iron, and knife sharpening techniques to bring professional finesse into your everyday kitchen.' }}</p>
            <ul class="journal_alt_list">
              <li><i class="fa-solid fa-circle"></i>Pro Knife Sharpening Tips</li>
              <li><i class="fa-solid fa-circle"></i>Mastering Searing Temperatures</li>
              <li><i class="fa-solid fa-circle"></i>Cast Iron Seasoning Guide</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Post 2 -->
      <div class="row align-items-stretch gx-2 gx-lg-5 journal_alt_row">
        <div class="col-6 order-lg-2 mb-4 mb-lg-0">
          <div class="journal_alt_img">
            <img src="{{ ($post2 && $post2->image) ? asset('storage/' . $post2->image) : asset('images/blog5.png') }}" alt="{{ $post2->title ?? 'Recipes & Bakery' }}">
          </div>
        </div>
        <div class="col-6 order-lg-1">
          <div class="journal_alt_card">
            <h3 class="journal_alt_title">{!! ($post2 && $post2->title) ? nl2br(e($post2->title)) : 'Recipes<br>&amp; Bakery' !!}</h3>
            <p class="journal_alt_text">{{ ($post2 && $post2->description && !str_contains($post2->description, 'Lorem ipsum')) ? $post2->description : 'From artisan sourdough loaves to delicate pastries, discover essential baking ratios, crust perfecting tips, and seasonal culinary recipes.' }}</p>
            <ul class="journal_alt_list">
              <li><i class="fa-solid fa-circle"></i>Artisan Sourdough Fundamentals</li>
              <li><i class="fa-solid fa-circle"></i>Pastry Crust Perfection</li>
              <li><i class="fa-solid fa-circle"></i>Baking Temperature Science</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- Post 3 -->
      <div class="row align-items-stretch gx-2 gx-lg-5 journal_alt_row">
        <div class="col-6 mb-4 mb-lg-0">
          <div class="journal_alt_img">
            <img src="{{ ($post3 && $post3->image) ? asset('storage/' . $post3->image) : asset('images/blog4.png') }}" alt="{{ $post3->title ?? 'Product Care & Use' }}">
          </div>
        </div>
        <div class="col-6">
          <div class="journal_alt_card">
            <h3 class="journal_alt_title">{!! ($post3 && $post3->title) ? nl2br(e($post3->title)) : 'Product<br>Care &amp; Use' !!}</h3>
            <p class="journal_alt_text">{{ ($post3 && $post3->description && !str_contains($post3->description, 'Lorem ipsum')) ? $post3->description : 'Simple guidelines to preserve the beauty and lifetime performance of your stainless steel, enameled pots, and handcrafted carbon steel woks.' }}</p>
            <ul class="journal_alt_list">
              <li><i class="fa-solid fa-circle"></i>Caring for Clad Stainless Steel</li>
              <li><i class="fa-solid fa-circle"></i>Preserving Wood Knife Handles</li>
              <li><i class="fa-solid fa-circle"></i>Long-term Non-Stick Care</li>
            </ul>
          </div>
        </div>
      </div>

      <!-- <nav class="journal_pagination">
        <a href="" class="page_arrow"><i class="fa-solid fa-arrow-left"></i></a>
        <a href="" class="page_num active">1</a>
        <a href="" class="page_num">2</a>
        <a href="" class="page_arrow"><i class="fa-solid fa-arrow-right"></i></a>
      </nav> -->

    </div>
  </section>

@endsection