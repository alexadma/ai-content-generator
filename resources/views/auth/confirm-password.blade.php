<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=yes">
    <title>Inkraft • Confirm Password</title>
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
        .secure-badge {
            background: rgba(255,255,255,0.05); border-radius: 20px; padding: 1.4rem;
            border: 1px solid rgba(255,255,255,0.1); margin-top: 0.5rem;
        }
        .secure-badge p { font-size: 0.78rem; opacity: 0.55; margin-bottom: 1rem; text-transform: uppercase; letter-spacing: 0.05em; }
        .secure-row { display: flex; align-items: center; gap: 10px; margin-bottom: 0.75rem; font-size: 0.83rem; }
        .secure-row:last-child { margin-bottom: 0; }
        .s-icon { color: #a78bfa; font-size: 1rem; flex-shrink: 0; }

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
        .login-header p { color: #5b6e8c; font-size: 0.9rem; line-height: 1.6; margin-top: 0.3rem; }
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
        .security-note {
            display: flex; align-items: center; gap: 8px; margin-top: 1.2rem;
            background: #f8fafc; border-radius: 14px; padding: 0.75rem 1rem;
            font-size: 0.8rem; color: #64748b;
        }

        @media (max-width: 850px) { .auth-wrapper { flex-direction: column; } .brand-tagline h1 { font-size: 2.3rem; } }
    </style>
</head>
<body>
<div class="auth-wrapper">

    <div class="brand-panel">
        <div>
            <div class="logo-area"><div class="logo-icon">✧</div><span>Inkraft</span></div>
            <div class="brand-tagline">
                <h1>Secure area.<br>Identity check.</h1>
                <p style="opacity:0.8; margin-bottom:1rem;">This extra step keeps your account and content safe.</p>
                <div class="feature-chip"><i class="bi bi-shield-fill-check"></i> Protected by 256-bit encryption</div>
                <div class="secure-badge">
                    <p>Why we ask this</p>
                    <div class="secure-row"><i class="bi bi-person-lock s-icon"></i><span style="opacity:0.75">Confirms it's really you before granting access to sensitive settings.</span></div>
                    <div class="secure-row"><i class="bi bi-clock-history s-icon"></i><span style="opacity:0.75">Session confirmation expires after inactivity for your protection.</span></div>
                    <div class="secure-row"><i class="bi bi-incognito s-icon"></i><span style="opacity:0.75">We never store or log your password in plain text.</span></div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-panel">
        <div class="login-card">
            <div class="icon-badge">🛡️</div>
            <div class="login-header">
                <h2>Confirm your password</h2>
                <p>This is a secure area. Please re-enter your password to continue.</p>
            </div>

            <form method="POST" action="{{ route('password.confirm') }}">
                @csrf
                <div>
                    <label class="input-label" for="password">Password</label>
                    <div class="input-icon">
                        <i class="bi bi-lock-fill icon-left"></i>
                        <input type="password" id="password" name="password"
                               class="form-control-custom @error('password') is-invalid @enderror"
                               required autocomplete="current-password" placeholder="Enter your password">
                        <button type="button" class="toggle-pwd" onclick="togglePwd()"><i class="bi bi-eye" id="eyeIcon"></i></button>
                    </div>
                    @error('password') <div class="text-danger small mt-1">{{ $message }}</div> @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-shield-check-fill"></i> Confirm & continue
                </button>

                <div class="security-note">
                    <i class="bi bi-info-circle" style="color:#4f46e5; flex-shrink:0;"></i>
                    You'll only need to confirm once per session.
                </div>
            </form>
        </div>
    </div>

</div>
<script>
    function togglePwd() {
        const input = document.getElementById('password');
        const icon = document.getElementById('eyeIcon');
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