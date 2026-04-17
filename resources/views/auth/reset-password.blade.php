<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Inkraft • Reset Password</title>
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
            color: white; padding: 3rem 2.5rem;
            display: flex; flex-direction: column; justify-content: space-between;
            position: relative; overflow: hidden;
        }
        .brand-panel::before {
            content: ""; position: absolute; top: 0; left: 0; width: 100%; height: 100%;
            background-image: radial-gradient(circle at 20% 40%, rgba(255,255,255,0.03) 2%, transparent 2.5%);
            background-size: 32px 32px; pointer-events: none;
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
            border: 1px solid rgba(255,255,255,0.15); margin-bottom: 1.5rem;
        }
        .strength-guide {
            background: rgba(255,255,255,0.05); border-radius: 20px; padding: 1.2rem;
            border: 1px solid rgba(255,255,255,0.1); margin-top: 1rem;
        }
        .strength-guide p { font-size: 0.8rem; opacity: 0.6; margin-bottom: 0.8rem; }
        .strength-row { display: flex; align-items: center; gap: 8px; margin-bottom: 0.5rem; font-size: 0.82rem; opacity: 0.8; }
        .check-dot { width: 20px; height: 20px; border-radius: 50%; background: rgba(79,70,229,0.4); display: flex; align-items: center; justify-content: center; font-size: 0.65rem; flex-shrink: 0; }

        .form-panel { flex: 0.9; display: flex; align-items: center; justify-content: center; background: #fff; padding: 2rem; }
        .login-card {
            max-width: 440px; width: 100%; background: white; border-radius: 32px;
            padding: 2rem 1.8rem; box-shadow: 0 25px 45px -12px rgba(0,0,0,0.1);
        }
        .icon-badge {
            width: 52px; height: 52px; background: #eef2ff; border-radius: 16px;
            display: flex; align-items: center; justify-content: center;
            font-size: 1.5rem; margin-bottom: 1.2rem;
        }
        .login-header { margin-bottom: 1.8rem; }
        .login-header h2 { font-weight: 700; font-size: 1.8rem; color: #0f172a; }
        .login-header p { color: #5b6e8c; font-size: 0.9rem; margin-top: 0.3rem; }
        .input-label { font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem; display: block; color: #1e293b; }
        .input-icon { position: relative; }
        .input-icon i.icon-left { position: absolute; left: 16px; top: 50%; transform: translateY(-50%); color: #94a3b8; }
        .form-control-custom {
            width: 100%; padding: 0.85rem 2.8rem 0.85rem 2.8rem;
            border-radius: 18px; border: 1.5px solid #e2e8f0;
            font-size: 0.95rem; transition: 0.2s; outline: none; font-family: 'Inter', sans-serif;
        }
        .form-control-custom:focus { border-color: #4f46e5; box-shadow: 0 0 0 3px rgba(79,70,229,0.2); }
        .toggle-pwd {
            position: absolute; right: 14px; top: 50%; transform: translateY(-50%);
            color: #94a3b8; cursor: pointer; background: none; border: none; padding: 4px;
        }
        .btn-login {
            background: #0f172a; border: none; padding: 0.85rem; font-weight: 600;
            border-radius: 40px; width: 100%; color: white; transition: 0.2s;
            display: flex; align-items: center; justify-content: center; gap: 10px;
            font-family: 'Inter', sans-serif; font-size: 0.95rem; cursor: pointer; margin-top: 1.5rem;
        }
        .btn-login:hover { background: #1e293b; transform: translateY(-2px); }

        @media (max-width: 850px) { .auth-wrapper { flex-direction: column; } .brand-tagline h1 { font-size: 2.3rem; } }
    </style>
</head>
<body>
<div class="auth-wrapper">

    <div class="brand-panel">
        <div>
            <div class="logo-area"><div class="logo-icon">✧</div><span>Inkraft</span></div>
            <div class="brand-tagline">
                <h1>New password,<br>fresh start.</h1>
                <p style="opacity:0.8; margin-bottom:1rem;">Choose something strong and memorable.</p>
                <div class="feature-chip"><i class="bi bi-shield-check"></i> End-to-end encrypted</div>
                <div class="strength-guide">
                    <p>Strong password tips</p>
                    <div class="strength-row"><div class="check-dot"><i class="bi bi-check"></i></div> At least 8 characters</div>
                    <div class="strength-row"><div class="check-dot"><i class="bi bi-check"></i></div> Mix of uppercase & lowercase</div>
                    <div class="strength-row"><div class="check-dot"><i class="bi bi-check"></i></div> Include numbers or symbols</div>
                    <div class="strength-row"><div class="check-dot"><i class="bi bi-check"></i></div> Avoid common words or dates</div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-panel">
        <div class="login-card">
            <div class="icon-badge">🔒</div>
            <div class="login-header">
                <h2>Reset password</h2>
                <p>Create a new password for your Inkraft account.</p>
            </div>

            <form method="POST" action="{{ route('password.store') }}">
                @csrf
                <input type="hidden" name="token" value="{{ $request->route('token') }}">

                <!-- Email -->
                <div class="mb-3">
                    <label class="input-label" for="email">Email address</label>
                    <div class="input-icon">
                        <i class="bi bi-envelope-fill icon-left"></i>
                        <input type="email" id="email" name="email"
                               class="form-control-custom @error('email') is-invalid @enderror"
                               value="{{ old('email', $request->email) }}" required autofocus autocomplete="username">
                    </div>
                    @error('email') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Password -->
                <div class="mb-3">
                    <label class="input-label" for="password">New password</label>
                    <div class="input-icon">
                        <i class="bi bi-lock-fill icon-left"></i>
                        <input type="password" id="password" name="password"
                               class="form-control-custom @error('password') is-invalid @enderror"
                               required autocomplete="new-password" placeholder="Min. 8 characters">
                        <button type="button" class="toggle-pwd" onclick="togglePwd('password', this)"><i class="bi bi-eye"></i></button>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <!-- Confirm Password -->
                <div>
                    <label class="input-label" for="password_confirmation">Confirm new password</label>
                    <div class="input-icon">
                        <i class="bi bi-shield-lock-fill icon-left"></i>
                        <input type="password" id="password_confirmation" name="password_confirmation"
                               class="form-control-custom"
                               required autocomplete="new-password" placeholder="Re-enter password">
                        <button type="button" class="toggle-pwd" onclick="togglePwd('password_confirmation', this)"><i class="bi bi-eye"></i></button>
                    </div>
                    @error('password_confirmation') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-check-circle-fill"></i> Reset password
                </button>
            </form>
        </div>
    </div>

</div>
<script>
    function togglePwd(id, btn) {
        const input = document.getElementById(id);
        const icon = btn.querySelector('i');
        if (input.type === 'password') {
            input.type = 'text';
            icon.className = 'bi bi-eye-slash';
        } else {
            input.type = 'password';
            icon.className = 'bi bi-eye';
        }
    }
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>