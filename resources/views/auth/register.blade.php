<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Inkraft • Create Account</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f7f9fc; }
        .auth-wrapper { display: flex; min-height: 100vh; width: 100%; background: #fff; }

        /* ── Brand Panel ── */
        .brand-panel {
            flex: 1.1;
            background: linear-gradient(145deg, #0b1120 0%, #0f172a 100%);
            color: white;
            padding: 3rem 2.5rem;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            position: relative;
            overflow: hidden;
        }
        .brand-panel::before {
            content: "";
            position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(circle at 20% 40%, rgba(255,255,255,0.03) 2%, transparent 2.5%);
            background-size: 32px 32px;
            pointer-events: none;
        }
        .logo-area { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.8rem; z-index: 2; }
        .logo-icon {
            background: #4f46e5; width: 38px; height: 38px; border-radius: 12px;
            display: inline-flex; align-items: center; justify-content: center;
            font-weight: 800; font-size: 1.5rem; box-shadow: 0 8px 20px rgba(79,70,229,0.3);
        }
        .brand-tagline { margin-top: 2rem; max-width: 90%; }
        .brand-tagline h1 {
            font-size: 3.2rem; font-weight: 700; line-height: 1.2;
            background: linear-gradient(135deg, #FFFFFF 70%, #a78bfa 100%);
            -webkit-background-clip: text; background-clip: text; color: transparent;
            margin-bottom: 1.2rem;
        }
        .feature-chip {
            background: rgba(255,255,255,0.08); backdrop-filter: blur(4px);
            border-radius: 40px; padding: 0.5rem 1rem; font-size: 0.85rem;
            display: inline-flex; align-items: center; gap: 8px;
            border: 1px solid rgba(255,255,255,0.15);
        }
        .steps-list { margin-top: 2rem; display: flex; flex-direction: column; gap: 1rem; }
        .step-item {
            display: flex; align-items: flex-start; gap: 12px;
            background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);
            border-radius: 16px; padding: 0.9rem 1rem;
        }
        .step-icon {
            background: #4f46e5; width: 32px; height: 32px; border-radius: 10px;
            display: flex; align-items: center; justify-content: center; flex-shrink: 0;
            font-size: 0.9rem;
        }
        .step-text strong { display: block; font-size: 0.88rem; font-weight: 600; }
        .step-text span { font-size: 0.78rem; opacity: 0.65; }

        /* ── Form Panel ── */
        .form-panel { flex: 0.9; display: flex; align-items: center; justify-content: center; background: #fff; padding: 2rem; }
        .login-card {
            max-width: 440px; width: 100%; background: white; border-radius: 32px;
            padding: 2rem 1.8rem; box-shadow: 0 25px 45px -12px rgba(0,0,0,0.1);
        }
        .login-header { margin-bottom: 1.6rem; }
        .login-header h2 { font-weight: 700; font-size: 1.8rem; color: #0f172a; }
        .login-header p { color: #5b6e8c; font-size: 0.9rem; }
        .input-label { font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block; color: #1e293b; }
        .input-icon { position: relative; }
        .input-icon i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .form-control-custom {
            width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem;
            border-radius: 18px; border: 1.5px solid #e2e8f0;
            font-size: 0.95rem; transition: 0.2s; outline: none; font-family: 'Inter', sans-serif;
        }
        .form-control-custom:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.2); }
        .btn-login {
            background: #0f172a; border: none; padding: 0.85rem; font-weight: 600;
            border-radius: 40px; width: 100%; color: white; transition: 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            font-family: 'Inter', sans-serif; font-size: 0.95rem; cursor: pointer;
        }
        .btn-login:hover { background: #1e293b; transform: translateY(-2px); }
        .signup-redirect { text-align: center; margin-top: 1.5rem; font-size: 0.85rem; color: #5b6e8c; }
        .signup-redirect a { font-weight: 700; color: #4f46e5; text-decoration: none; }

        @media (max-width: 850px) {
            .auth-wrapper { flex-direction: column; }
            .brand-tagline h1 { font-size: 2.3rem; }
        }
    </style>
</head>
<body>
<div class="auth-wrapper">

    <!-- Brand Panel -->
    <div class="brand-panel">
        <div>
            <div class="logo-area"><div class="logo-icon">✧</div><span>Inkraft</span></div>
            <div class="brand-tagline">
                <h1>Your AI content studio.</h1>
                <p style="opacity:0.8; margin-bottom:1rem;">Join thousands of creators who ship content faster with Inkraft.</p>
                <div class="feature-chip"><i class="bi bi-stars"></i> Free to get started — no card needed</div>
                <div class="steps-list">
                    <div class="step-item">
                        <div class="step-icon"><i class="bi bi-person-plus-fill"></i></div>
                        <div class="step-text"><strong>Create your account</strong><span>Takes less than 60 seconds</span></div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon"><i class="bi bi-lightning-charge-fill"></i></div>
                        <div class="step-text"><strong>Pick a template</strong><span>Blogs, emails, ads & more</span></div>
                    </div>
                    <div class="step-item">
                        <div class="step-icon"><i class="bi bi-send-fill"></i></div>
                        <div class="step-text"><strong>Generate & publish</strong><span>AI-crafted content, instantly</span></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Form Panel -->
    <div class="form-panel">
        <div class="login-card">
            <div class="login-header">
                <h2>Create account</h2>
                <p>Start generating content with Inkraft AI — free.</p>
            </div>

            <form method="POST" action="{{ route('register') }}">
                @csrf

                <!-- Name -->
                <div class="mb-3">
                    <label class="input-label" for="name">Full name</label>
                    <div class="input-icon">
                        <i class="bi bi-person-fill"></i>
                        <input type="text" id="name" name="name"
                               class="form-control-custom @error('name') is-invalid @enderror"
                               value="{{ old('name') }}" required autofocus autocomplete="name"
                               placeholder="Jane Smith">
                    </div>
                    @error('name') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Email -->
                <div class="mb-3">
                    <label class="input-label" for="email">Email address</label>
                    <div class="input-icon">
                        <i class="bi bi-envelope-fill"></i>
                        <input type="email" id="email" name="email"
                               class="form-control-custom @error('email') is-invalid @enderror"
                               value="{{ old('email') }}" required autocomplete="username"
                               placeholder="jane@example.com">
                    </div>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="input-label" for="password">Password</label>
                    <div class="input-icon">
                        <i class="bi bi-lock-fill"></i>
                        <input type="password" id="password" name="password"
                               class="form-control-custom @error('password') is-invalid @enderror"
                               required autocomplete="new-password" placeholder="Min. 8 characters">
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Confirm Password -->
                <div class="mb-4">
                    <label class="input-label" for="password_confirmation">Confirm password</label>
                    <div class="input-icon">
                        <i class="bi bi-shield-lock-fill"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control-custom"
                               required autocomplete="new-password" placeholder="Re-enter password">
                    </div>
                    @error('password_confirmation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-rocket-takeoff-fill"></i> Create free account
                </button>

                <div class="signup-redirect">
                    Already have an account? <a href="{{ route('login') }}">Sign in</a>
                </div>
            </form>
        </div>
    </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>