<!DOCTYPE html>
<html lang="en" dir="ltr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Kepabara</title>

    <link rel="icon" type="image/x-icon" href="{{ asset('sneat/img/favicon/favicon.ico') }}" />
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Syne:wght@400;600;700&family=DM+Sans:wght@300;400;500&display=swap" rel="stylesheet" />
    <link rel="stylesheet" href="{{ asset('sneat/vendor/fonts/boxicons.css') }}" />

    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        :root {
            --bg: #0f0f13;
            --surface: #18181f;
            --border: #2a2a35;
            --accent: #7c6af7;
            --accent-glow: rgba(124, 106, 247, 0.18);
            --text: #eeeef2;
            --muted: #7a7a90;
            --danger: #f87171;
        }

        body {
            background: var(--bg);
            color: var(--text);
            font-family: 'DM Sans', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 1rem;
        }

        .login-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 16px;
            width: 100%;
            max-width: 440px;
            overflow: hidden;
        }

        .login-banner {
            height: 80px;
            background: linear-gradient(135deg, #3b2fa0 0%, #7c6af7 60%, #a78bfa 100%);
            position: relative;
        }

        .login-banner::after {
            content: '';
            position: absolute;
            inset: 0;
            background: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.04'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");
        }

        .login-body { padding: 2rem; }

        .brand {
            font-family: 'Syne', sans-serif;
            font-size: 1.5rem;
            font-weight: 800;
            letter-spacing: 0.05em;
            color: var(--text);
            text-align: center;
            margin-bottom: 0.25rem;
        }

        .brand span { color: var(--accent); }

        .login-title {
            font-family: 'Syne', sans-serif;
            font-size: 1.1rem;
            font-weight: 700;
            color: var(--text);
            margin-bottom: 0.25rem;
        }

        .login-subtitle {
            color: var(--muted);
            font-size: 0.875rem;
            margin-bottom: 1.75rem;
        }

        .divider {
            border: none;
            border-top: 1px solid var(--border);
            margin: 1.5rem 0;
        }

        .form-group { margin-bottom: 1.25rem; }

        label {
            display: block;
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--muted);
            margin-bottom: 0.4rem;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            background: rgba(255,255,255,0.04);
            border: 1px solid var(--border);
            border-radius: 8px;
            padding: 0.65rem 0.9rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--text);
            outline: none;
            transition: border-color 0.15s, box-shadow 0.15s;
        }

        input[type="email"]:focus,
        input[type="password"]:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(124, 106, 247, 0.15);
        }

        input::placeholder { color: #3a3a4a; }

        .input-group {
            position: relative;
            display: flex;
        }

        .input-group input { border-radius: 8px; padding-right: 2.75rem; }

        .input-group .toggle-password {
            position: absolute;
            right: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            font-size: 1.1rem;
            padding: 0;
        }

        .is-invalid { border-color: var(--danger) !important; }
        .invalid-feedback { color: var(--danger); font-size: 0.78rem; margin-top: 0.35rem; display: block; }

        .forgot-link {
            font-size: 0.78rem;
            color: var(--accent);
            text-decoration: none;
        }

        .forgot-link:hover { text-decoration: underline; }

        .label-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 0.4rem;
        }

        .remember-row {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.25rem;
        }

        .remember-row input[type="checkbox"] {
            width: 16px;
            height: 16px;
            accent-color: var(--accent);
            cursor: pointer;
        }

        .remember-row label {
            font-size: 0.875rem;
            color: var(--muted);
            text-transform: none;
            letter-spacing: 0;
            margin: 0;
            cursor: pointer;
        }

        .btn-signin {
            width: 100%;
            background: var(--accent);
            color: #fff;
            border: none;
            border-radius: 8px;
            padding: 0.7rem;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.95rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.18s ease;
            margin-bottom: 1.25rem;
        }

        .btn-signin:hover {
            background: #6a58e5;
            transform: translateY(-1px);
            box-shadow: 0 4px 16px rgba(124, 106, 247, 0.4);
        }

        .register-text {
            text-align: center;
            font-size: 0.875rem;
            color: var(--muted);
        }

        .register-text a {
            color: var(--accent);
            text-decoration: none;
            font-weight: 500;
        }

        .register-text a:hover { text-decoration: underline; }
    </style>
</head>
<body>

    <div class="login-card">
        <div class="login-banner"></div>

        <div class="login-body">
            <div class="brand">KEPA<span>BARA</span></div>

            <hr class="divider">

            <div class="login-title">Welcome back! 👋</div>
            <div class="login-subtitle">Please sign in to your account</div>

            <form method="POST" action="{{ route('login') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                           value="{{ old('email') }}"
                           placeholder="Enter your email"
                           class="{{ $errors->has('email') ? 'is-invalid' : '' }}"
                           autofocus />
                    @error('email')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <div class="label-row">
                        <label for="password">Password</label>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="forgot-link">Forgot Password?</a>
                        @endif
                    </div>
                    <div class="input-group">
                        <input type="password" id="password" name="password"
                               placeholder="············"
                               class="{{ $errors->has('password') ? 'is-invalid' : '' }}" />
                        <button type="button" class="toggle-password" onclick="togglePassword()">
                            <i class="bx bx-hide" id="toggle-icon"></i>
                        </button>
                    </div>
                    @error('password')
                        <span class="invalid-feedback">{{ $message }}</span>
                    @enderror
                </div>

                <div class="remember-row">
                    <input type="checkbox" id="remember" name="remember" {{ old('remember') ? 'checked' : '' }} />
                    <label for="remember">Remember Me</label>
                </div>

                <button type="submit" class="btn-signin">Sign In</button>

                @if (Route::has('register'))
                    <p class="register-text">
                        New on our platform?
                        <a href="{{ route('register') }}">Create an account</a>
                    </p>
                @endif
            </form>
        </div>
    </div>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const icon = document.getElementById('toggle-icon');
            if (input.type === 'password') {
                input.type = 'text';
                icon.classList.replace('bx-hide', 'bx-show');
            } else {
                input.type = 'password';
                icon.classList.replace('bx-show', 'bx-hide');
            }
        }
    </script>

</body>
</html>