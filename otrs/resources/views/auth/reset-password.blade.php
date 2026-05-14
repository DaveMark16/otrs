<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'OTRS') }} — Reset Password</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        *{box-sizing:border-box;margin:0;padding:0}
        body{background:#000;display:flex;align-items:center;justify-content:center;min-height:100vh;font-family:system-ui,-apple-system,sans-serif;padding:2rem}
        .card{background:#1c1e1e;border:0.5px solid #2e3030;border-radius:16px;padding:2.5rem 2rem;width:100%;max-width:420px}
        .brand-bar{display:flex;align-items:center;gap:10px;margin-bottom:2rem}
        .brand-logo{width:40px;height:40px;background:#FF6044;border-radius:10px;display:flex;align-items:center;justify-content:center}
        .brand-name{font-size:20px;font-weight:500;color:#fff;letter-spacing:1px}
        .brand-sub{font-size:11px;color:#888;letter-spacing:2px;text-transform:uppercase}
        .icon-circle{width:52px;height:52px;background:rgba(76,175,129,.12);border:0.5px solid rgba(76,175,129,.25);border-radius:50%;display:flex;align-items:center;justify-content:center;margin-bottom:1.2rem}
        .page-title{font-size:22px;font-weight:600;color:#fff;margin-bottom:6px}
        .page-sub{font-size:13px;color:#666;margin-bottom:1.8rem;line-height:1.6}
        .alert-error{background:rgba(224,85,85,.1);border:0.5px solid rgba(224,85,85,.3);border-radius:8px;padding:12px 14px;margin-bottom:1.2rem;font-size:13px;color:#e05555}
        .field-group{margin-bottom:1.2rem;position:relative}
        .field-label{font-size:12px;color:#aaa;margin-bottom:6px;display:block;text-transform:uppercase;letter-spacing:.5px}
        .field-input{width:100%;background:#0e0f0f;border:0.5px solid #333;border-radius:8px;padding:11px 42px 11px 14px;font-size:14px;color:#fff;outline:none;font-family:inherit;transition:border-color .15s}
        .field-input:focus{border-color:#FF6044}
        .field-input.has-error{border-color:#e05555}
        .field-error{font-size:11px;color:#e05555;margin-top:5px}
        .eye-btn{position:absolute;right:12px;top:32px;background:none;border:none;color:#555;cursor:pointer;padding:4px;display:flex;align-items:center}
        .eye-btn:hover{color:#ccc}
        .strength-bar{height:3px;border-radius:2px;margin-top:6px;transition:all .3s;background:#1e1f1f;overflow:hidden}
        .strength-fill{height:100%;border-radius:2px;transition:all .3s;width:0}
        .strength-text{font-size:10px;margin-top:4px;color:#555}
        .submit-btn{width:100%;background:#FF6044;color:#fff;border:none;border-radius:8px;padding:12px;font-size:14px;font-weight:600;cursor:pointer;font-family:inherit;transition:background .15s;display:flex;align-items:center;justify-content:center;gap:8px;margin-top:4px}
        .submit-btn:hover{background:#e5532e}
        .submit-btn:disabled{opacity:.6;cursor:not-allowed}
        .back-row{text-align:center;margin-top:1.4rem;font-size:13px;color:#555}
        .back-row a{color:#FF6044;text-decoration:none}
        .back-row a:hover{text-decoration:underline}
        .match-indicator{font-size:11px;margin-top:4px}
        .match-ok{color:#4caf81}
        .match-no{color:#e05555}
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
            <rect x="3" y="11" width="18" height="11" rx="2" ry="2" stroke="#4caf81" stroke-width="1.8"/>
            <path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="#4caf81" stroke-width="1.8" stroke-linecap="round"/>
        </svg>
    </div>

    <div class="page-title">Set New Password</div>
    <div class="page-sub">Choose a strong password for your OTRS account.</div>

    @if($errors->any())
        <div class="alert-error">&#10005; {{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.store') }}" id="reset-form">
        @csrf
        <input type="hidden" name="token" value="{{ $request->route('token') }}" />

        {{-- Email --}}
        <div class="field-group">
            <label class="field-label" for="email">Email Address</label>
            <input
                id="email" type="email" name="email"
                class="field-input {{ $errors->has('email') ? 'has-error' : '' }}"
                value="{{ old('email', $request->email) }}"
                required autofocus autocomplete="username"
                placeholder="you@example.com"
            />
            @error('email')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- New Password --}}
        <div class="field-group">
            <label class="field-label" for="password">New Password</label>
            <input
                id="password" type="password" name="password"
                class="field-input {{ $errors->has('password') ? 'has-error' : '' }}"
                required autocomplete="new-password"
                placeholder="Minimum 8 characters"
                oninput="checkStrength(this.value); checkMatch()"
            />
            <button type="button" class="eye-btn" onclick="toggleEye('password', this)" tabindex="-1">
                <svg id="eye-password" viewBox="0 0 24 24" fill="none" width="16" height="16"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
            </button>
            <div class="strength-bar"><div class="strength-fill" id="strength-fill"></div></div>
            <div class="strength-text" id="strength-text"></div>
            @error('password')
                <div class="field-error">{{ $message }}</div>
            @enderror
        </div>

        {{-- Confirm Password --}}
        <div class="field-group">
            <label class="field-label" for="password_confirmation">Confirm New Password</label>
            <input
                id="password_confirmation" type="password" name="password_confirmation"
                class="field-input"
                required autocomplete="new-password"
                placeholder="Repeat your new password"
                oninput="checkMatch()"
            />
            <button type="button" class="eye-btn" onclick="toggleEye('password_confirmation', this)" tabindex="-1">
                <svg viewBox="0 0 24 24" fill="none" width="16" height="16"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z" stroke="currentColor" stroke-width="2"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="2"/></svg>
            </button>
            <div class="match-indicator" id="match-indicator"></div>
        </div>

        <button type="submit" class="submit-btn" id="submit-btn">
            <svg viewBox="0 0 24 24" fill="none" width="16" height="16"><rect x="3" y="11" width="18" height="11" rx="2" stroke="#fff" stroke-width="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="#fff" stroke-width="2" stroke-linecap="round"/></svg>
            <span id="btn-text">Reset Password</span>
        </button>
    </form>

    <div class="back-row"><a href="{{ route('login') }}">← Back to Login</a></div>
</div>

<script>
function toggleEye(fieldId, btn) {
    var input = document.getElementById(fieldId);
    input.type = input.type === 'password' ? 'text' : 'password';
    btn.style.color = input.type === 'text' ? '#FF6044' : '#555';
}

function checkStrength(val) {
    var fill = document.getElementById('strength-fill');
    var text = document.getElementById('strength-text');
    var score = 0;
    if (val.length >= 8)  score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    var map = [
        { w:'0%',   color:'#1e1f1f', label:'' },
        { w:'25%',  color:'#e24b4a', label:'Weak' },
        { w:'50%',  color:'#ef9f27', label:'Fair' },
        { w:'75%',  color:'#378add', label:'Good' },
        { w:'100%', color:'#4caf81', label:'Strong' },
    ];
    var m = map[score];
    fill.style.width = m.w;
    fill.style.background = m.color;
    text.textContent = m.label;
    text.style.color = m.color;
}

function checkMatch() {
    var p1  = document.getElementById('password').value;
    var p2  = document.getElementById('password_confirmation').value;
    var ind = document.getElementById('match-indicator');
    if (!p2) { ind.textContent = ''; return; }
    if (p1 === p2) {
        ind.textContent = '✓ Passwords match';
        ind.className = 'match-indicator match-ok';
    } else {
        ind.textContent = '✕ Passwords do not match';
        ind.className = 'match-indicator match-no';
    }
}

document.getElementById('reset-form').addEventListener('submit', function(e) {
    var p1 = document.getElementById('password').value;
    var p2 = document.getElementById('password_confirmation').value;
    if (p1 !== p2) { e.preventDefault(); return; }
    var btn = document.getElementById('submit-btn');
    btn.disabled = true;
    document.getElementById('btn-text').textContent = 'Resetting…';
});
</script>
</body>
</html>