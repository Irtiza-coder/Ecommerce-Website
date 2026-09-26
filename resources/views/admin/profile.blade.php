@extends('Layout.admin')
@section('title', 'Admin Account & Password')

@section('content')

    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-2">
        <div>
            <h4 class="mb-1" style="font-weight:700;">Account Settings</h4>
            <p class="text-secondary mb-0" style="font-size:13px;">Manage your admin credentials, username, and change
                account password.</p>
        </div>
        <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary btn-sm" style="border-radius:8px;">
            <i class="fa-solid fa-arrow-left me-1"></i> Dashboard
        </a>
    </div>

    @if(session('message'))
        <div
            style="background:rgba(74,222,128,0.12);border:1px solid rgba(74,222,128,0.3);border-radius:8px;padding:14px 20px;margin-bottom:24px;color:#4ade80;font-size:14px;display:flex;align-items:center;gap:10px;">
            <i class="fa-solid fa-circle-check fa-lg"></i>
            <span>{{ session('message') }}</span>
        </div>
    @endif

    @if(session('error'))
        <div
            style="background:rgba(248,113,113,0.12);border:1px solid rgba(248,113,113,0.3);border-radius:8px;padding:14px 20px;margin-bottom:24px;color:#f87171;font-size:14px;display:flex;align-items:center;gap:10px;">
            <i class="fa-solid fa-triangle-exclamation fa-lg"></i>
            <span>{{ session('error') }}</span>
        </div>
    @endif

    @if($errors->any())
        <div
            style="background:rgba(248,113,113,0.12);border:1px solid rgba(248,113,113,0.3);border-radius:8px;padding:14px 20px;margin-bottom:24px;color:#f87171;font-size:14px;">
            <div style="font-weight:600;margin-bottom:6px;"><i class="fa-solid fa-circle-xmark me-2"></i>Please fix the
                following errors:</div>
            <ul class="mb-0 ps-3">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="row g-4">
        <!-- Left Column: Profile Card -->
        <div class="col-lg-4">
            <div class="admin_card text-center p-4">
                <div
                    style="width:84px;height:84px;border-radius:50%;background:var(--accent);color:#0f1115;display:inline-flex;align-items:center;justify-content:center;font-size:32px;font-weight:700;box-shadow:0 0 24px rgba(212,175,122,0.3);margin-bottom:16px;">
                    {{ strtoupper(substr($admin->username ?? 'A', 0, 1)) }}
                </div>
                <h5 style="font-weight:700;color:#fff;margin-bottom:4px;">{{ $admin->username }}</h5>
                <span class="badge"
                    style="background:rgba(212,175,122,0.15);color:var(--accent);border:1px solid rgba(212,175,122,0.3);font-size:12px;padding:5px 12px;border-radius:20px;">
                    <i class="fa-solid fa-shield-halved me-1"></i> Administrator
                </span>

                <hr style="border-color:var(--border-color);margin:20px 0;">

                <div style="text-align:left;font-size:13px;line-height:2.2;color:#cbd5e1;">
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary"><i class="fa-solid fa-id-badge me-2"></i>Admin ID:</span>
                        <strong>#{{ $admin->id }}</strong>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary"><i class="fa-regular fa-calendar-check me-2"></i>Account
                            Created:</span>
                        <span>{{ $admin->created_at ? $admin->created_at->format('M d, Y') : 'N/A' }}</span>
                    </div>
                    <div class="d-flex justify-content-between">
                        <span class="text-secondary"><i class="fa-solid fa-clock-rotate-left me-2"></i>Last Updated:</span>
                        <span>{{ $admin->updated_at ? $admin->updated_at->diffForHumans() : 'Recently' }}</span>
                    </div>
                </div>
            </div>

            <div class="admin_card p-3 mt-3" style="background:rgba(212,175,122,0.04);border-color:rgba(212,175,122,0.2);">
                <div style="font-size:13px;color:#cbd5e1;line-height:1.7;">
                    <strong style="color:var(--accent);display:block;margin-bottom:6px;">
                        <i class="fa-solid fa-lightbulb me-1"></i> Security Tip
                    </strong>
                    Use a password with at least 8 characters, combining uppercase and lowercase letters, numbers, and
                    symbols to keep your admin portal secure.
                </div>
            </div>
        </div>

        <!-- Right Column: Settings & Password Form -->
        <div class="col-lg-8">
            <form method="POST" action="{{ route('admin.profile.update') }}">
                @csrf

                <!-- Section 1: Username Settings -->
                <div class="admin_card mb-4">
                    <div class="admin_card_header d-flex align-items-center gap-2">
                        <i class="fa-solid fa-user-pen" style="color:var(--accent);"></i> Account Username
                    </div>
                    <div class="admin_card_body">
                        <div class="mb-3">
                            <label class="form-label" style="font-size:13px;font-weight:600;color:#cbd5e1;">Username</label>
                            <div class="input-group">
                                <span class="input-group-text"
                                    style="background:#1a1c23;border-color:var(--border-color);color:var(--text-muted);">
                                    <i class="fa-solid fa-user"></i>
                                </span>
                                <input type="text" name="username" class="form-control"
                                    value="{{ old('username', $admin->username) }}" required
                                    style="background:#12141a;border-color:var(--border-color);color:#fff;font-size:14px;padding:10px 14px;">
                            </div>
                            <small class="text-secondary" style="font-size:12px;">This is the username you use to log into
                                the admin dashboard.</small>
                        </div>
                    </div>
                </div>

                <!-- Section 2: Change Password -->
                <div class="admin_card mb-4">
                    <div class="admin_card_header d-flex align-items-center gap-2">
                        <i class="fa-solid fa-key" style="color:var(--accent);"></i> Change Password
                    </div>
                    <div class="admin_card_body">
                        <p class="text-secondary mb-3" style="font-size:13px;">Leave password fields empty if you only want
                            to update your username.</p>

                        <!-- Current Password -->
                        <div class="mb-3">
                            <label class="form-label" style="font-size:13px;font-weight:600;color:#cbd5e1;">Current
                                Password</label>
                            <div class="input-group">
                                <span class="input-group-text"
                                    style="background:#1a1c23;border-color:var(--border-color);color:var(--text-muted);">
                                    <i class="fa-solid fa-lock"></i>
                                </span>
                                <input type="password" name="current_password" id="current_password" class="form-control"
                                    placeholder="Enter your current password"
                                    style="background:#12141a;border-color:var(--border-color);color:#fff;font-size:14px;padding:10px 14px;">
                                <button type="button" class="btn btn-outline-secondary"
                                    onclick="togglePasswordVisibility('current_password', 'eye_current')"
                                    style="border-color:var(--border-color);background:#1a1c23;color:var(--text-muted);">
                                    <i class="fa-regular fa-eye" id="eye_current"></i>
                                </button>
                            </div>
                            <small class="text-secondary" style="font-size:12px;">Required only when changing
                                password.</small>
                        </div>

                        <div class="row g-3">
                            <!-- New Password -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-size:13px;font-weight:600;color:#cbd5e1;">New
                                    Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"
                                        style="background:#1a1c23;border-color:var(--border-color);color:var(--text-muted);">
                                        <i class="fa-solid fa-key"></i>
                                    </span>
                                    <input type="password" name="new_password" id="new_password" class="form-control"
                                        placeholder="Minimum 6 characters"
                                        style="background:#12141a;border-color:var(--border-color);color:#fff;font-size:14px;padding:10px 14px;">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePasswordVisibility('new_password', 'eye_new')"
                                        style="border-color:var(--border-color);background:#1a1c23;color:var(--text-muted);">
                                        <i class="fa-regular fa-eye" id="eye_new"></i>
                                    </button>
                                </div>
                            </div>

                            <!-- Confirm New Password -->
                            <div class="col-md-6 mb-3">
                                <label class="form-label" style="font-size:13px;font-weight:600;color:#cbd5e1;">Confirm New
                                    Password</label>
                                <div class="input-group">
                                    <span class="input-group-text"
                                        style="background:#1a1c23;border-color:var(--border-color);color:var(--text-muted);">
                                        <i class="fa-solid fa-check-double"></i>
                                    </span>
                                    <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                        class="form-control" placeholder="Repeat new password"
                                        style="background:#12141a;border-color:var(--border-color);color:#fff;font-size:14px;padding:10px 14px;">
                                    <button type="button" class="btn btn-outline-secondary"
                                        onclick="togglePasswordVisibility('new_password_confirmation', 'eye_confirm')"
                                        style="border-color:var(--border-color);background:#1a1c23;color:var(--text-muted);">
                                        <i class="fa-regular fa-eye" id="eye_confirm"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Save Button -->
                <div class="d-flex justify-content-end gap-3">
                    <a href="{{ route('admin.dashboard') }}" class="btn btn-outline-secondary"
                        style="border-radius:8px;padding:10px 20px;">
                        Cancel
                    </a>
                    <button type="submit" class="admin_btn_primary"
                        style="padding:10px 24px;border:none;cursor:pointer;border-radius:8px;font-size:14px;font-weight:600;display:inline-flex;align-items:center;gap:8px;">
                        <i class="fa-solid fa-floppy-disk"></i> Save Changes
                    </button>
                </div>
            </form>
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