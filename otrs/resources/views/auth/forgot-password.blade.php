<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'OTRS') }} — Forgot Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:#000;display:flex;align-items:center;justify-content:center;min-height:100vh;font-family:system-ui,-apple-system,sans-serif;padding:2rem}
        .card{background:#1c1e1e;border:0.5px solid #2e3030;border-radius:16px;padding:2.5rem 2rem;width:100%;max-width:420px}
        .brand-bar{display:flex;align-items:center;gap:10px;margin-bottom:2rem}
        .brand-logo{width:40px;height:40px;background:#FF6044;border-radius:10px;display:flex;align-items:center;justify-content:center}
        .brand-name{font-size:20px;font-weight:500;color:#fff;letter-spacing:1px}
        .brand-sub{font-size:11px;color:#888;letter-spacing:2px;text-transform:uppercase}
        .icon-circle{width:52px;height:52px;background:rgba(255,96,68,.12);border:0.5px solid rgba(255,96,68,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem}
        .page-title{font-size:22px;font-weight:600;color:#fff;margin-bottom:6px}
        .page-sub{font-size:13px;color:#666;margin-bottom:1.8rem;line-height:1.6}
        .alert-success{background:rgba(76,175,129,.1);border:0.5px solid rgba(76,175,129,.35);border-radius:8px;padding:12px 14px;margin-bottom:1.2rem;font-size:13px;color:#4caf81;display:flex;align-items:flex-start;gap:8px;line-height:1.5}
        .alert-error{background:rgba(224,85,85,.1);border:0.5px solid rgba(224,85,85,.3);border-radius:8px;padding:12px 14px;margin-bottom:1.2rem;font-size:13px;color:#e05555}
        .field-group{margin-bottom:1.2rem}
        .field-label{font-size:12px;color:#aaa;margin-bottom:6px;display:block;text-transform:uppercase;letter-spacing:.5px}
        .field-input{width:100%;background:#0e0f0f;border:0.5px solid #333;border-radius:8px;padding:11px 14px;font-size:14px;color:#fff;outline:none;font-family:inherit;transition:border-color .15s}
        .field-input:focus{border-color:#FF6044}
        .field-input.has-error{border-color:#e05555}
        .field-error{font-size:11px;color:#e05555;margin-top:5px}
        .submit-btn{width:100%;background:#FF6044;color:#fff;border:none;border-radius:8px;padding:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;transition:background .15s;display:flex;align-items:center;justify-content:center;gap:8px}
        .submit-btn:hover{background:#e5532e}
        .submit-btn:disabled{opacity:.6;cursor:not-allowed}
        .back-row{text-align:center;margin-top:1.4rem;font-size:13px;color:#555}
        .back-row a{color:#FF6044;text-decoration:none}
        .back-row a:hover{text-decoration:underline}
    </style>
</head>
<body>
<div class="card">
    <div class="brand-bar">
        <div class="brand-logo">
            <svg viewBox="0 0 24 24" fill="none"><path d="M4 6h16M4 10h16M8 14h8M10 18h4" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
        </div>
        <div>
            <div class="brand-name">OTRS</div>
            <div class="brand-sub">Online Ticket Reservation</div>
        </div>
    </div>

    <div class="icon-circle">
        <svg viewBox="0 0 24 24" fill="none" width="24" height="24">
            <path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="#FF6044" stroke-width="1.8"/>
            <polyline points="22,6 12,13 2,6" stroke="#FF6044" stroke-width="1.8"/>
        </svg>
    </div>

    <div class="page-title">Forgot Password?</div>
    <div class="page-sub">No problem. Enter your registered email and we'll send you a link to reset your password.</div>

    @if(session('status'))
        <div class="alert-success">
            <svg viewBox="0 0 24 24" fill="none" width="18" height="18" style="flex-shrink:0;margin-top:1px"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" stroke="#4caf81" stroke-width="2" stroke-linecap="round"/><polyline points="22 4 12 14.01 9 11.01" stroke="#4caf81" stroke-width="2" stroke-linecap="round"/></svg>
            <span>{{ session('status') }} &nbsp;Check your inbox (or spam folder) for the reset link.</span>
        </div>
    @endif

    @if($errors->any())
        <div class="alert-error">&#10005; {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" id="reset-form">
        @csrf
        <div class="field-group">
            <label class="field-label" for="email">Email Address</label>
            <input
                id="email" type="email" name="email"
                class="field-input {{ $errors->has('email') ? 'has-error' : '' }}"
                value="{{ old('email') }}"
                placeholder="you@example.com"
                required autofocus autocomplete="email"
            />
            @error('email')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        <button type="submit" class="submit-btn" id="submit-btn">
            <svg viewBox="0 0 24 24" fill="none" width="16" height="16"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z" stroke="#fff" stroke-width="2"/><polyline points="22,6 12,13 2,6" stroke="#fff" stroke-width="2"/></svg>
            <span id="btn-text">Send Reset Link</span>
        </button>
    </form>

    <div class="back-row">Remembered your password? <a href="{{ route('login') }}">Back to Login</a></div>
</div>
<script>
document.getElementById('reset-form').addEventListener('submit', function() {
    var btn = document.getElementById('submit-btn');
    btn.disabled = true;
    document.getElementById('btn-text').textContent = 'Sending…';
});
</script>
</body>
</html>