@extends('Layout.main')
@section("content")

<style>
/* ═══════════════════════════════════════════════════════════════
   CREST & CLOVE — BESPOKE USER DASHBOARD
   Artisanal Warm Sand & Gold Light Theme
   Fluid Keyframe Animations, Micro-Interactions & Crafted Polish
   ═══════════════════════════════════════════════════════════════ */
@import url('https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,300;0,400;0,500;0,600;0,700;0,800;1,400;1,600&family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&display=swap');

:root {
  --u-gold:         #b8935a;
  --u-gold-hover:   #9e7436;
  --u-gold-light:   #d4b278;
  --u-gold-subtle:  rgba(184, 147, 90, 0.10);
  --u-gold-glow:    rgba(184, 147, 90, 0.22);
  
  --u-bg:           #f8f6f0;
  --u-surface:      #ffffff;
  --u-surface-subtle: #faf8f4;
  --u-border:       #eae3d5;
  --u-border-subtle: #f3ede2;
  --u-border-gold:  rgba(184, 147, 90, 0.32);

  --u-text-main:    #1c1917;
  --u-text-sub:     #4c443b;
  --u-text-muted:   #7d7467;

  --u-success:      #15803d;
  --u-success-bg:   #ecfdf5;
  --u-success-border: #a7f3d0;
  --u-warning:      #b45309;
  --u-warning-bg:   #fffbeb;
  --u-warning-border: #fde68a;
  --u-danger:       #b91c1c;
  --u-danger-bg:    #fef2f2;
  --u-danger-border: #fecaca;
  --u-info:         #0369a1;
  --u-info-bg:      #f0f9ff;
  --u-info-border:  #bae6fd;

  --u-radius-sm:    8px;
  --u-radius-md:    12px;
  --u-radius-lg:    16px;
  --u-shadow-sm:    0 1px 3px rgba(44, 38, 30, 0.04), 0 1px 2px rgba(44, 38, 30, 0.02);
  --u-shadow-md:    0 4px 16px -2px rgba(44, 38, 30, 0.05), 0 2px 6px -1px rgba(44, 38, 30, 0.03);
  --u-shadow-lg:    0 12px 30px -4px rgba(44, 38, 30, 0.08);
  --u-shadow-hover: 0 16px 36px -6px rgba(184, 147, 90, 0.16), 0 4px 12px rgba(44, 38, 30, 0.04);
  --u-transition:   all 0.26s cubic-bezier(0.2, 0.8, 0.2, 1);
}

.dash_wrapper {
  display: flex;
  min-height: 85vh;
  background-color: var(--u-bg);
  font-family: 'Plus Jakarta Sans', -apple-system, BlinkMacSystemFont, sans-serif;
  padding: 32px 28px 60px;
  gap: 28px;
  max-width: 1440px;
  margin: 0 auto;
}

/* ══════════════════════════════════════
   USER DASHBOARD SIDEBAR (Warm Luxury)
══════════════════════════════════════ */
.dash_sidebar {
  width: 280px;
  background: var(--u-surface);
  border: 1px solid var(--u-border);
  border-radius: var(--u-radius-lg);
  padding: 24px 18px;
  flex-shrink: 0;
  box-shadow: var(--u-shadow-sm);
  display: flex;
  flex-direction: column;
  height: fit-content;
  position: sticky;
  top: 90px;
  transition: var(--u-transition);
}

.dash_sidebar:hover {
  box-shadow: var(--u-shadow-md);
  border-color: rgba(184, 147, 90, 0.28);
}

/* User Card / Header inside Sidebar */
.dash_user_chip {
  display: flex;
  align-items: center;
  gap: 12px;
  padding: 12px 14px;
  background: linear-gradient(135deg, #faf8f3 0%, #f4ede0 100%);
  border: 1px solid var(--u-border);
  border-radius: var(--u-radius-md);
  margin-bottom: 22px;
}

.dash_user_avatar {
  width: 44px;
  height: 44px;
  border-radius: 50%;
  background: linear-gradient(135deg, #d4b278 0%, #b8935a 100%);
  color: #ffffff;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 17px;
  font-weight: 700;
  box-shadow: 0 4px 12px rgba(184, 147, 90, 0.28);
  flex-shrink: 0;
}

.dash_user_info {
  min-width: 0;
}

.dash_user_info h5 {
  font-size: 14.5px;
  font-weight: 700;
  color: var(--u-text-main);
  margin: 0 0 2px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
}

.dash_user_status {
  font-size: 11px;
  font-weight: 600;
  color: #15803d;
  display: flex;
  align-items: center;
  gap: 5px;
}

.dash_status_beacon {
  width: 7px;
  height: 7px;
  border-radius: 50%;
  background: #10b981;
  display: inline-block;
  box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.4);
  animation: userBeaconPulse 2s infinite;
}

@keyframes userBeaconPulse {
  0% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0.5); }
  70% { box-shadow: 0 0 0 6px rgba(16, 185, 129, 0); }
  100% { box-shadow: 0 0 0 0 rgba(16, 185, 129, 0); }
}

.dash_sidebar_heading {
  font-size: 10.5px;
  font-weight: 800;
  text-transform: uppercase;
  letter-spacing: 0.1em;
  color: #928a7c;
  padding: 0 10px 8px;
  margin-bottom: 4px;
}

/* Sidebar Links */
.dash_sidebar a {
  display: flex;
  align-items: center;
  justify-content: space-between;
  color: var(--u-text-sub);
  text-decoration: none;
  padding: 10px 14px;
  border-radius: var(--u-radius-md);
  margin-bottom: 4px;
  font-size: 13.5px;
  font-weight: 600;
  border: 1px solid transparent;
  transition: var(--u-transition);
  position: relative;
}

.dash_sidebar a .dash_link_left {
  display: flex;
  align-items: center;
  gap: 12px;
}

.dash_sidebar a .dash_link_left i {
  font-size: 15px;
  width: 18px;
  text-align: center;
  color: #8c8273;
  transition: var(--u-transition);
}

.dash_sidebar a:hover {
  background: #faf8f3;
  color: var(--u-gold-hover);
  border-color: rgba(184, 147, 90, 0.16);
  transform: translateX(4px);
}

.dash_sidebar a:hover .dash_link_left i {
  color: var(--u-gold);
  transform: scale(1.12);
}

.dash_sidebar a.active {
  background: linear-gradient(135deg, rgba(184, 147, 90, 0.12) 0%, rgba(184, 147, 90, 0.05) 100%);
  color: var(--u-gold-hover);
  font-weight: 700;
  border: 1px solid rgba(184, 147, 90, 0.28);
  box-shadow: 0 2px 8px rgba(184, 147, 90, 0.08);
}

.dash_sidebar a.active .dash_link_left i {
  color: var(--u-gold);
}

.dash_sidebar a.active::before {
  content: '';
  position: absolute;
  left: -2px;
  top: 22%;
  bottom: 22%;
  width: 3.5px;
  border-radius: 99px;
  background: var(--u-gold);
}

/* Sidebar Counter Badges */
.dash_counter_badge {
  font-size: 11px;
  font-weight: 700;
  padding: 2px 8px;
  border-radius: 99px;
  background: var(--u-gold-subtle);
  color: var(--u-gold-hover);
  border: 1px solid rgba(184, 147, 90, 0.2);
}

.dash_sidebar a:hover .dash_counter_badge {
  background: var(--u-gold);
  color: #ffffff;
}

/* ══════════════════════════════════════
   MAIN CONTENT AREA
══════════════════════════════════════ */
.dash_main {
  flex: 1;
  min-width: 0;
  animation: userFadeUp 0.45s cubic-bezier(0.16, 1, 0.3, 1) both;
}

@keyframes userFadeUp {
  0% {
    opacity: 0;
    transform: translateY(14px);
  }
  100% {
    opacity: 1;
    transform: translateY(0);
  }
}

.dash_topbar {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 24px;
  flex-wrap: wrap;
  gap: 16px;
  background: var(--u-surface);
  border: 1px solid var(--u-border);
  border-radius: var(--u-radius-lg);
  padding: 22px 28px;
  box-shadow: var(--u-shadow-sm);
  position: relative;
  overflow: hidden;
}

.dash_topbar::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, #b8935a 0%, #d4b278 50%, #9e7436 100%);
}

.dash_topbar h2 {
  font-family: 'Plus Jakarta Sans', sans-serif;
  font-size: 22px;
  font-weight: 800;
  color: var(--u-text-main);
  margin: 0 0 4px;
  letter-spacing: -0.025em;
}

.dash_topbar p {
  color: var(--u-text-muted);
  font-size: 13.5px;
  margin: 0;
}

.dash_topbar .btn-logout {
  background: #ffffff;
  border: 1px solid #fecaca;
  color: #dc2626;
  padding: 8px 18px;
  border-radius: 99px;
  font-size: 13px;
  font-weight: 600;
  text-decoration: none;
  box-shadow: var(--u-shadow-sm);
  transition: var(--u-transition);
  display: inline-flex;
  align-items: center;
  gap: 7px;
}

.dash_topbar .btn-logout:hover {
  background: #dc2626;
  color: #ffffff;
  border-color: #dc2626;
  box-shadow: 0 4px 12px rgba(220, 38, 38, 0.22);
  transform: translateY(-1px);
}

/* ══════════════════════════════════════
   STAT METRIC CARDS
══════════════════════════════════════ */
.stat_cards {
  display: grid;
  grid-template-columns: repeat(4, 1fr);
  gap: 20px;
  margin-bottom: 28px;
}

.stat_card {
  background: var(--u-surface);
  border-radius: var(--u-radius-md);
  padding: 22px;
  box-shadow: var(--u-shadow-sm);
  border: 1px solid var(--u-border);
  transition: var(--u-transition);
  position: relative;
  overflow: hidden;
  display: flex;
  flex-direction: column;
}

.stat_card::before {
  content: '';
  position: absolute;
  top: 0; left: 0; right: 0;
  height: 3px;
  background: linear-gradient(90deg, #b8935a, #d4b278);
  opacity: 0.35;
  transition: opacity 0.3s ease, height 0.3s ease;
}

.stat_card:hover {
  transform: translateY(-4px);
  border-color: var(--u-border-gold);
  box-shadow: var(--u-shadow-hover);
}

.stat_card:hover::before {
  opacity: 1;
  height: 4px;
}

.stat_card_icon {
  width: 42px;
  height: 42px;
  border-radius: 12px;
  background: linear-gradient(135deg, rgba(184, 147, 90, 0.12) 0%, rgba(184, 147, 90, 0.04) 100%);
  border: 1px solid rgba(184, 147, 90, 0.22);
  display: flex;
  align-items: center;
  justify-content: center;
  color: var(--u-gold);
  font-size: 17px;
  margin-bottom: 14px;
  transition: var(--u-transition);
}

.stat_card:hover .stat_card_icon {
  background: var(--u-gold);
  color: #ffffff;
  transform: rotate(6deg) scale(1.08);
  box-shadow: 0 4px 14px rgba(184, 147, 90, 0.3);
}

.stat_card h5 {
  font-size: 11.5px;
  text-transform: uppercase;
  color: var(--u-text-muted);
  letter-spacing: 0.08em;
  margin-bottom: 8px;
  font-weight: 700;
}

.stat_card .stat_value {
  font-size: 26px;
  font-weight: 800;
  color: var(--u-text-main);
  line-height: 1.15;
  letter-spacing: -0.025em;
  margin-top: auto;
}

/* ══════════════════════════════════════
   CARD SURFACES & RECENT ORDERS TABLE
══════════════════════════════════════ */
.dash_card {
  background: var(--u-surface);
  border-radius: var(--u-radius-lg);
  box-shadow: var(--u-shadow-sm);
  border: 1px solid var(--u-border);
  overflow: hidden;
  margin-bottom: 24px;
  transition: var(--u-transition);
}

.dash_card:hover {
  box-shadow: var(--u-shadow-md);
  border-color: rgba(184, 147, 90, 0.28);
}

.dash_card_header {
  padding: 18px 24px;
  border-bottom: 1px solid var(--u-border-subtle);
  font-weight: 700;
  color: var(--u-text-main);
  font-size: 16px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  background: #ffffff;
}

.dash_card_body {
  padding: 0;
}

.dash_table {
  width: 100%;
  margin: 0;
  border-collapse: separate;
  border-spacing: 0;
}

.dash_table th {
  background: #faf8f3;
  color: #7d7467;
  font-size: 11px;
  text-transform: uppercase;
  letter-spacing: 0.08em;
  padding: 13px 20px;
  border-bottom: 1px solid var(--u-border);
  font-weight: 800;
  white-space: nowrap;
}

.dash_table td {
  padding: 14px 20px;
  border-bottom: 1px solid var(--u-border-subtle);
  color: var(--u-text-sub);
  font-size: 13.5px;
  vertical-align: middle;
  transition: background 0.18s ease;
}

.dash_table tbody tr:hover td {
  background: #faf8f2;
  color: var(--u-text-main);
}

.dash_table tbody tr:last-child td {
  border-bottom: none;
}

/* Status Badges */
.status_badge {
  display: inline-flex;
  align-items: center;
  gap: 5px;
  padding: 4px 12px;
  border-radius: 99px;
  font-size: 12px;
  font-weight: 700;
  text-transform: capitalize;
  letter-spacing: 0.02em;
}

.status_pending {
  background: #fffbeb;
  color: #b45309;
  border: 1px solid #fde68a;
}

.status_processing {
  background: #eff6ff;
  color: #1d4ed8;
  border: 1px solid #bfdbfe;
}

.status_completed {
  background: #ecfdf5;
  color: #15803d;
  border: 1px solid #a7f3d0;
}

.status_cancelled {
  background: #fef2f2;
  color: #b91c1c;
  border: 1px solid #fecaca;
}

/* Form Controls */
.dash_label {
  font-size: 13px;
  font-weight: 700;
  color: var(--u-text-sub);
  margin-bottom: 6px;
  display: block;
}

.dash_input {
  border: 1px solid var(--u-border);
  border-radius: var(--u-radius-md);
  padding: 10px 14px;
  font-size: 13.5px;
  width: 100%;
  background: #ffffff;
  color: var(--u-text-main);
  transition: var(--u-transition);
}

.dash_input:focus {
  border-color: var(--u-gold);
  box-shadow: 0 0 0 3.5px rgba(184, 147, 90, 0.18);
  outline: none;
}

.dash_btn_primary {
  display: inline-flex;
  align-items: center;
  gap: 8px;
  background: linear-gradient(135deg, #c8a96e 0%, #b8935a 50%, #9e7436 100%);
  color: #ffffff !important;
  border: 1px solid rgba(184, 147, 90, 0.4);
  padding: 10px 24px;
  border-radius: var(--u-radius-md);
  font-weight: 700;
  font-size: 13.5px;
  box-shadow: 0 4px 14px rgba(184, 147, 90, 0.28);
  transition: var(--u-transition);
  cursor: pointer;
  text-decoration: none;
}

.dash_btn_primary:hover {
  background: linear-gradient(135deg, #d4b278 0%, #a07840 50%, #8c642e 100%);
  box-shadow: 0 6px 20px rgba(184, 147, 90, 0.38);
  transform: translateY(-2px);
  color: #ffffff !important;
}

.dash_btn_primary:active {
  transform: translateY(0) scale(0.98);
}

/* ══════════════════════════════════════
   RESPONSIVE DESIGN BREAKPOINTS
══════════════════════════════════════ */
@media (max-width: 991px) {
  .dash_wrapper {
    flex-direction: column;
    padding: 20px 16px 40px;
    gap: 20px;
  }
  .dash_sidebar {
    width: 100%;
    position: static;
  }
  .stat_cards {
    grid-template-columns: repeat(2, 1fr);
  }
}

@media (max-width: 576px) {
  .stat_cards {
    grid-template-columns: 1fr;
  }
  .dash_topbar {
    padding: 18px 20px;
  }
  .dash_topbar h2 {
    font-size: 19px;
  }
}
</style>

<div class="dash_wrapper">

  <!-- Shared Sidebar -->
  <aside class="dash_sidebar">
    <!-- User Profile Chip -->
    <div class="dash_user_chip">
      <div class="dash_user_avatar">
        {{ strtoupper(substr(session('user_name', 'U'), 0, 1)) }}
      </div>
      <div class="dash_user_info">
        <h5>{{ session('user_name', 'Customer') }}</h5>
        <div class="dash_user_status">
          <span class="dash_status_beacon"></span> Verified Member
        </div>
      </div>
    </div>

    <div class="dash_sidebar_heading">Navigation</div>
    <a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
      <div class="dash_link_left">
        <i class="fa-solid fa-gauge-high"></i>
        <span>Dashboard</span>
      </div>
    </a>
    <a href="{{ route('shop') }}">
      <div class="dash_link_left">
        <i class="fa-solid fa-bag-shopping"></i>
        <span>Browse Catalog</span>
      </div>
    </a>
    <a href="{{ route('cart.index') }}">
      <div class="dash_link_left">
        <i class="fa-solid fa-cart-shopping"></i>
        <span>My Cart</span>
      </div>
      <span class="dash_counter_badge">{{ count(session('cart', [])) }}</span>
    </a>
    <a href="{{ route('wishlist.index') }}">
      <div class="dash_link_left">
        <i class="fa-solid fa-heart"></i>
        <span>My Wishlist</span>
      </div>
      <span class="dash_counter_badge">{{ count(session('wishlist', [])) }}</span>
    </a>
    <a href="{{ route('dashboard') }}#ordersSection">
      <div class="dash_link_left">
        <i class="fa-solid fa-box-open"></i>
        <span>Order History</span>
      </div>
    </a>
    <a href="{{ route('user.profile') }}" class="{{ request()->routeIs('user.profile') ? 'active' : '' }}">
      <div class="dash_link_left">
        <i class="fa-solid fa-user-gear"></i>
        <span>Profile Settings</span>
      </div>
    </a>

    <div class="dash_sidebar_heading" style="margin-top:20px;">Session</div>
    <a href="{{ route('logout') }}" style="color:#dc2626;">
      <div class="dash_link_left">
        <i class="fa-solid fa-arrow-right-from-bracket" style="color:#dc2626;"></i>
        <span>Sign Out</span>
      </div>
    </a>
  </aside>

  <!-- Main Content Area -->
  <main class="dash_main">
    @yield('dash_content')
  </main>

</div>

@endsection
