<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Inkraft • Login</title>
    <!-- Bootstrap 5 + Icons + Google Fonts -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Inter:opsz,wght@14..32,300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: 'Inter', sans-serif; background: #f7f9fc; }
        .auth-wrapper { display: flex; min-height: 100vh; width: 100%; background: #fff; }
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
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: radial-gradient(circle at 20% 40%, rgba(255,255,255,0.03) 2%, transparent 2.5%);
            background-size: 32px 32px;
            pointer-events: none;
        }
        .logo-area { display: flex; align-items: center; gap: 10px; font-weight: 700; font-size: 1.8rem; z-index: 2; }
        .logo-icon { background: #4f46e5; width: 38px; height: 38px; border-radius: 12px; display: inline-flex; align-items: center; justify-content: center; font-weight: 800; font-size: 1.5rem; box-shadow: 0 8px 20px rgba(79,70,229,0.3); }
        .brand-tagline { margin-top: 2rem; max-width: 90%; }
        .brand-tagline h1 { font-size: 3.2rem; font-weight: 700; line-height: 1.2; background: linear-gradient(135deg, #FFFFFF 70%, #a78bfa 100%); -webkit-background-clip: text; background-clip: text; color: transparent; margin-bottom: 1.2rem; }
        .feature-chip { background: rgba(255,255,255,0.08); backdrop-filter: blur(4px); border-radius: 40px; padding: 0.5rem 1rem; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 8px; border: 1px solid rgba(255,255,255,0.15); }
        .demo-card { background: rgba(255,255,255,0.05); border-radius: 24px; padding: 1.2rem; margin-top: 2rem; border: 1px solid rgba(255,255,255,0.1); }
        .demo-card .content-preview { background: #00000030; padding: 0.75rem; border-radius: 16px; margin-top: 10px; border-left: 3px solid #4f46e5; font-size: 0.85rem; }
        .form-panel { flex: 0.9; display: flex; align-items: center; justify-content: center; background: #fff; padding: 2rem; }
        .login-card { max-width: 440px; width: 100%; background: white; border-radius: 32px; padding: 2rem 1.8rem; box-shadow: 0 25px 45px -12px rgba(0,0,0,0.1); }
        .login-header { margin-bottom: 2rem; }
        .login-header h2 { font-weight: 700; font-size: 1.8rem; color: #0f172a; }
        .login-header p { color: #5b6e8c; font-size: 0.9rem; }
        .input-label { font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block; color: #1e293b; }
        .input-icon { position: relative; }
        .input-icon i { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .form-control-custom { width: 100%; padding: 0.85rem 1rem 0.85rem 2.8rem; border-radius: 18px; border: 1.5px solid #e2e8f0; font-size: 0.95rem; transition: 0.2s; outline: none; }
        .form-control-custom:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.2); }
        .btn-login { background: #0f172a; border: none; padding: 0.85rem; font-weight: 600; border-radius: 40px; width: 100%; color: white; transition: 0.2s; display: flex; align-items: center; justify-content: center; gap: 10px; }
        .btn-login:hover { background: #1e293b; transform: translateY(-2px); }
        .forgot-link { font-size: 0.85rem; text-decoration: none; font-weight: 500; color: #4f46e5; }
        .checkbox-custom { display: flex; align-items: center; gap: 8px; font-size: 0.85rem; }
        .checkbox-custom input { width: 18px; height: 18px; accent-color: #4f46e5; }
        .remember-forgot { display: flex; justify-content: space-between; align-items: center; margin: 1rem 0 1.5rem; }
        .signup-redirect { text-align: center; margin-top: 2rem; font-size: 0.85rem; }
        .signup-redirect a { font-weight: 700; color: #4f46e5; text-decoration: none; }
        @media (max-width: 850px) { .auth-wrapper { flex-direction: column; } .brand-tagline h1 { font-size: 2.3rem; } }
        .toast-notify { position: fixed; bottom: 24px; right: 24px; background: #0f172a; color: white; padding: 12px 20px; border-radius: 40px; font-size: 0.85rem; opacity: 0; transition: opacity 0.3s ease; pointer-events: none; z-index: 1000; }
    </style>
</head>
<body>
<div class="auth-wrapper">
    <div class="brand-panel">
        <div>
            <div class="logo-area"><div class="logo-icon">✧</div><span>Inkraft</span></div>
            <div class="brand-tagline">
                <h1>Write less.<br>Create more.</h1>
                <p style="opacity:0.8">Generate marketing copy, campaigns, blogs & social posts — in seconds.</p>
                <div class="feature-chip"><i class="bi bi-stars"></i> Powered by Claude & GPT-4</div>
                <div class="demo-card">
                    <div style="display:flex; justify-content:space-between;"><span style="font-size:0.75rem;">⚡ LIVE PREVIEW</span><i class="bi bi-robot" style="color:#a78bfa"></i></div>
                    <div style="margin-top:8px; font-weight:600;">Email Newsletter • Summer sale announcement</div>
                    <div class="content-preview">Big news: Our summer sale just dropped.<br><strong>🔥 Up to 50% off</strong></div>
                </div>
            </div>
        </div>
    </div>
    <div class="form-panel">
        <div class="login-card">
            <div class="login-header"><h2>Welcome back</h2><p>Sign in to continue crafting with Inkraft AI.</p></div>
            @if (session('status'))
                <div class="alert alert-success mb-4" style="border-radius:20px; font-size:0.85rem">{{ session('status') }}</div>
            @endif
            <form method="POST" action="{{ route('login') }}">
                @csrf
                <div class="mb-3">
                    <label class="input-label" for="email">Email address</label>
                    <div class="input-icon"><i class="bi bi-envelope-fill"></i>
                        <input type="email" id="email" name="email" class="form-control-custom @error('email') is-invalid @enderror" value="{{ old('email') }}" required autofocus>
                    </div>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="mb-3">
                    <label class="input-label" for="password">Password</label>
                    <div class="input-icon"><i class="bi bi-lock-fill"></i>
                        <input type="password" id="password" name="password" class="form-control-custom @error('password') is-invalid @enderror" required>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>
                <div class="remember-forgot">
                    <label class="checkbox-custom"><input type="checkbox" name="remember"> <span>Remember me</span></label>
                    @if (Route::has('password.request'))
                        <a class="forgot-link" href="{{ route('password.request') }}">Forgot password?</a>
                    @endif
                </div>
                <button type="submit" class="btn-login"><i class="bi bi-box-arrow-in-right"></i> Log in</button>
                <div class="signup-redirect">Don't have an account? <a href="{{ route('register') }}">Start generating free</a></div>
            </form>
        </div>
    </div>
</div>
<div id="toastMsg" class="toast-notify">✨ Welcome to Inkraft</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script>
    @if(session('status'))
        const toast = document.getElementById('toastMsg');
        toast.textContent = "{{ session('status') }}";
        toast.style.opacity = '1';
        setTimeout(() => toast.style.opacity = '0', 3000);
    @endif
</script>
</body>
</html>