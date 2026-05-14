<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name', 'OTRS')); ?> - Create Account</title>
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

        body {
            background: #000000;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            padding: 2rem 1rem;
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
        }

        /* Subtle grid texture on background */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,96,68,0.03) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,96,68,0.03) 1px, transparent 1px);
            background-size: 40px 40px;
            pointer-events: none;
            z-index: 0;
        }

        .register-card {
            background: #111213;
            border: 0.5px solid #2a2c2c;
            border-radius: 20px;
            padding: 2.5rem 2rem;
            width: 100%;
            max-width: 440px;
            position: relative;
            z-index: 10;
            box-shadow: 0 0 0 1px rgba(255,255,255,0.03), 0 32px 64px rgba(0,0,0,0.6);
            animation: slideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(24px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* Brand */
        .brand-bar { display: flex; align-items: center; gap: 10px; margin-bottom: 2rem; }
        .brand-logo {
            width: 40px; height: 40px;
            background: #FF6044;
            border-radius: 10px;
            display: flex; align-items: center; justify-content: center;
            flex-shrink: 0;
        }
        .brand-logo svg { width: 22px; height: 22px; }
        .brand-name { font-size: 20px; font-weight: 500; color: #fff; letter-spacing: 1px; }
        .brand-sub { font-size: 11px; color: #666; letter-spacing: 2px; text-transform: uppercase; }

        /* Header */
        .register-title { font-size: 22px; font-weight: 500; color: #fff; margin-bottom: 4px; }
        .register-sub { font-size: 13px; color: #777; margin-bottom: 1.8rem; }

        /* Steps indicator */
        .steps-bar {
            display: flex;
            align-items: center;
            gap: 0;
            margin-bottom: 1.8rem;
        }
        .step-item {
            display: flex;
            align-items: center;
            gap: 6px;
            flex: 1;
        }
        .step-dot {
            width: 22px; height: 22px;
            border-radius: 50%;
            border: 1.5px solid #333;
            background: transparent;
            display: flex; align-items: center; justify-content: center;
            font-size: 10px;
            color: #555;
            font-weight: 600;
            flex-shrink: 0;
            transition: all 0.3s ease;
        }
        .step-dot.active { border-color: #FF6044; background: #FF6044; color: #fff; }
        .step-dot.done { border-color: #FF6044; background: rgba(255,96,68,0.15); color: #FF6044; }
        .step-label { font-size: 10px; color: #555; letter-spacing: 0.5px; text-transform: uppercase; transition: color 0.3s; }
        .step-label.active { color: #FF6044; }
        .step-connector { flex: 1; height: 0.5px; background: #222; margin: 0 8px; }

        /* Form fields */
        .field-group { margin-bottom: 1rem; }
        .field-label { font-size: 11px; color: #888; margin-bottom: 6px; display: block; letter-spacing: 0.5px; text-transform: uppercase; }
        .field-input {
            width: 100%;
            background: #0c0d0e;
            border: 0.5px solid #2a2c2c;
            border-radius: 10px;
            padding: 11px 14px;
            font-size: 14px;
            color: #e8e8e8;
            outline: none;
            transition: border-color 0.2s, box-shadow 0.2s;
            appearance: none;
            -webkit-appearance: none;
        }
        .field-input::placeholder { color: #3a3c3c; }
        .field-input:focus {
            border-color: #FF6044;
            box-shadow: 0 0 0 3px rgba(255,96,68,0.08);
        }
        .field-input.error { border-color: #e05555; }

        /* Password strength */
        .strength-bar {
            display: flex;
            gap: 3px;
            margin-top: 8px;
        }
        .strength-seg {
            flex: 1;
            height: 3px;
            border-radius: 2px;
            background: #1e2020;
            transition: background 0.3s;
        }
        .strength-label { font-size: 10px; color: #555; margin-top: 4px; }

        /* Field with icon */
        .field-wrap { position: relative; }
        .field-icon {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #444;
            cursor: pointer;
            display: flex;
            align-items: center;
            transition: color 0.2s;
        }
        .field-icon:hover { color: #FF6044; }
        .field-wrap .field-input { padding-right: 38px; }

        /* Role selector */
        .role-label { font-size: 11px; color: #888; margin-bottom: 8px; display: block; letter-spacing: 0.5px; text-transform: uppercase; }
        .role-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 6px;
            margin-bottom: 1rem;
        }
        .role-card {
            padding: 8px 6px;
            border-radius: 8px;
            border: 0.5px solid #2a2c2c;
            background: #0c0d0e;
            color: #666;
            font-size: 11px;
            cursor: pointer;
            text-align: center;
            transition: all 0.2s;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 4px;
            letter-spacing: 0.3px;
        }
        .role-card:hover { border-color: #3a3a3a; color: #aaa; }
        .role-card.active { border-color: #FF6044; color: #FF6044; background: rgba(255,96,68,0.06); }
        .role-card svg { opacity: 0.6; transition: opacity 0.2s; }
        .role-card.active svg { opacity: 1; }

        /* Error messages */
        .field-error { font-size: 11px; color: #e05555; margin-top: 5px; }
        .alert-error {
            background: rgba(224,85,85,0.08);
            border: 0.5px solid rgba(224,85,85,0.25);
            border-radius: 8px;
            padding: 10px 14px;
            margin-bottom: 1.2rem;
            font-size: 12px;
            color: #e05555;
        }

        /* Actions */
        .actions { margin-top: 1.4rem; }
        .register-btn {
            width: 100%;
            background: #FF6044;
            color: #fff;
            border: none;
            border-radius: 10px;
            padding: 12px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: background 0.2s, transform 0.1s;
            letter-spacing: 0.5px;
            position: relative;
            overflow: hidden;
        }
        .register-btn::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(255,255,255,0.08) 0%, transparent 100%);
            pointer-events: none;
        }
        .register-btn:hover { background: #e5532e; }
        .register-btn:active { transform: scale(0.99); }

        .divider { display: flex; align-items: center; gap: 10px; margin: 1.3rem 0; }
        .divider-line { flex: 1; height: 0.5px; background: #1e2020; }
        .divider-text { font-size: 11px; color: #444; }

        .login-row { text-align: center; font-size: 13px; color: #555; }
        .login-row a { color: #FF6044; text-decoration: none; transition: color 0.2s; }
        .login-row a:hover { color: #ff7a62; }

        /* Terms */
        .terms-note {
            font-size: 10px;
            color: #3a3c3c;
            text-align: center;
            margin-top: 1rem;
            line-height: 1.5;
        }
        .terms-note a { color: #555; text-decoration: underline; }

        /* Inline two-col */
        .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
    </style>
</head>
<body>

<div class="register-card">

    <!-- Brand -->
    <div class="brand-bar">
        <div class="brand-logo">
            <svg viewBox="0 0 24 24" fill="none">
                <path d="M4 6h16M4 10h16M8 14h8M10 18h4" stroke="#fff" stroke-width="2" stroke-linecap="round"/>
            </svg>
        </div>
        <div>
            <div class="brand-name">OTRS</div>
            <div class="brand-sub">Online Ticket Reservation</div>
        </div>
    </div>

    <!-- Header -->
    <p class="register-title">Create your account</p>
    <p class="register-sub">Join OTRS and start booking your trips</p>

    <!-- Step indicator -->
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

    <!-- Errors -->
    <?php if($errors->any()): ?>
        <div class="alert-error"><?php echo e($errors->first()); ?></div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('register')); ?>" id="registerForm">
        <?php echo csrf_field(); ?>

        <!-- STEP 1: Account Info -->
        <div id="step1">
            <div class="field-group">
                <label class="field-label" for="name">Full Name</label>
                <div class="field-wrap">
                    <input
                        class="field-input <?php echo e($errors->has('name') ? 'error' : ''); ?>"
                        id="name"
                        type="text"
                        name="name"
                        value="<?php echo e(old('name')); ?>"
                        placeholder="Juan dela Cruz"
                        required autofocus autocomplete="name"
                    >
                </div>
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
                <div class="field-wrap">
                    <input
                        class="field-input <?php echo e($errors->has('email') ? 'error' : ''); ?>"
                        id="email"
                        type="email"
                        name="email"
                        value="<?php echo e(old('email')); ?>"
                        placeholder="juan@example.com"
                        required autocomplete="username"
                    >
                </div>
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

            <div style="text-align:right; margin-top: 1.4rem;">
                <button type="button" class="register-btn" onclick="goToStep(2)" style="width:auto; padding: 11px 28px;">
                    Continue →
                </button>
            </div>
        </div>

        <!-- STEP 2: Password -->
        <div id="step2" style="display:none;">
            <div class="field-group">
                <label class="field-label" for="password">Password</label>
                <div class="field-wrap">
                    <input
                        class="field-input <?php echo e($errors->has('password') ? 'error' : ''); ?>"
                        id="password"
                        type="password"
                        name="password"
                        placeholder="Minimum 8 characters"
                        required autocomplete="new-password"
                        oninput="checkStrength(this.value)"
                    >
                    <span class="field-icon" onclick="togglePass('password', this)">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
                    </span>
                </div>
                <div class="strength-bar">
                    <div class="strength-seg" id="s1"></div>
                    <div class="strength-seg" id="s2"></div>
                    <div class="strength-seg" id="s3"></div>
                    <div class="strength-seg" id="s4"></div>
                </div>
                <div class="strength-label" id="strength-text"></div>
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
                    <input
                        class="field-input"
                        id="password_confirmation"
                        type="password"
                        name="password_confirmation"
                        placeholder="Re-enter your password"
                        required autocomplete="new-password"
                    >
                    <span class="field-icon" onclick="togglePass('password_confirmation', this)">
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
                    </span>
                </div>
            </div>

            <div style="display:flex; gap:10px; margin-top: 1.4rem;">
                <button type="button" class="register-btn" onclick="goToStep(1)"
                    style="width:auto; padding: 11px 20px; background:#1a1c1c; color:#888; border: 0.5px solid #2a2c2c;">
                    ← Back
                </button>
                <button type="button" class="register-btn" onclick="goToStep(3)" style="flex:1;">
                    Continue →
                </button>
            </div>
        </div>

        <!-- STEP 3: Role selection + submit -->
        <div id="step3" style="display:none;">
            <span class="role-label">I am registering as</span>
            <div class="role-grid">
                <div class="role-card active" onclick="setRole(this,'traveler')">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/><circle cx="9" cy="7" r="4" stroke="currentColor" stroke-width="1.5"/></svg>
                    Traveler
                </div>
                <div class="role-card" onclick="setRole(this,'tourist')">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Tourist
                </div>
                <div class="role-card" onclick="setRole(this,'business')">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><rect x="2" y="7" width="20" height="14" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M16 7V5a2 2 0 00-2-2h-4a2 2 0 00-2 2v2" stroke="currentColor" stroke-width="1.5"/></svg>
                    Business
                </div>
                <div class="role-card" onclick="setRole(this,'commuter')">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M8 17H5a2 2 0 01-2-2V5a2 2 0 012-2h14a2 2 0 012 2v10a2 2 0 01-2 2h-3m-4 0v4m0 0H8m4 0h4" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Commuter
                </div>
                <div class="role-card" onclick="setRole(this,'corporate')">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0H5m0 0H3" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Corporate
                </div>
                <div class="role-card" onclick="setRole(this,'passenger')">
                    <svg width="18" height="18" fill="none" viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/></svg>
                    Passenger
                </div>
            </div>
            <input type="hidden" name="role" id="selected-role" value="traveler">

            <div style="display:flex; gap:10px; margin-top: 1rem;">
                <button type="button" class="register-btn" onclick="goToStep(2)"
                    style="width:auto; padding: 11px 20px; background:#1a1c1c; color:#888; border: 0.5px solid #2a2c2c;">
                    ← Back
                </button>
                <button type="submit" class="register-btn" style="flex:1;">
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
// Step navigation
const totalSteps = 3;
function goToStep(n) {
    for (let i = 1; i <= totalSteps; i++) {
        document.getElementById('step' + i).style.display = i === n ? 'block' : 'none';
        const dot = document.getElementById('dot' + i);
        const lbl = document.getElementById('lbl' + i);
        if (i < n) {
            dot.classList.remove('active'); dot.classList.add('done');
            dot.innerHTML = '✓';
            lbl.classList.remove('active');
        } else if (i === n) {
            dot.classList.add('active'); dot.classList.remove('done');
            dot.innerHTML = i;
            lbl.classList.add('active');
        } else {
            dot.classList.remove('active','done');
            dot.innerHTML = i;
            lbl.classList.remove('active');
        }
    }
}

// Role selector
function setRole(el, role) {
    document.querySelectorAll('.role-card').forEach(c => c.classList.remove('active'));
    el.classList.add('active');
    document.getElementById('selected-role').value = role;
}

// Toggle password visibility
function togglePass(id, icon) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.style.color = input.type === 'text' ? '#FF6044' : '#444';
}

// Password strength
function checkStrength(val) {
    const segs = [document.getElementById('s1'), document.getElementById('s2'),
                  document.getElementById('s3'), document.getElementById('s4')];
    const label = document.getElementById('strength-text');
    const colors = { 0:'#1e2020', 1:'#e05555', 2:'#e09a44', 3:'#e0cc44', 4:'#4caf50' };

    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;

    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    const color = colors[score];

    segs.forEach((s, i) => s.style.background = i < score ? color : '#1e2020');
    label.textContent = val.length ? labels[score] : '';
    label.style.color = color;
}

// Auto-advance to errored step on page load
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