<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'OTRS') }} — Sign In</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --sand:   #f5ede0; --cream:  #faf6f0; --brown:  #3b2a1a;
            --tan:    #c49a6c; --gold:   #d4a254; --gold-lt:#e2b46a;
            --teal:   #2d6e6e; --teal-lt:#3d8f8f; --white:  #ffffff;
            --ff-head:'Playfair Display', Georgia, serif;
            --ff-body:'DM Sans', sans-serif;
            --radius: 16px; --radius-sm: 10px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: var(--ff-body);
            background: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            position: relative;
            overflow: hidden;
        }
        /* Decorative blobs */
        body::before {
            content: '';
            position: fixed; top: -120px; right: -120px;
            width: 480px; height: 480px; border-radius: 50%;
            background: radial-gradient(circle, rgba(212,162,84,.13) 0%, transparent 70%);
            pointer-events: none;
        }
        body::after {
            content: '';
            position: fixed; bottom: -100px; left: -100px;
            width: 400px; height: 400px; border-radius: 50%;
            background: radial-gradient(circle, rgba(45,110,110,.1) 0%, transparent 70%);
            pointer-events: none;
        }

        .login-card {
            background: var(--white);
            border: 1.5px solid rgba(59,42,26,.08);
            border-radius: 20px;
            padding: 36px 32px;
            width: 100%; max-width: 420px;
            box-shadow: 0 16px 48px rgba(59,42,26,.10);
            position: relative; z-index: 10;
        }

        /* Brand */
        .brand-bar { display:flex; align-items:center; gap:12px; margin-bottom:28px; }
        .brand-icon {
            width: 44px; height: 44px; border-radius: 12px;
            background: var(--teal);
            display: flex; align-items: center; justify-content: center;
            box-shadow: 0 4px 14px rgba(45,110,110,.3);
            flex-shrink: 0;
        }
        .brand-icon svg { width: 22px; height: 22px; stroke: #fff; fill: none; stroke-width: 2; stroke-linecap: round; }
        .brand-name { font-family: var(--ff-head); font-size: 1.35rem; font-weight: 900; color: var(--brown); line-height: 1; }
        .brand-name span { color: var(--gold); }
        .brand-sub { font-size: .65rem; font-weight: 600; letter-spacing: .14em; text-transform: uppercase; color: rgba(59,42,26,.32); margin-top: 3px; }

        /* Heading */
        .login-title { font-family: var(--ff-head); font-size: 1.55rem; font-weight: 900; color: var(--brown); margin-bottom: 5px; }
        .login-sub { font-size: .84rem; color: rgba(59,42,26,.4); margin-bottom: 26px; }

        /* Error */
        .alert-error { background: rgba(180,68,68,.06); border: 1.5px solid rgba(180,68,68,.2); border-radius: var(--radius-sm); padding: 11px 14px; margin-bottom: 18px; font-size: .83rem; color: #b44444; display: flex; align-items: center; gap: 8px; }
        .alert-error svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

        /* Role pills */
        .role-label { font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(59,42,26,.35); margin-bottom: 9px; }
        .role-row { display: flex; gap: 6px; margin-bottom: 20px; flex-wrap: wrap; }
        .role-btn {
            flex: 1; min-width: 60px; padding: 7px 8px;
            border-radius: 50px; border: 1.5px solid rgba(59,42,26,.12);
            background: var(--cream); color: rgba(59,42,26,.45);
            font-size: .76rem; font-weight: 600; font-family: var(--ff-body);
            cursor: pointer; text-align: center; transition: all .15s;
        }
        .role-btn:hover { border-color: var(--teal); color: var(--teal); }
        .role-btn.active { background: var(--teal); border-color: var(--teal); color: var(--white); box-shadow: 0 3px 10px rgba(45,110,110,.22); }

        /* Fields */
        .field-group { margin-bottom: 16px; }
        .field-label { font-size: .7rem; font-weight: 700; letter-spacing: .08em; text-transform: uppercase; color: rgba(59,42,26,.38); margin-bottom: 7px; display: block; }
        .field-input {
            width: 100%; background: var(--cream);
            border: 1.5px solid rgba(59,42,26,.12);
            border-radius: var(--radius-sm); padding: 11px 14px;
            font-size: .88rem; font-family: var(--ff-body);
            color: var(--brown); outline: none; transition: border-color .2s;
        }
        .field-input:focus { border-color: var(--teal); background: var(--white); }
        .field-input::placeholder { color: rgba(59,42,26,.25); }

        /* Forgot */
        .forgot { text-align: right; margin-top: -8px; margin-bottom: 20px; }
        .forgot a { font-size: .78rem; color: var(--teal); text-decoration: none; font-weight: 600; opacity: .8; transition: opacity .15s; }
        .forgot a:hover { opacity: 1; }

        /* Submit */
        .login-btn {
            width: 100%; background: var(--teal); color: var(--white);
            border: none; border-radius: 50px; padding: 12px;
            font-size: .92rem; font-weight: 700; font-family: var(--ff-body);
            cursor: pointer; transition: background .18s, transform .15s;
            box-shadow: 0 6px 20px rgba(45,110,110,.28); letter-spacing: .02em;
        }
        .login-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }

        /* Divider */
        .divider { display:flex; align-items:center; gap:10px; margin: 20px 0; }
        .divider-line { flex:1; height:1px; background: rgba(59,42,26,.08); }
        .divider-text { font-size: .75rem; color: rgba(59,42,26,.3); }

        /* Register */
        .register-row { text-align:center; font-size:.82rem; color:rgba(59,42,26,.42); }
        .register-row a { color: var(--teal); text-decoration: none; font-weight: 600; }
        .register-row a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="login-card">
    <div class="brand-bar">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M8 14h8M10 18h4"/></svg>
        </div>
        <div>
            <div class="brand-name">OTR<span>S</span></div>
            <div class="brand-sub">Online Tour Reservation</div>
        </div>
    </div>

    <div class="login-title">Welcome back</div>
    <div class="login-sub">Sign in to your account to continue</div>

    @if ($errors->any())
        <div class="alert-error">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <div class="role-label">Login as</div>
        <div class="role-row">
            @foreach(['traveler','business','tourist','corporate','admin'] as $role)
                <div class="role-btn {{ $role === 'traveler' ? 'active' : '' }}"
                     onclick="setRole(this, '{{ $role }}')">
                    {{ ucfirst($role) }}
                </div>
            @endforeach
        </div>
        <input type="hidden" name="role" id="selected-role" value="traveler">

        <div class="field-group">
            <label class="field-label">Email address</label>
            <input class="field-input" type="email" name="email"
                   value="{{ old('email') }}" required autofocus
                   placeholder="you@example.com">
        </div>

        <div class="field-group">
            <label class="field-label">Password</label>
            <input class="field-input" type="password" name="password" required
                   placeholder="••••••••">
        </div>

        <div class="forgot">
            <a href="{{ route('password.request') }}">Forgot password?</a>
        </div>

        <button type="submit" class="login-btn">Sign in</button>
    </form>

    <div class="divider">
        <div class="divider-line"></div>
        <div class="divider-text">or</div>
        <div class="divider-line"></div>
    </div>

    <div class="register-row">
        Don't have an account? <a href="{{ route('register') }}">Register now</a>
    </div>
</div>

<script>
function setRole(el, role) {
    document.querySelectorAll('.role-btn').forEach(b => b.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('selected-role').value = role;
}
</script>
</body>
</html>
