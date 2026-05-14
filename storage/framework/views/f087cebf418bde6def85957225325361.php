<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'OTRS')); ?> — Create Account</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        /* ── Variables (matches landing page exactly) ── */
        :root {
            --sand:    #f5ede0;
            --cream:   #faf6f0;
            --brown:   #3b2a1a;
            --tan:     #c49a6c;
            --gold:    #d4a254;
            --gold-lt: #e2b46a;
            --teal:    #2d6e6e;
            --teal-lt: #3d8f8f;
            --white:   #ffffff;
            --ff-head: 'Playfair Display', Georgia, serif;
            --ff-body: 'DM Sans', sans-serif;
            --radius:    16px;
            --radius-sm: 10px;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            font-family: var(--ff-body);
            background: var(--cream);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 32px 16px;
            position: relative;
            overflow-x: hidden;
        }

        /* Ambient orbs — same as landing page */
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
            background: radial-gradient(circle, rgba(45,110,110,.10) 0%, transparent 70%);
            pointer-events: none;
        }

        /* ── Card ── */
        .register-card {
            background: var(--white);
            border: 1.5px solid rgba(59,42,26,.08);
            border-radius: 20px;
            padding: 36px 32px;
            width: 100%; max-width: 460px;
            box-shadow: 0 16px 48px rgba(59,42,26,.10);
            position: relative; z-index: 10;
            animation: cardUp .4s cubic-bezier(.16,1,.3,1) both;
        }
        @keyframes cardUp {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Brand bar ── */
        .brand-bar { display: flex; align-items: center; gap: 12px; margin-bottom: 28px; }
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

        /* ── Heading ── */
        .register-title { font-family: var(--ff-head); font-size: 1.55rem; font-weight: 900; color: var(--brown); margin-bottom: 4px; }
        .register-sub { font-size: .84rem; color: rgba(59,42,26,.4); margin-bottom: 24px; }

        /* ── Step indicator ── */
        .steps-bar {
            display: flex; align-items: center;
            margin-bottom: 26px;
            padding-bottom: 22px;
            border-bottom: 1px solid rgba(59,42,26,.07);
        }
        .step-item { display: flex; align-items: center; gap: 7px; flex: 1; }
        .step-dot {
            width: 24px; height: 24px; border-radius: 50%;
            border: 1.5px solid rgba(59,42,26,.15);
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            font-size: .7rem; color: rgba(59,42,26,.3); font-weight: 700;
            flex-shrink: 0; transition: all .25s ease;
        }
        .step-dot.active  { border-color: var(--teal); background: var(--teal); color: var(--white); box-shadow: 0 3px 10px rgba(45,110,110,.3); }
        .step-dot.done    { border-color: var(--gold); background: rgba(212,162,84,.12); color: var(--gold); }
        .step-label       { font-size: .7rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: rgba(59,42,26,.3); transition: color .25s; }
        .step-label.active { color: var(--teal); }
        .step-label.done   { color: var(--gold); }
        .step-connector   { flex: 1; height: 1px; background: rgba(59,42,26,.08); margin: 0 6px; }

        /* ── Error alert ── */
        .alert-error {
            background: rgba(180,68,68,.06); border: 1.5px solid rgba(180,68,68,.2);
            border-radius: var(--radius-sm); padding: 11px 14px; margin-bottom: 18px;
            font-size: .83rem; color: #b44444;
            display: flex; align-items: center; gap: 8px;
        }
        .alert-error svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; flex-shrink: 0; }

        /* ── Form fields ── */
        .field-group { margin-bottom: 15px; }
        .field-label {
            font-size: .7rem; font-weight: 700; letter-spacing: .08em;
            text-transform: uppercase; color: rgba(59,42,26,.38);
            margin-bottom: 7px; display: block;
        }
        .field-wrap { position: relative; }
        .field-input {
            width: 100%; background: var(--cream);
            border: 1.5px solid rgba(59,42,26,.12);
            border-radius: var(--radius-sm); padding: 11px 14px;
            font-size: .88rem; font-family: var(--ff-body);
            color: var(--brown); outline: none; transition: border-color .2s, background .2s;
        }
        .field-input:focus { border-color: var(--teal); background: var(--white); }
        .field-input::placeholder { color: rgba(59,42,26,.25); }
        .field-input.error { border-color: #b44444; }
        .field-error { font-size: .74rem; color: #b44444; margin-top: 5px; }

        /* eye toggle */
        .eye-btn {
            position: absolute; right: 12px; top: 50%; transform: translateY(-50%);
            color: rgba(59,42,26,.3); cursor: pointer; display: flex; align-items: center;
            background: none; border: none; padding: 0; transition: color .2s;
        }
        .eye-btn:hover { color: var(--teal); }
        .eye-btn svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.8; }
        .field-wrap .field-input { padding-right: 40px; }

        /* ── Password strength ── */
        .strength-row { display: flex; gap: 4px; margin-top: 8px; }
        .strength-seg { flex: 1; height: 3px; border-radius: 2px; background: rgba(59,42,26,.08); transition: background .3s; }
        .strength-note { font-size: .72rem; color: rgba(59,42,26,.35); margin-top: 5px; }

        /* ── Role grid ── */
        .role-section-label {
            font-size: .7rem; font-weight: 700; letter-spacing: .08em;
            text-transform: uppercase; color: rgba(59,42,26,.38);
            margin-bottom: 10px; display: block;
        }
        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 8px;
            margin-bottom: 6px;
        }
        .role-card {
            padding: 10px 6px 9px;
            border-radius: var(--radius-sm);
            border: 1.5px solid rgba(59,42,26,.1);
            background: var(--cream);
            color: rgba(59,42,26,.45);
            font-size: .74rem; font-weight: 600;
            cursor: pointer; text-align: center;
            transition: all .2s ease;
            display: flex; flex-direction: column; align-items: center; gap: 5px;
            letter-spacing: .01em; font-family: var(--ff-body);
        }
        .role-card svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 1.6; opacity: .6; transition: opacity .2s; }
        .role-card:hover { border-color: var(--tan); color: var(--brown); background: var(--sand); }
        .role-card:hover svg { opacity: .8; }
        .role-card.active {
            border-color: var(--teal); color: var(--teal);
            background: rgba(45,110,110,.06);
            box-shadow: 0 2px 10px rgba(45,110,110,.12);
        }
        .role-card.active svg { opacity: 1; }

        /* ── Nav buttons ── */
        .btn-primary {
            background: var(--teal); color: var(--white);
            border: none; border-radius: 50px; padding: 12px 28px;
            font-size: .92rem; font-weight: 700; font-family: var(--ff-body);
            cursor: pointer; transition: background .18s, transform .15s;
            box-shadow: 0 6px 20px rgba(45,110,110,.28); letter-spacing: .02em;
        }
        .btn-primary:hover { background: var(--teal-lt); transform: translateY(-1px); }
        .btn-ghost {
            background: transparent; color: rgba(59,42,26,.45);
            border: 1.5px solid rgba(59,42,26,.14); border-radius: 50px;
            padding: 11px 22px; font-size: .88rem; font-weight: 600;
            font-family: var(--ff-body); cursor: pointer;
            transition: all .15s; display: inline-flex; align-items: center; gap: 5px;
        }
        .btn-ghost:hover { color: var(--brown); border-color: rgba(59,42,26,.28); }
        .btn-ghost svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2; }

        .actions { display: flex; gap: 10px; margin-top: 20px; align-items: center; }
        .actions .btn-primary { flex: 1; }

        /* ── Divider & footer ── */
        .divider { display: flex; align-items: center; gap: 10px; margin: 20px 0; }
        .divider-line { flex: 1; height: 1px; background: rgba(59,42,26,.08); }
        .divider-text { font-size: .75rem; color: rgba(59,42,26,.3); }

        .login-row { text-align: center; font-size: .82rem; color: rgba(59,42,26,.42); }
        .login-row a { color: var(--teal); text-decoration: none; font-weight: 600; }
        .login-row a:hover { text-decoration: underline; }

        .terms-note { font-size: .72rem; color: rgba(59,42,26,.28); text-align: center; margin-top: 14px; line-height: 1.5; }
        .terms-note a { color: rgba(59,42,26,.4); text-decoration: underline; }
    </style>
</head>
<body>

<div class="register-card">

    
    <div class="brand-bar">
        <div class="brand-icon">
            <svg viewBox="0 0 24 24"><path d="M4 6h16M4 10h16M8 14h8M10 18h4"/></svg>
        </div>
        <div>
            <div class="brand-name">OTR<span>S</span></div>
            <div class="brand-sub">Online Tour Reservation</div>
        </div>
    </div>

    <div class="register-title">Create your account</div>
    <div class="register-sub">Join OTRS and start booking your trips</div>

    
    <div class="steps-bar">
        <div class="step-item">
            <div class="step-dot active" id="dot1">1</div>
            <span class="step-label active" id="lbl1">Account</span>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-dot" id="dot2">2</div>
            <span class="step-label" id="lbl2">Security</span>
        </div>
        <div class="step-connector"></div>
        <div class="step-item">
            <div class="step-dot" id="dot3">3</div>
            <span class="step-label" id="lbl3">Role</span>
        </div>
    </div>

    
    <?php if($errors->any()): ?>
        <div class="alert-error">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
            <?php echo e($errors->first()); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
        <?php echo csrf_field(); ?>

        
        <div id="step1">
            <div class="field-group">
                <label class="field-label" for="name">Full Name</label>
                <input class="field-input <?php echo e($errors->has('name') ? 'error' : ''); ?>"
                    id="name" type="text" name="name"
                    value="<?php echo e(old('name')); ?>" placeholder="Juan dela Cruz"
                    required autofocus autocomplete="name">
                <?php $__errorArgs = ['name'];
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

            <div class="field-group">
                <label class="field-label" for="email">Email Address</label>
                <input class="field-input <?php echo e($errors->has('email') ? 'error' : ''); ?>"
                    id="email" type="email" name="email"
                    value="<?php echo e(old('email')); ?>" placeholder="juan@example.com"
                    required autocomplete="username">
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

            <div class="actions" style="margin-top:18px;">
                <button type="button" class="btn-primary" onclick="goToStep(2)">
                    Continue →
                </button>
            </div>
        </div>

        
        <div id="step2" style="display:none;">
            <div class="field-group">
                <label class="field-label" for="password">Password</label>
                <div class="field-wrap">
                    <input class="field-input <?php echo e($errors->has('password') ? 'error' : ''); ?>"
                        id="password" type="password" name="password"
                        placeholder="Minimum 8 characters"
                        required autocomplete="new-password"
                        oninput="checkStrength(this.value)">
                    <button type="button" class="eye-btn" onclick="togglePass('password', this)">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
                <div class="strength-row">
                    <div class="strength-seg" id="s1"></div>
                    <div class="strength-seg" id="s2"></div>
                    <div class="strength-seg" id="s3"></div>
                    <div class="strength-seg" id="s4"></div>
                </div>
                <div class="strength-note" id="strength-text"></div>
                <?php $__errorArgs = ['password'];
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

            <div class="field-group">
                <label class="field-label" for="password_confirmation">Confirm Password</label>
                <div class="field-wrap">
                    <input class="field-input"
                        id="password_confirmation" type="password" name="password_confirmation"
                        placeholder="Re-enter your password"
                        required autocomplete="new-password">
                    <button type="button" class="eye-btn" onclick="togglePass('password_confirmation', this)">
                        <svg viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
                    </button>
                </div>
            </div>

            <div class="actions">
                <button type="button" class="btn-ghost" onclick="goToStep(1)">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Back
                </button>
                <button type="button" class="btn-primary" onclick="goToStep(3)">
                    Continue →
                </button>
            </div>
        </div>

        
        <div id="step3" style="display:none;">
            <span class="role-section-label">I am registering as</span>
            <div class="role-grid">
                <div class="role-card active" onclick="setRole(this,'traveler')">
                    <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>
                    Traveler
                </div>
                <div class="role-card" onclick="setRole(this,'tourist')">
                    <svg viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Tourist
                </div>
                <div class="role-card" onclick="setRole(this,'business')">
                    <svg viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2"/></svg>
                    Business
                </div>
                <div class="role-card" onclick="setRole(this,'commuter')">
                    <svg viewBox="0 0 24 24"><path d="M8 17H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-3m-4 0v4m0 0H8m4 0h4"/></svg>
                    Commuter
                </div>
                <div class="role-card" onclick="setRole(this,'corporate')">
                    <svg viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0H5m0 0H3"/></svg>
                    Corporate
                </div>
                <div class="role-card" onclick="setRole(this,'passenger')">
                    <svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
                    Passenger
                </div>
            </div>
            <input type="hidden" name="role" id="selected-role" value="traveler">

            <div class="actions">
                <button type="button" class="btn-ghost" onclick="goToStep(2)">
                    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
                    Back
                </button>
                <button type="submit" class="btn-primary">
                    Create Account
                </button>
            </div>
        </div>

    </form>

    <div class="divider">
        <div class="divider-line"></div>
        <div class="divider-text">or</div>
        <div class="divider-line"></div>
    </div>

    <div class="login-row">Already have an account? <a href="<?php echo e(route('login')); ?>">Sign in</a></div>

    <p class="terms-note">By registering, you agree to our <a href="#">Terms of Service</a> and <a href="#">Privacy Policy</a>.</p>
</div>

<script>
const TOTAL_STEPS = 3;

function goToStep(n) {
    for (let i = 1; i <= TOTAL_STEPS; i++) {
        document.getElementById('step' + i).style.display = i === n ? 'block' : 'none';
        const dot = document.getElementById('dot' + i);
        const lbl = document.getElementById('lbl' + i);

        dot.classList.remove('active', 'done');
        lbl.classList.remove('active', 'done');

        if (i < n) {
            dot.classList.add('done');
            dot.innerHTML = '✓';
            lbl.classList.add('done');
        } else if (i === n) {
            dot.classList.add('active');
            dot.innerHTML = i;
            lbl.classList.add('active');
        } else {
            dot.innerHTML = i;
        }
    }
}

function setRole(el, role) {
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('selected-role').value = role;
}

function togglePass(id, btn) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    btn.style.color = input.type === 'text' ? 'var(--teal)' : '';
}

function checkStrength(val) {
    const segs  = [1,2,3,4].map(i => document.getElementById('s' + i));
    const label = document.getElementById('strength-text');
    const colors = { 0:'rgba(59,42,26,.08)', 1:'#b44444', 2:'#c8882a', 3:'#d4a254', 4:'#2d6e6e' };

    let score = 0;
    if (val.length >= 8)          score++;
    if (/[A-Z]/.test(val))        score++;
    if (/[0-9]/.test(val))        score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    segs.forEach((s, i) => s.style.background = i < score ? colors[score] : colors[0]);
    label.textContent  = val.length ? labels[score] : '';
    label.style.color  = colors[score];
}

// Jump to the step with the error on page load
<?php if($errors->has('name') || $errors->has('email')): ?>
    goToStep(1);
<?php elseif($errors->has('password')): ?>
    goToStep(2);
<?php else: ?>
    goToStep(1);
<?php endif; ?>
</script>

</body>
</html><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/auth/register.blade.php ENDPATH**/ ?>