@extends('Layout.dashboard')
@section('title', 'Profile & Password')

@section('dash_content')

<div class="dash_topbar">
  <div>
    <h2>Account Settings & Profile</h2>
    <p class="text-muted mb-0" style="font-size:14px;">Update your personal details, email address, or change your account password.</p>
  </div>
  <a href="{{ route('dashboard') }}" class="btn btn-sm btn-outline-secondary" style="border-radius:8px; padding:8px 18px; font-weight:600;">
    <i class="fa-solid fa-arrow-left me-1"></i> Back to Dashboard
  </a>
</div>

@if(session('message'))
  <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="background:#ecfdf5; border-color:#a7f3d0; color:#065f46; border-radius:10px; padding:16px 20px;">
    <i class="fa-solid fa-circle-check me-2" style="font-size:16px;"></i>
    <strong>Success!</strong> {{ session('message') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if(session('error'))
  <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius:10px;">
    <i class="fa-solid fa-circle-exclamation me-2"></i> {{ session('error') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

@if($errors->any())
  <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius:10px;">
    <div style="font-weight:600; margin-bottom:6px;"><i class="fa-solid fa-circle-xmark me-2"></i>Please fix the following errors:</div>
    <ul class="mb-0 ps-3">
      @foreach($errors->all() as $error)
        <li>{{ $error }}</li>
      @endforeach
    </ul>
    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
  </div>
@endif

<div class="row g-4">
  <!-- Left Side: Profile Summary Card -->
  <div class="col-lg-4">
    <div class="dash_card text-center p-4">
      <div style="width:84px; height:84px; border-radius:50%; background:#b8935a; color:#fff; display:inline-flex; align-items:center; justify-content:center; font-size:32px; font-weight:700; box-shadow:0 6px 20px rgba(184,147,90,0.3); margin-bottom:16px;">
        {{ strtoupper(substr($user->First_name ?? 'U', 0, 1)) }}
      </div>
      <h5 style="font-weight:700; color:#1e293b; margin-bottom:4px;">{{ $user->First_name }} {{ $user->Last_name }}</h5>
      <span class="badge" style="background:rgba(184,147,90,0.15); color:#b8935a; font-size:12px; padding:5px 14px; border-radius:20px;">
        <i class="fa-solid fa-user-check me-1"></i> Verified Customer
      </span>

      <hr style="border-color:#edf2f7; margin:22px 0;">

      <div style="text-align:left; font-size:13px; line-height:2.2; color:#64748b;">
        <div class="d-flex justify-content-between">
          <span><i class="fa-solid fa-envelope me-2"></i>Email:</span>
          <strong style="color:#1e293b;">{{ $user->email }}</strong>
        </div>
        <div class="d-flex justify-content-between">
          <span><i class="fa-regular fa-calendar-check me-2"></i>Member Since:</span>
          <span>{{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}</span>
        </div>
        <div class="d-flex justify-content-between">
          <span><i class="fa-solid fa-clock-rotate-left me-2"></i>Last Updated:</span>
          <span>{{ $user->updated_at ? $user->updated_at->diffForHumans() : 'Recently' }}</span>
        </div>
      </div>
    </div>

    <div class="dash_card p-3 mt-3" style="background:rgba(184,147,90,0.06); border-color:rgba(184,147,90,0.2);">
      <div style="font-size:13px; color:#475569; line-height:1.7;">
        <strong style="color:#b8935a; display:block; margin-bottom:6px;">
          <i class="fa-solid fa-shield-halved me-1"></i> Security Notice
        </strong>
        Keep your password confidential. If you ever suspect unusual activity, update your password right away.
      </div>
    </div>
  </div>

  <!-- Right Side: Edit Form -->
  <div class="col-lg-8">
    <div class="dash_card">
      <div class="dash_card_header">
        <span><i class="fa-solid fa-user-pen me-2" style="color:#b8935a;"></i> Edit Profile & Password</span>
      </div>
      <div class="dash_card_body" style="padding: 28px 30px;">
        <form action="{{ route('user.profile.update') }}" method="POST">
          @csrf

          <!-- Personal Details -->
          <h5 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:18px; padding-bottom:8px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-address-card me-2" style="color:#b8935a;"></i> Personal Information
          </h5>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="dash_label">First Name *</label>
              <input type="text" name="first_name" class="form-control dash_input" value="{{ old('first_name', $user->First_name) }}" required>
            </div>
            <div class="col-md-6">
              <label class="dash_label">Last Name *</label>
              <input type="text" name="last_name" class="form-control dash_input" value="{{ old('last_name', $user->Last_name) }}" required>
            </div>
            <div class="col-12">
              <label class="dash_label">Email Address *</label>
              <input type="email" name="email" class="form-control dash_input" value="{{ old('email', $user->email) }}" required>
              <small class="text-muted" style="font-size:12px;">This email is used to log in and receive order updates.</small>
            </div>
          </div>

          <!-- Change Password Section -->
          <h5 style="font-size:15px; font-weight:700; color:#1e293b; margin-bottom:6px; padding-bottom:8px; border-bottom:1px solid #f1f5f9;">
            <i class="fa-solid fa-key me-2" style="color:#b8935a;"></i> Change Password
          </h5>
          <p class="text-muted mb-3" style="font-size:13px;">Leave password fields blank if you only want to update your name or email.</p>

          <div class="mb-3">
            <label class="dash_label">Current Password</label>
            <div class="input-group">
              <input type="password" name="current_password" id="user_current_password" class="form-control dash_input" placeholder="Enter your current password">
              <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('user_current_password', 'eye_user_current')" style="border-color:#e2e8f0; background:#f8fafc;">
                <i class="fa-regular fa-eye" id="eye_user_current"></i>
              </button>
            </div>
            <small class="text-muted" style="font-size:12px;">Required only when setting a new password.</small>
          </div>

          <div class="row g-3 mb-4">
            <div class="col-md-6">
              <label class="dash_label">New Password</label>
              <div class="input-group">
                <input type="password" name="new_password" id="user_new_password" class="form-control dash_input" placeholder="Minimum 6 characters">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('user_new_password', 'eye_user_new')" style="border-color:#e2e8f0; background:#f8fafc;">
                  <i class="fa-regular fa-eye" id="eye_user_new"></i>
                </button>
              </div>
            </div>
            <div class="col-md-6">
              <label class="dash_label">Confirm New Password</label>
              <div class="input-group">
                <input type="password" name="new_password_confirmation" id="user_confirm_password" class="form-control dash_input" placeholder="Repeat new password">
                <button class="btn btn-outline-secondary" type="button" onclick="togglePasswordVisibility('user_confirm_password', 'eye_user_confirm')" style="border-color:#e2e8f0; background:#f8fafc;">
                  <i class="fa-regular fa-eye" id="eye_user_confirm"></i>
                </button>
              </div>
            </div>
          </div>

          <div class="d-flex justify-content-end gap-3">
            <a href="{{ route('dashboard') }}" class="btn btn-outline-secondary" style="border-radius:8px; padding:10px 22px;">
              Cancel
            </a>
            <button type="submit" class="dash_btn_primary" style="display:inline-flex; align-items:center; gap:8px;">
              <i class="fa-solid fa-floppy-disk"></i> Save Profile Changes
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>

<script>
function togglePasswordVisibility(fieldId, iconId) {
    const input = document.getElementById(fieldId);
    const icon = document.getElementById(iconId);
    if (!input || !icon) return;

    if (input.type === 'password') {
        input.type = 'text';
        icon.classList.remove('fa-eye');
        icon.classList.add('fa-eye-slash');
    } else {
        input.type = 'password';
        icon.classList.remove('fa-eye-slash');
        icon.classList.add('fa-eye');
    }
}
</script>

@endsection
