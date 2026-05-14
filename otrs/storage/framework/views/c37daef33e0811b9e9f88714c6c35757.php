<?php $__env->startSection('page-title', 'My Profile'); ?>

<?php $__env->startSection('content'); ?>
<style>
    /* ── Profile page styles ── */
    .profile-wrap {
        max-width: 680px;
        margin: 0 auto;
    }

    /* Page header */
    .profile-page-header {
        display: flex;
        align-items: center;
        gap: 16px;
        margin-bottom: 24px;
        padding-bottom: 20px;
        border-bottom: 0.5px solid #1e2020;
    }
    .profile-big-avatar {
        width: 64px; height: 64px;
        background: linear-gradient(135deg, #FF6044, #c94030);
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-size: 22px; font-weight: 700; color: #fff;
        letter-spacing: 1px;
        flex-shrink: 0;
        position: relative;
        box-shadow: 0 0 0 3px rgba(255,96,68,0.2);
    }
    .profile-badge {
        position: absolute;
        bottom: -2px; right: -2px;
        background: #4caf50;
        width: 16px; height: 16px;
        border-radius: 50%;
        border: 2.5px solid #121313;
    }
    .profile-header-info {}
    .profile-header-name { font-size: 20px; font-weight: 600; color: #fff; }
    .profile-header-meta { display: flex; align-items: center; gap: 8px; margin-top: 4px; flex-wrap: wrap; }
    .profile-header-email { font-size: 12px; color: #666; }
    .profile-role-pill {
        display: inline-flex; align-items: center; gap: 4px;
        background: rgba(255,96,68,0.1);
        border: 0.5px solid rgba(255,96,68,0.25);
        color: #FF6044; font-size: 10px;
        padding: 2px 8px; border-radius: 20px;
        text-transform: capitalize; letter-spacing: 0.5px;
    }

    /* Tabs */
    .profile-tabs {
        display: flex;
        gap: 2px;
        background: #1a1b1b;
        border-radius: 10px;
        padding: 4px;
        margin-bottom: 20px;
        border: 0.5px solid #2a2b2b;
    }
    .profile-tab {
        flex: 1; padding: 8px 10px;
        border-radius: 7px; border: none;
        background: none; color: #666;
        font-size: 12px; cursor: pointer;
        transition: all 0.2s;
        display: flex; align-items: center; justify-content: center; gap: 6px;
        font-family: inherit;
    }
    .profile-tab svg { width: 13px; height: 13px; }
    .profile-tab:hover { color: #aaa; background: rgba(255,255,255,0.04); }
    .profile-tab.active { background: #111213; color: #FF6044; border: 0.5px solid #2a2b2b; }

    /* Panel */
    .profile-panel { display: none; }
    .profile-panel.active { display: block; animation: fadeIn 0.2s ease; }
    @keyframes fadeIn { from { opacity:0; transform:translateY(4px); } to { opacity:1; transform:translateY(0); } }

    /* Card */
    .profile-card {
        background: #1a1b1b;
        border: 0.5px solid #2a2b2b;
        border-radius: 12px;
        padding: 20px 22px;
        margin-bottom: 16px;
    }
    .card-title { font-size: 13px; font-weight: 600; color: #ddd; margin-bottom: 4px; }
    .card-desc { font-size: 11px; color: #555; margin-bottom: 18px; }

    /* Form fields */
    .field-group { margin-bottom: 14px; }
    .field-label {
        font-size: 11px; color: #777;
        display: block; margin-bottom: 6px;
        letter-spacing: 0.5px; text-transform: uppercase;
    }
    .field-input {
        width: 100%;
        background: #111213;
        border: 0.5px solid #2a2b2b;
        border-radius: 8px;
        padding: 10px 12px;
        font-size: 13px; color: #ddd;
        outline: none;
        transition: border-color 0.2s, box-shadow 0.2s;
        font-family: inherit;
    }
    .field-input:focus { border-color: #FF6044; box-shadow: 0 0 0 3px rgba(255,96,68,0.07); }
    .field-input.error { border-color: #e05555; }
    .field-input[readonly] { color: #555; cursor: default; }
    .field-error { font-size: 11px; color: #e05555; margin-top: 5px; }

    /* Field hint */
    .field-hint { font-size: 11px; color: #444; margin-top: 5px; }

    /* Two column */
    .field-row { display: grid; grid-template-columns: 1fr 1fr; gap: 12px; }
    @media (max-width: 520px) { .field-row { grid-template-columns: 1fr; } }

    /* Field with icon */
    .field-wrap { position: relative; }
    .field-icon {
        position: absolute; right: 11px; top: 50%;
        transform: translateY(-50%);
        color: #444; cursor: pointer; display: flex; align-items: center;
        transition: color 0.2s;
    }
    .field-icon:hover { color: #FF6044; }
    .field-wrap .field-input { padding-right: 36px; }

    /* Password strength */
    .strength-row { display: flex; gap: 3px; margin-top: 8px; }
    .strength-seg { flex:1; height:3px; border-radius:2px; background:#1e2020; transition:background 0.3s; }
    .strength-text { font-size:10px; color:#555; margin-top:4px; }

    /* Buttons */
    .btn-primary {
        background: #FF6044; color: #fff;
        border: none; border-radius: 8px;
        padding: 10px 20px; font-size: 13px; font-weight: 500;
        cursor: pointer; transition: background 0.2s, transform 0.1s;
        font-family: inherit; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-primary:hover { background: #e5532e; }
    .btn-primary:active { transform: scale(0.98); }
    .btn-ghost {
        background: #1e2020; color: #888;
        border: 0.5px solid #2a2b2b; border-radius: 8px;
        padding: 10px 18px; font-size: 13px;
        cursor: pointer; transition: all 0.2s;
        font-family: inherit;
    }
    .btn-ghost:hover { background: #242626; color: #ccc; }
    .btn-danger {
        background: rgba(224,85,85,0.1); color: #e05555;
        border: 0.5px solid rgba(224,85,85,0.25); border-radius: 8px;
        padding: 10px 20px; font-size: 13px; font-weight: 500;
        cursor: pointer; transition: all 0.2s;
        font-family: inherit; display: inline-flex; align-items: center; gap: 6px;
    }
    .btn-danger:hover { background: rgba(224,85,85,0.18); border-color: #e05555; }

    /* Alerts */
    .alert-success {
        background: rgba(76,175,80,0.08);
        border: 0.5px solid rgba(76,175,80,0.25);
        border-radius: 8px; padding: 10px 14px; margin-bottom: 16px;
        font-size: 12px; color: #4caf50;
        display: flex; align-items: center; gap: 8px;
    }
    .alert-error {
        background: rgba(224,85,85,0.08);
        border: 0.5px solid rgba(224,85,85,0.25);
        border-radius: 8px; padding: 10px 14px; margin-bottom: 16px;
        font-size: 12px; color: #e05555;
    }

    /* Info row */
    .info-row {
        display: flex; align-items: center; justify-content: space-between;
        padding: 10px 0; border-bottom: 0.5px solid #1e2020;
        gap: 12px;
    }
    .info-row:last-child { border-bottom: none; padding-bottom: 0; }
    .info-label { font-size: 11px; color: #555; text-transform: uppercase; letter-spacing: 0.5px; }
    .info-value { font-size: 13px; color: #ccc; text-align: right; }
    .info-badge {
        display: inline-block; padding: 2px 8px;
        border-radius: 20px; font-size: 10px;
        background: rgba(255,96,68,0.1);
        border: 0.5px solid rgba(255,96,68,0.25);
        color: #FF6044; text-transform: capitalize;
    }

    /* Danger zone */
    .danger-zone {
        background: rgba(224,85,85,0.04);
        border: 0.5px solid rgba(224,85,85,0.15);
        border-radius: 12px; padding: 20px 22px;
    }
    .danger-title { font-size: 13px; font-weight: 600; color: #e05555; margin-bottom: 4px; }
    .danger-desc { font-size: 11px; color: #555; margin-bottom: 16px; line-height: 1.5; }

    /* Modal */
    .modal-backdrop {
        display: none; position: fixed; inset: 0;
        background: rgba(0,0,0,0.7); z-index: 500;
        backdrop-filter: blur(4px);
        align-items: center; justify-content: center;
    }
    .modal-backdrop.open { display: flex; }
    .modal-box {
        background: #1a1b1b; border: 0.5px solid #2a2b2b;
        border-radius: 14px; padding: 24px;
        width: 100%; max-width: 380px; margin: 0 16px;
        animation: slideUp 0.25s cubic-bezier(0.16,1,0.3,1);
    }
    @keyframes slideUp { from{opacity:0;transform:translateY(16px);} to{opacity:1;transform:translateY(0);} }
    .modal-title { font-size: 16px; font-weight: 600; color: #fff; margin-bottom: 6px; }
    .modal-desc { font-size: 12px; color: #666; margin-bottom: 18px; line-height: 1.5; }
    .modal-actions { display: flex; gap: 10px; justify-content: flex-end; margin-top: 18px; }

    /* Actions row */
    .form-actions { display: flex; align-items: center; gap: 10px; margin-top: 6px; flex-wrap: wrap; }
</style>

<div class="profile-wrap">

    <!-- Page header -->
    <div class="profile-page-header">
        <div class="profile-big-avatar">
            <?php echo e(strtoupper(substr($user->name, 0, 2))); ?>

            <div class="profile-badge"></div>
        </div>
        <div class="profile-header-info">
            <div class="profile-header-name"><?php echo e($user->name); ?></div>
            <div class="profile-header-meta">
                <span class="profile-header-email"><?php echo e($user->email); ?></span>
                <span class="profile-role-pill">
                    <svg width="9" height="9" viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="2"/><path d="M12 6v6l4 2" stroke="currentColor" stroke-width="2"/></svg>
                    <?php echo e($user->role ?? 'passenger'); ?>

                </span>
            </div>
        </div>
    </div>

    <!-- Flash messages -->
    <?php if(session('status') === 'profile-updated'): ?>
        <div class="alert-success">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2"/></svg>
            Profile information updated successfully.
        </div>
    <?php endif; ?>
    <?php if(session('status') === 'password-updated'): ?>
        <div class="alert-success">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2"/></svg>
            Password changed successfully.
        </div>
    <?php endif; ?>

    <!-- Tabs -->
    <div class="profile-tabs" role="tablist">
        <button class="profile-tab active" id="tab-info" onclick="switchTab('info')" role="tab">
            <svg viewBox="0 0 24 24" fill="none"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="7" r="4" stroke="currentColor" stroke-width="1.5"/></svg>
            Profile Info
        </button>
        <button class="profile-tab" id="tab-password" onclick="switchTab('password')" role="tab">
            <svg viewBox="0 0 24 24" fill="none"><rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.5"/></svg>
            Security
        </button>
        <button class="profile-tab" id="tab-account" onclick="switchTab('account')" role="tab">
            <svg viewBox="0 0 24 24" fill="none"><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z" stroke="currentColor" stroke-width="1.5"/></svg>
            Account
        </button>
    </div>

    <!-- TAB: Profile Info -->
    <div class="profile-panel active" id="panel-info">
        <div class="profile-card">
            <div class="card-title">Personal Information</div>
            <div class="card-desc">Update your name and email address</div>

            <?php if($errors->get('name') || $errors->get('email')): ?>
                <div class="alert-error"><?php echo e($errors->first()); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('profile.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('patch'); ?>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label" for="name">Full Name</label>
                        <input class="field-input <?php echo e($errors->has('name') ? 'error' : ''); ?>"
                            id="name" name="name" type="text"
                            value="<?php echo e(old('name', $user->name)); ?>"
                            required autofocus autocomplete="name">
                        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="email">Email Address</label>
                        <input class="field-input <?php echo e($errors->has('email') ? 'error' : ''); ?>"
                            id="email" name="email" type="email"
                            value="<?php echo e(old('email', $user->email)); ?>"
                            required autocomplete="username">
                        <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                </div>

                <?php if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail()): ?>
                    <div class="alert-error" style="margin-top: 0; margin-bottom:14px;">
                        Your email address is unverified.
                        <form id="send-verification" method="post" action="<?php echo e(route('verification.send')); ?>" style="display:inline;">
                            <?php echo csrf_field(); ?>
                            <button type="submit" style="background:none;border:none;color:#e05555;text-decoration:underline;cursor:pointer;font-size:12px;padding:0;">
                                Resend verification email
                            </button>
                        </form>
                        <?php if(session('status') === 'verification-link-sent'): ?>
                            <div style="color:#4caf50;font-size:11px;margin-top:4px;">Verification link sent!</div>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><path d="M20 6L9 17l-5-5" stroke="currentColor" stroke-width="2"/></svg>
                        Save Changes
                    </button>
                </div>
            </form>
        </div>

        <!-- Read-only account overview -->
        <div class="profile-card">
            <div class="card-title">Account Overview</div>
            <div class="card-desc">Your account details at a glance</div>

            <div class="info-row">
                <span class="info-label">Member Since</span>
                <span class="info-value"><?php echo e($user->created_at->format('F j, Y')); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Account Role</span>
                <span class="info-value"><span class="info-badge"><?php echo e($user->role ?? 'passenger'); ?></span></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email Status</span>
                <span class="info-value" style="color: <?php echo e($user->email_verified_at ? '#4caf50' : '#e09a44'); ?>; font-size:12px;">
                    <?php echo e($user->email_verified_at ? 'Verified' : 'Unverified'); ?>

                </span>
            </div>
            <div class="info-row">
                <span class="info-label">Last Updated</span>
                <span class="info-value"><?php echo e($user->updated_at->diffForHumans()); ?></span>
            </div>
        </div>
    </div>

    <!-- TAB: Security / Password -->
    <div class="profile-panel" id="panel-password">
        <div class="profile-card">
            <div class="card-title">Change Password</div>
            <div class="card-desc">Use a long, unique password to keep your account secure</div>

            <?php if($errors->updatePassword->any()): ?>
                <div class="alert-error"><?php echo e($errors->updatePassword->first()); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('password.update')); ?>">
                <?php echo csrf_field(); ?>
                <?php echo method_field('put'); ?>

                <div class="field-group">
                    <label class="field-label" for="current_password">Current Password</label>
                    <div class="field-wrap">
                        <input class="field-input <?php echo e($errors->updatePassword->has('current_password') ? 'error' : ''); ?>"
                            id="current_password" name="current_password" type="password"
                            placeholder="Your current password"
                            autocomplete="current-password">
                        <span class="field-icon" onclick="togglePass('current_password', this)">
                            <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
                        </span>
                    </div>
                    <?php $__errorArgs = ['current_password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                </div>

                <div class="field-row">
                    <div class="field-group">
                        <label class="field-label" for="password">New Password</label>
                        <div class="field-wrap">
                            <input class="field-input <?php echo e($errors->updatePassword->has('password') ? 'error' : ''); ?>"
                                id="password" name="password" type="password"
                                placeholder="Min. 8 characters"
                                autocomplete="new-password"
                                oninput="checkStrength(this.value)">
                            <span class="field-icon" onclick="togglePass('password', this)">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
                            </span>
                        </div>
                        <div class="strength-row">
                            <div class="strength-seg" id="s1"></div>
                            <div class="strength-seg" id="s2"></div>
                            <div class="strength-seg" id="s3"></div>
                            <div class="strength-seg" id="s4"></div>
                        </div>
                        <div class="strength-text" id="strength-text"></div>
                        <?php $__errorArgs = ['password', 'updatePassword'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> <div class="field-error"><?php echo e($message); ?></div> <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                    <div class="field-group">
                        <label class="field-label" for="password_confirmation">Confirm New Password</label>
                        <div class="field-wrap">
                            <input class="field-input"
                                id="password_confirmation" name="password_confirmation" type="password"
                                placeholder="Re-enter new password"
                                autocomplete="new-password">
                            <span class="field-icon" onclick="togglePass('password_confirmation', this)">
                                <svg width="15" height="15" fill="none" viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z" stroke="currentColor" stroke-width="1.5"/><circle cx="12" cy="12" r="3" stroke="currentColor" stroke-width="1.5"/></svg>
                            </span>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn-primary">
                        <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><rect x="3" y="11" width="18" height="11" rx="2" stroke="currentColor" stroke-width="1.5"/><path d="M7 11V7a5 5 0 0 1 10 0v4" stroke="currentColor" stroke-width="1.5"/></svg>
                        Update Password
                    </button>
                </div>
            </form>
        </div>

        <!-- Security tips -->
        <div class="profile-card" style="background:#111213;">
            <div class="card-title" style="margin-bottom:12px;">Security Tips</div>
            <?php $__currentLoopData = [
                ['Use at least 12 characters with a mix of letters, numbers, and symbols.', '🔑'],
                ['Never reuse passwords across different websites.', '🛡️'],
                ['Consider using a password manager to stay secure.', '💡'],
            ]; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as [$tip, $icon]): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div style="display:flex;gap:10px;align-items:flex-start;padding:8px 0;border-bottom:0.5px solid #1a1b1b;">
                <span style="font-size:14px;flex-shrink:0;margin-top:1px;"><?php echo e($icon); ?></span>
                <span style="font-size:12px;color:#555;line-height:1.5;"><?php echo e($tip); ?></span>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

    <!-- TAB: Account Settings -->
    <div class="profile-panel" id="panel-account">
        <!-- Account summary card -->
        <div class="profile-card">
            <div class="card-title">Account Details</div>
            <div class="card-desc">Your account information and status</div>

            <div class="info-row">
                <span class="info-label">User ID</span>
                <span class="info-value" style="font-family:monospace;font-size:12px;color:#555;">#<?php echo e(str_pad($user->id, 6, '0', STR_PAD_LEFT)); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Full Name</span>
                <span class="info-value"><?php echo e($user->name); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Email</span>
                <span class="info-value" style="font-size:12px;"><?php echo e($user->email); ?></span>
            </div>
            <div class="info-row">
                <span class="info-label">Role</span>
                <span class="info-value"><span class="info-badge"><?php echo e($user->role ?? 'passenger'); ?></span></span>
            </div>
            <div class="info-row">
                <span class="info-label">Joined</span>
                <span class="info-value"><?php echo e($user->created_at->format('M d, Y')); ?></span>
            </div>
        </div>

        <!-- Danger zone -->
        <div class="danger-zone">
            <div class="danger-title">Danger Zone</div>
            <div class="danger-desc">
                Once your account is deleted, all of its resources and data will be permanently removed.
                This action cannot be undone — please be certain before proceeding.
            </div>
            <button type="button" class="btn-danger" onclick="openDeleteModal()">
                <svg width="13" height="13" viewBox="0 0 24 24" fill="none"><polyline points="3 6 5 6 21 6" stroke="currentColor" stroke-width="1.5"/><path d="M19 6l-1 14H6L5 6" stroke="currentColor" stroke-width="1.5"/><path d="M10 11v6M14 11v6" stroke="currentColor" stroke-width="1.5"/><path d="M9 6V4h6v2" stroke="currentColor" stroke-width="1.5"/></svg>
                Delete My Account
            </button>
        </div>
    </div>

</div>

<!-- Delete Account Modal -->
<div class="modal-backdrop" id="deleteModal" onclick="handleModalBackdrop(event)">
    <div class="modal-box">
        <div class="modal-title">Delete Account?</div>
        <div class="modal-desc">
            This will permanently delete your account and all associated data including bookings, tickets, and payment history. This action cannot be reversed.
        </div>

        <?php if($errors->userDeletion->any()): ?>
            <div class="alert-error"><?php echo e($errors->userDeletion->first()); ?></div>
        <?php endif; ?>

        <form method="POST" action="<?php echo e(route('profile.destroy')); ?>">
            <?php echo csrf_field(); ?>
            <?php echo method_field('delete'); ?>

            <div class="field-group">
                <label class="field-label" for="delete_password">Confirm your password</label>
                <input class="field-input" id="delete_password" name="password" type="password" placeholder="Enter your password" required>
            </div>

            <div class="modal-actions">
                <button type="button" class="btn-ghost" onclick="closeDeleteModal()">Cancel</button>
                <button type="submit" class="btn-danger">Delete Account</button>
            </div>
        </form>
    </div>
</div>

<script>
// Tab switching
function switchTab(tab) {
    ['info','password','account'].forEach(t => {
        document.getElementById('panel-' + t).classList.remove('active');
        document.getElementById('tab-' + t).classList.remove('active');
    });
    document.getElementById('panel-' + tab).classList.add('active');
    document.getElementById('tab-' + tab).classList.add('active');
}

// Show password / security tab if there are password errors
<?php if($errors->updatePassword->any()): ?>
    switchTab('password');
<?php elseif($errors->userDeletion->any()): ?>
    switchTab('account');
    openDeleteModal();
<?php endif; ?>

// Hash-based tab navigation
if (window.location.hash === '#password') switchTab('password');
if (window.location.hash === '#account') switchTab('account');

// Password toggle
function togglePass(id, icon) {
    const input = document.getElementById(id);
    input.type = input.type === 'password' ? 'text' : 'password';
    icon.style.color = input.type === 'text' ? '#FF6044' : '#444';
}

// Password strength
function checkStrength(val) {
    const segs = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
    const label = document.getElementById('strength-text');
    const colors = { 0:'#1e2020', 1:'#e05555', 2:'#e09a44', 3:'#e0cc44', 4:'#4caf50' };
    let score = 0;
    if (val.length >= 8) score++;
    if (/[A-Z]/.test(val)) score++;
    if (/[0-9]/.test(val)) score++;
    if (/[^A-Za-z0-9]/.test(val)) score++;
    const labels = ['', 'Weak', 'Fair', 'Good', 'Strong'];
    segs.forEach((s, i) => s.style.background = i < score ? colors[score] : '#1e2020');
    label.textContent = val.length ? labels[score] : '';
    label.style.color = colors[score];
}

// Modal
function openDeleteModal() {
    document.getElementById('deleteModal').classList.add('open');
    document.body.style.overflow = 'hidden';
}
function closeDeleteModal() {
    document.getElementById('deleteModal').classList.remove('open');
    document.body.style.overflow = '';
}
function handleModalBackdrop(e) {
    if (e.target === document.getElementById('deleteModal')) closeDeleteModal();
}
document.addEventListener('keydown', e => { if (e.key === 'Escape') closeDeleteModal(); });
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/profile/edit.blade.php ENDPATH**/ ?>