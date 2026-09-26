@extends('Layout.main')
@section("content")

<style>
  .dash_wrapper {
    display: flex;
    min-height: 80vh;
    background: #f8f9fa;
  }

  .dash_sidebar {
    width: 260px;
    background: #191c24;
    color: #fff;
    padding: 35px 20px;
    flex-shrink: 0;
  }

  .dash_sidebar h4 {
    color: #b8935a;
    margin-bottom: 28px;
    font-weight: 700;
    font-size: 19px;
    letter-spacing: 0.5px;
    padding-left: 8px;
  }

  .dash_sidebar a {
    display: flex;
    align-items: center;
    gap: 12px;
    color: #94a3b8;
    text-decoration: none;
    padding: 12px 16px;
    border-radius: 8px;
    margin-bottom: 6px;
    font-size: 14px;
    font-weight: 500;
    transition: all 0.2s ease;
  }

  .dash_sidebar a:hover,
  .dash_sidebar a.active {
    background: rgba(184, 147, 90, 0.15);
    color: #b8935a;
    font-weight: 600;
  }

  .dash_main {
    flex-grow: 1;
    padding: 35px 40px;
  }

  .dash_topbar {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 30px;
    flex-wrap: wrap;
    gap: 15px;
  }

  .dash_topbar h2 {
    font-weight: 700;
    color: #1e293b;
    margin: 0;
    font-size: 24px;
  }

  .dash_topbar .btn-logout {
    background: #fff;
    border: 1px solid rgba(220, 53, 69, 0.4);
    color: #dc3545;
    padding: 8px 20px;
    border-radius: 8px;
    font-size: 13px;
    font-weight: 600;
    text-decoration: none;
    transition: 0.2s;
    display: inline-flex;
    align-items: center;
    gap: 6px;
  }

  .dash_topbar .btn-logout:hover {
    background: #dc3545;
    color: #fff;
  }

  .stat_cards {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 20px;
    margin-bottom: 30px;
  }

  .stat_card {
    background: #fff;
    border-radius: 12px;
    padding: 22px 24px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    border-left: 4px solid #b8935a;
  }

  .stat_card h5 {
    font-size: 12px;
    text-transform: uppercase;
    color: #64748b;
    letter-spacing: 0.5px;
    margin-bottom: 8px;
    font-weight: 600;
  }

  .stat_card .stat_value {
    font-size: 26px;
    font-weight: 700;
    color: #1e293b;
  }

  .dash_card {
    background: #fff;
    border-radius: 12px;
    box-shadow: 0 2px 12px rgba(0, 0, 0, 0.04);
    border: 1px solid #edf2f7;
    overflow: hidden;
  }

  .dash_card_header {
    padding: 18px 24px;
    border-bottom: 1px solid #edf2f7;
    font-weight: 700;
    color: #1e293b;
    font-size: 16px;
    display: flex;
    align-items: center;
    justify-content: space-between;
  }

  .dash_card_body {
    padding: 0;
  }

  .dash_table {
    width: 100%;
    margin: 0;
    border-collapse: collapse;
  }

  .dash_table th {
    background: #f8fafc;
    color: #64748b;
    font-size: 12px;
    text-transform: uppercase;
    letter-spacing: 0.5px;
    padding: 14px 24px;
    border-bottom: 1px solid #edf2f7;
    font-weight: 600;
  }

  .dash_table td {
    padding: 16px 24px;
    border-bottom: 1px solid #f1f5f9;
    color: #334155;
    font-size: 14px;
    vertical-align: middle;
  }

  .status_badge {
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 12px;
    font-weight: 600;
    display: inline-block;
    text-transform: capitalize;
  }

  .status_pending {
    background: rgba(234, 179, 8, 0.15);
    color: #b45309;
  }

  .status_processing {
    background: rgba(59, 130, 246, 0.15);
    color: #1d4ed8;
  }

  .status_completed {
    background: rgba(34, 197, 94, 0.15);
    color: #15803d;
  }

  .status_cancelled {
    background: rgba(239, 68, 68, 0.15);
    color: #b91c1c;
  }

  .dash_label {
    font-size: 13px;
    font-weight: 600;
    color: #475569;
    margin-bottom: 6px;
    display: block;
  }

  .dash_input {
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 10px 14px;
    font-size: 14px;
  }

  .dash_input:focus {
    border-color: #b8935a;
    box-shadow: 0 0 0 3px rgba(184, 147, 90, 0.15);
    outline: none;
  }

  .dash_btn_primary {
    background: #b8935a;
    color: #fff;
    border: none;
    padding: 10px 28px;
    border-radius: 8px;
    font-weight: 600;
    font-size: 14px;
    transition: 0.2s;
  }

  .dash_btn_primary:hover {
    background: #9d7b42;
    color: #fff;
  }

  @media (max-width: 991px) {
    .dash_wrapper { flex-direction: column; }
    .dash_sidebar { width: 100%; padding: 20px; }
    .stat_cards { grid-template-columns: repeat(2, 1fr); }
    .dash_main { padding: 25px 20px; }
  }

  @media (max-width: 576px) {
    .stat_cards { grid-template-columns: 1fr; }
  }
</style>

<div class="dash_wrapper">

  <!-- Shared Sidebar -->
  <div class="dash_sidebar">
    <h4><i class="fa-solid fa-crown me-2"></i>My Account</h4>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <i class="fa-solid fa-gauge-high"></i> Dashboard
    </a>
    <a href="{{ route('shop') }}">
      <i class="fa-solid fa-bag-shopping"></i> Browse Shop
    </a>
    <a href="{{ route('cart.index') }}">
      <i class="fa-solid fa-cart-shopping"></i> My Cart ({{ count(session('cart', [])) }})
    </a>
    <a href="{{ route('wishlist.index') }}">
      <i class="fa-solid fa-heart"></i> My Wishlist ({{ count(session('wishlist', [])) }})
    </a>
    <a href="{{ route('dashboard') }}#ordersSection">
      <i class="fa-solid fa-box"></i> Order History
    </a>
    <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
      <i class="fa-solid fa-user"></i> Profile Info
    </a>
    <a href="{{ route('logout') }}" style="color:#ef4444; margin-top:20px;">
      <i class="fa-solid fa-arrow-right-from-bracket"></i> Log Out
    </a>
  </div>

  <!-- Main content area -->
  <div class="dash_main">
    @yield('dash_content')
  </div>

</div>

@endsection
