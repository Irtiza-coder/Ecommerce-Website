<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Portal Login | Crest & Clove</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body class="admin_login_page">

    <div class="admin_login_card">
        <div class="admin_login_card_glow"></div>

        <div class="admin_login_status_strip">
            <span class="status_live_pill">
                <span class="status_live_dot"></span>
                Secure System Active
            </span>
            <span>v2.4 • SSL Encrypted</span>
        </div>

        <div class="admin_login_body">
            <div class="admin_login_brand">
                <div class="admin_login_crest">
                    <i class="fa-solid fa-crown"></i>
                </div>
                <h1>Crest <span>&amp;</span> Clove</h1>
                <p>Enter your administrative credentials to continue</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger mb-4" role="alert">
                    <i class="fa-solid fa-circle-exclamation fs-5 flex-shrink-0"></i>
                    <div>{{ session('error') }}</div>
                </div>
            @endif

            @if($errors->any())
                <div class="alert alert-danger mb-4" role="alert">
                    <i class="fa-solid fa-circle-exclamation fs-5 flex-shrink-0"></i>
                    <div>{{ $errors->first() }}</div>
                </div>
            @endif

            <form method="POST" action="{{ route('admin.login') }}">
                @csrf

                <div class="admin_input_group">
                    <label for="username">Admin Username</label>
                    <div class="admin_input_wrapper">
                        <i class="fa-solid fa-user admin_input_icon"></i>
                        <input type="text" id="username" name="username" autocomplete="username" 
                               value="{{ old('username') }}" placeholder="e.g. admin" required autofocus>
                    </div>
                </div>

                <div class="admin_input_group">
                    <label for="password">Security Password</label>
                    <div class="admin_input_wrapper">
                        <i class="fa-solid fa-lock admin_input_icon"></i>
                        <input type="password" id="password" name="password" autocomplete="current-password" 
                               placeholder="••••••••" required>
                        <button type="button" class="btn_toggle_password" id="togglePasswordBtn" 
                                onclick="togglePasswordVisibility()" aria-label="Toggle password visibility">
                            <i class="fa-regular fa-eye" id="togglePasswordIcon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn_admin_submit">
                    <span>Access Dashboard</span>
                    <i class="fa-solid fa-arrow-right"></i>
                </button>
            </form>

            <div class="admin_login_footer">
                <a href="{{ url('/') }}" title="Return to Storefront">
                    <i class="fa-solid fa-arrow-left"></i>
                    <span>Back to Storefront</span>
                </a>
                <span style="color: var(--text-muted); font-size: 11.5px;">Crest &amp; Clove Admin</span>
            </div>
        </div>
    </div>

    <script>
        function togglePasswordVisibility() {
            const pwdInput = document.getElementById('password');
            const icon = document.getElementById('togglePasswordIcon');
            if (!pwdInput) return;
            
            if (pwdInput.type === 'password') {
                pwdInput.type = 'text';
                icon.classList.remove('fa-eye');
                icon.classList.add('fa-eye-slash');
            } else {
                pwdInput.type = 'password';
                icon.classList.remove('fa-eye-slash');
                icon.classList.add('fa-eye');
            }
        }
    </script>

</body>
</html>