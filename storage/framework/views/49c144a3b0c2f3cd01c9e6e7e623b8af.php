<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'OTRS')); ?> — Forgot Password</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
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

        .card {
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

        /* Icon circle */
        .icon-circle {
            width: 52px; height: 52px; border-radius: 50%;
            background: rgba(45,110,110,.08);
            border: 1.5px solid rgba(45,110,110,.18);
            display: flex; align-items: center; justify-content: center;
            margin-bottom: 16px;
            color: var(--teal);
        }
        .icon-circle svg { width: 22px; height: 22px; stroke: currentColor; fill: none; stroke-width: 1.8; }

        /* Heading */
        .page-title { font-family: var(--ff-head); font-size: 1.55rem; font-weight: 900; color: var(--brown); margin-bottom: 6px; }
        .page-sub { font-size: .84rem; color: rgba(59,42,26,.4); margin-bottom: 24px; line-height: 1.6; }

        /* Alerts */
        .alert { border-radius: var(--radius-sm); padding: 11px 14px; margin-bottom: 18px; font-size: .82rem; display: flex; align-items: flex-start; gap: 8px; line-height: 1.5; }
        .alert svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; margin-top: 1px; }
        .alert-success { background: rgba(45,110,110,.07); border: 1.5px solid rgba(45,110,110,.2); color: var(--teal); }
        .alert-error   { background: rgba(180,68,68,.06); border: 1.5px solid rgba(180,68,68,.2); color: #b44444; }

        /* Fields */
        .field-group { margin-bottom: 18px; }
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
        .field-input.has-error { border-color: #b44444; }
        .field-error { font-size: .72rem; color: #b44444; margin-top: 5px; }

        /* Submit */
        .submit-btn {
            width: 100%; background: var(--teal); color: var(--white);
            border: none; border-radius: 50px; padding: 12px;
            font-size: .92rem; font-weight: 700; font-family: var(--ff-body);
            cursor: pointer; transition: background .18s, transform .15s;
            box-shadow: 0 6px 20px rgba(45,110,110,.28); letter-spacing: .02em;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .submit-btn svg { width: 15px; height: 15px; stroke: #fff; fill: none; stroke-width: 2; }
        .submit-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }
        .submit-btn:disabled { opacity: .6; cursor: not-allowed; transform: none; }

        /* Back link */
        .back-row { text-align: center; margin-top: 20px; font-size: .82rem; color: rgba(59,42,26,.42); }
        .back-row a { color: var(--teal); text-decoration: none; font-weight: 600; }
        .back-row a:hover { text-decoration: underline; }
    </style>
</head>
<body>

<div class="card">
    <div class="brand-bar">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M8 14h8M10 18h4"/></svg>
        </div>
        <div>
            <div class="brand-name">OTR<span>S</span></div>
            <div class="brand-sub">Online Tour Reservation</div>
        </div>
    </div>

    <div class="icon-circle">
        <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
    </div>

    <div class="page-title">Forgot Password?</div>
    <div class="page-sub">No problem. Enter your registered email and we'll send you a link to reset your password.</div>

    <?php if(session('status')): ?>
        <div class="alert alert-success">
            <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
            <span><?php echo e(session('status')); ?> Check your inbox (or spam folder) for the reset link.</span>
        </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
        <div class="alert alert-error">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('password.email')); ?>" id="reset-form">
        <?php echo csrf_field(); ?>
        <div class="field-group">
            <label class="field-label" for="email">Email Address</label>
            <input
                id="email" type="email" name="email"
                class="field-input <?php echo e($errors->has('email') ? 'has-error' : ''); ?>"
                value="<?php echo e(old('email')); ?>"
                placeholder="you@example.com"
                required autofocus autocomplete="email"
            />
            <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="field-error"><?php echo e($message); ?></div>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        <button type="submit" class="submit-btn" id="submit-btn">
            <svg viewBox="0 0 24 24"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
            <span id="btn-text">Send Reset Link</span>
        </button>
    </form>

    <div class="back-row">Remembered your password? <a href="<?php echo e(route('login')); ?>">Back to Login</a></div>
</div>

<script>
document.getElementById('reset-form').addEventListener('submit', function() {
    var btn = document.getElementById('submit-btn');
    btn.disabled = true;
    document.getElementById('btn-text').textContent = 'Sending…';
});
</script>
</body>
</html><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/auth/forgot-password.blade.php ENDPATH**/ ?>