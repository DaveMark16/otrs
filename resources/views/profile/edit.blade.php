@extends('layouts.user')
@section('page-title', 'My Profile')

@section('content')
<style>
/* ── Page header ────────────────────────────────────── */
.page-eyebrow { font-size:.67rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:6px;display:flex;align-items:center;gap:7px; }
.page-eyebrow::before { content:'';display:block;width:28px;height:2px;background:var(--gold);border-radius:2px; }
.page-title { font-family:var(--ff-head);font-size:1.85rem;font-weight:900;color:var(--brown);line-height:1.15;margin-bottom:4px; }
.page-title em { color:var(--teal);font-style:italic; }
.page-subtitle { font-size:.82rem;color:rgba(59,42,26,.42);margin-bottom:26px; }

/* ── Profile header card ────────────────────────────── */
.profile-header-card {
  background:var(--white);
  border:1.5px solid rgba(59,42,26,.08);
  border-radius:var(--radius);
  padding:24px 28px;
  display:flex;
  align-items:center;
  gap:20px;
  margin-bottom:22px;
  box-shadow:0 2px 12px rgba(59,42,26,.05);
  position:relative;
  overflow:hidden;
}
.profile-header-card::before {
  content:'';position:absolute;top:0;left:0;right:0;height:3px;
  background:linear-gradient(90deg,var(--teal),var(--gold));
}
.profile-avatar {
  width:68px;height:68px;border-radius:50%;flex-shrink:0;
  background:linear-gradient(135deg,var(--gold),var(--tan));
  display:flex;align-items:center;justify-content:center;
  font-family:var(--ff-head);font-size:1.5rem;font-weight:900;color:var(--brown);
  box-shadow:0 0 0 4px rgba(45,110,110,.12);
  position:relative;
}
.avatar-online {
  position:absolute;bottom:2px;right:2px;
  width:14px;height:14px;border-radius:50%;
  background:#4caf50;border:2.5px solid var(--white);
}
.profile-header-info {}
.profile-header-name { font-family:var(--ff-head);font-size:1.3rem;font-weight:900;color:var(--brown); }
.profile-header-meta { display:flex;align-items:center;gap:8px;margin-top:5px;flex-wrap:wrap; }
.profile-header-email { font-size:.78rem;color:rgba(59,42,26,.45); }
.profile-role-pill {
  display:inline-flex;align-items:center;gap:4px;
  background:rgba(45,110,110,.08);border:1px solid rgba(45,110,110,.2);
  color:var(--teal);font-size:.68rem;font-weight:700;
  padding:2px 9px;border-radius:20px;text-transform:capitalize;letter-spacing:.04em;
}
.profile-role-pill svg { width:9px;height:9px; }

/* ── Tabs ───────────────────────────────────────────── */
.profile-tabs {
  display:flex;gap:4px;
  background:var(--sand);
  border:1.5px solid rgba(59,42,26,.08);
  border-radius:var(--radius);
  padding:5px;
  margin-bottom:20px;
}
.profile-tab {
  flex:1;padding:9px 12px;
  border-radius:calc(var(--radius) - 4px);border:none;
  background:none;color:rgba(59,42,26,.4);
  font-size:.78rem;font-weight:600;cursor:pointer;
  transition:all .18s;font-family:var(--ff-body);
  display:flex;align-items:center;justify-content:center;gap:6px;
}
.profile-tab svg { width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:1.8; }
.profile-tab:hover { color:var(--teal);background:rgba(45,110,110,.06); }
.profile-tab.active {
  background:var(--white);color:var(--teal);
  box-shadow:0 2px 8px rgba(59,42,26,.08);
  border:1.5px solid rgba(59,42,26,.07);
}

/* ── Panel ──────────────────────────────────────────── */
.profile-panel { display:none; }
.profile-panel.active { display:block;animation:fadeIn .2s ease; }
@keyframes fadeIn { from{opacity:0;transform:translateY(4px);}to{opacity:1;transform:translateY(0);} }

/* ── Card ───────────────────────────────────────────── */
.profile-card {
  background:var(--white);
  border:1.5px solid rgba(59,42,26,.08);
  border-radius:var(--radius);
  padding:22px 26px;
  margin-bottom:16px;
  box-shadow:0 2px 12px rgba(59,42,26,.04);
}
.card-title { font-family:var(--ff-head);font-size:1rem;font-weight:700;color:var(--brown);margin-bottom:3px; }
.card-desc { font-size:.75rem;color:rgba(59,42,26,.38);margin-bottom:20px; }

/* ── Form fields ────────────────────────────────────── */
.field-group { margin-bottom:14px; }
.field-label {
  font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;
  color:rgba(59,42,26,.4);display:block;margin-bottom:7px;
}
.field-input {
  width:100%;
  background:var(--sand);
  border:1.5px solid rgba(59,42,26,.1);
  border-radius:10px;
  padding:10px 14px;
  font-size:.85rem;color:var(--brown);
  outline:none;transition:border-color .2s,box-shadow .2s;
  font-family:var(--ff-body);
}
.field-input:focus { border-color:var(--teal);box-shadow:0 0 0 3px rgba(45,110,110,.08); }
.field-input.error { border-color:#b44444; }
.field-input[readonly] { color:rgba(59,42,26,.35);cursor:default; }
.field-error { font-size:.72rem;color:#b44444;margin-top:5px; }
.field-hint  { font-size:.72rem;color:rgba(59,42,26,.35);margin-top:5px; }

/* Two-column row */
.field-row { display:grid;grid-template-columns:1fr 1fr;gap:14px; }
@media(max-width:520px){ .field-row { grid-template-columns:1fr; } }

/* Field with icon */
.field-wrap { position:relative; }
.field-icon {
  position:absolute;right:12px;top:50%;transform:translateY(-50%);
  color:rgba(59,42,26,.3);cursor:pointer;display:flex;align-items:center;
  transition:color .2s;
}
.field-icon:hover { color:var(--teal); }
.field-icon svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:1.5; }
.field-wrap .field-input { padding-right:38px; }

/* Strength bar */
.strength-row { display:flex;gap:3px;margin-top:8px; }
.strength-seg { flex:1;height:3px;border-radius:2px;background:rgba(59,42,26,.08);transition:background .3s; }
.strength-text { font-size:.68rem;color:rgba(59,42,26,.35);margin-top:4px; }

/* ── Buttons ────────────────────────────────────────── */
.btn-primary {
  background:var(--teal);color:var(--white);
  border:none;border-radius:50px;
  padding:10px 22px;font-size:.84rem;font-weight:600;
  cursor:pointer;transition:all .18s;
  font-family:var(--ff-body);display:inline-flex;align-items:center;gap:7px;
  box-shadow:0 4px 14px rgba(45,110,110,.25);
}
.btn-primary svg { width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2; }
.btn-primary:hover { background:var(--teal-lt);transform:translateY(-1px); }
.btn-primary:active { transform:scale(.98); }

.btn-ghost {
  background:var(--sand);color:rgba(59,42,26,.5);
  border:1.5px solid rgba(59,42,26,.1);border-radius:50px;
  padding:10px 20px;font-size:.84rem;font-weight:600;
  cursor:pointer;transition:all .18s;font-family:var(--ff-body);
}
.btn-ghost:hover { background:rgba(59,42,26,.07);color:var(--brown); }

.btn-danger {
  background:rgba(180,60,60,.08);color:#b44444;
  border:1.5px solid rgba(180,60,60,.2);border-radius:50px;
  padding:10px 22px;font-size:.84rem;font-weight:600;
  cursor:pointer;transition:all .18s;
  font-family:var(--ff-body);display:inline-flex;align-items:center;gap:7px;
}
.btn-danger svg { width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:1.8; }
.btn-danger:hover { background:rgba(180,60,60,.14);border-color:rgba(180,60,60,.4); }

.form-actions { display:flex;align-items:center;gap:10px;margin-top:8px;flex-wrap:wrap; }

/* ── Alerts ─────────────────────────────────────────── */
.alert { padding:11px 16px;border-radius:10px;font-size:.8rem;font-weight:600;margin-bottom:16px;display:flex;align-items:center;gap:8px; }
.alert svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0; }
.alert-success { background:rgba(45,110,110,.08);border:1.5px solid rgba(45,110,110,.2);color:var(--teal); }
.alert-error   { background:rgba(180,60,60,.07);border:1.5px solid rgba(180,60,60,.2);color:#b44444; }

/* ── Info rows ──────────────────────────────────────── */
.info-row {
  display:flex;align-items:center;justify-content:space-between;
  padding:11px 0;border-bottom:1.5px solid rgba(59,42,26,.06);gap:12px;
}
.info-row:last-child { border-bottom:none;padding-bottom:0; }
.info-label { font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.35); }
.info-value { font-size:.83rem;color:var(--brown);text-align:right; }
.info-badge {
  display:inline-block;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:700;
  background:rgba(45,110,110,.08);border:1px solid rgba(45,110,110,.2);color:var(--teal);
  text-transform:capitalize;
}

/* ── Danger zone ────────────────────────────────────── */
.danger-zone {
  background:rgba(180,60,60,.03);
  border:1.5px solid rgba(180,60,60,.14);
  border-radius:var(--radius);padding:22px 26px;
}
.danger-title { font-family:var(--ff-head);font-size:1rem;font-weight:700;color:#b44444;margin-bottom:4px; }
.danger-desc { font-size:.78rem;color:rgba(59,42,26,.45);margin-bottom:18px;line-height:1.6; }

/* ── Security tips ──────────────────────────────────── */
.tip-row { display:flex;gap:10px;align-items:flex-start;padding:9px 0;border-bottom:1.5px solid rgba(59,42,26,.06); }
.tip-row:last-child { border-bottom:none; }
.tip-icon { font-size:14px;flex-shrink:0;margin-top:1px; }
.tip-text { font-size:.78rem;color:rgba(59,42,26,.45);line-height:1.55; }

/* ── Modal ──────────────────────────────────────────── */
.modal-backdrop {
  display:none;position:fixed;inset:0;
  background:rgba(59,42,26,.45);z-index:500;
  backdrop-filter:blur(4px);
  align-items:center;justify-content:center;
}
.modal-backdrop.open { display:flex; }
.modal-box {
  background:var(--white);border:1.5px solid rgba(59,42,26,.1);
  border-radius:var(--radius);padding:28px;
  width:100%;max-width:400px;margin:0 16px;
  animation:slideUp .25s cubic-bezier(.16,1,.3,1);
  box-shadow:0 20px 60px rgba(59,42,26,.2);
}
@keyframes slideUp { from{opacity:0;transform:translateY(16px);}to{opacity:1;transform:translateY(0);} }
.modal-title { font-family:var(--ff-head);font-size:1.2rem;font-weight:900;color:var(--brown);margin-bottom:6px; }
.modal-desc { font-size:.8rem;color:rgba(59,42,26,.45);margin-bottom:18px;line-height:1.6; }
.modal-actions { display:flex;gap:10px;justify-content:flex-end;margin-top:20px; }
</style>

{{-- Page heading --}}
<div class="page-eyebrow">Account Settings</div>
<h1 class="page-title">My <em>Profile</em></h1>
<p class="page-subtitle">Manage your personal information, security, and account settings.</p>

{{-- Flash messages --}}
@if(session('status') === 'profile-updated')
  <div class="alert alert-success">
    <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
    Profile information updated successfully.
  </div>
@endif
@if(session('status') === 'password-updated')
  <div class="alert alert-success">
    <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
    Password changed successfully.
  </div>
@endif

{{-- Profile header --}}
<div class="profile-header-card">
  <div class="profile-avatar">
    {{ strtoupper(substr($user->name, 0, 2)) }}
    <div class="avatar-online"></div>
  </div>
  <div class="profile-header-info">
    <div class="profile-header-name">{{ $user->name }}</div>
    <div class="profile-header-meta">
      <span class="profile-header-email">{{ $user->email }}</span>
      <span class="profile-role-pill">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M12 6v6l4 2"/></svg>
        {{ $user->role ?? 'Traveler' }}
      </span>
    </div>
  </div>
</div>

{{-- Tabs --}}
<div class="profile-tabs" role="tablist">
  <button class="profile-tab active" id="tab-info" onclick="switchTab('info')" role="tab">
    <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
    Profile Info
  </button>
  <button class="profile-tab" id="tab-password" onclick="switchTab('password')" role="tab">
    <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
    Security
  </button>
  <button class="profile-tab" id="tab-account" onclick="switchTab('account')" role="tab">
    <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
    Account
  </button>
</div>

{{-- ── TAB: Profile Info ── --}}
<div class="profile-panel active" id="panel-info">

  <div class="profile-card">
    <div class="card-title">Personal Information</div>
    <div class="card-desc">Update your name and email address</div>

    @if($errors->get('name') || $errors->get('email'))
      <div class="alert alert-error">{{ $errors->first() }}</div>
    @endif

    <form method="POST" action="{{ route('profile.update') }}">
      @csrf
      @method('patch')

      <div class="field-row">
        <div class="field-group">
          <label class="field-label" for="name">Full Name</label>
          <input class="field-input {{ $errors->has('name') ? 'error' : '' }}"
            id="name" name="name" type="text"
            value="{{ old('name', $user->name) }}"
            required autofocus autocomplete="name">
          @error('name') <div class="field-error">{{ $message }}</div> @enderror
        </div>
        <div class="field-group">
          <label class="field-label" for="email">Email Address</label>
          <input class="field-input {{ $errors->has('email') ? 'error' : '' }}"
            id="email" name="email" type="email"
            value="{{ old('email', $user->email) }}"
            required autocomplete="username">
          @error('email') <div class="field-error">{{ $message }}</div> @enderror
        </div>
      </div>

      @if($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
        <div class="alert alert-error" style="margin-bottom:14px;">
          Your email address is unverified.
          <form id="send-verification" method="post" action="{{ route('verification.send') }}" style="display:inline;">
            @csrf
            <button type="submit" style="background:none;border:none;color:#b44444;text-decoration:underline;cursor:pointer;font-size:.78rem;padding:0;font-family:inherit;">
              Resend verification email
            </button>
          </form>
          @if(session('status') === 'verification-link-sent')
            <div style="color:var(--teal);font-size:.72rem;margin-top:4px;">Verification link sent!</div>
          @endif
        </div>
      @endif

      <div class="form-actions">
        <button type="submit" class="btn-primary">
          <svg viewBox="0 0 24 24"><path d="M20 6L9 17l-5-5"/></svg>
          Save Changes
        </button>
      </div>
    </form>
  </div>

  {{-- Account overview --}}
  <div class="profile-card">
    <div class="card-title">Account Overview</div>
    <div class="card-desc">Your account details at a glance</div>

    <div class="info-row">
      <span class="info-label">Member Since</span>
      <span class="info-value">{{ $user->created_at->format('F j, Y') }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Account Role</span>
      <span class="info-value"><span class="info-badge">{{ $user->role ?? 'Traveler' }}</span></span>
    </div>
    <div class="info-row">
      <span class="info-label">Email Status</span>
      <span class="info-value" style="color:{{ $user->email_verified_at ? 'var(--teal)' : '#b44444' }};font-size:.78rem;font-weight:600;">
        {{ $user->email_verified_at ? 'Verified' : 'Unverified' }}
      </span>
    </div>
    <div class="info-row">
      <span class="info-label">Last Updated</span>
      <span class="info-value">{{ $user->updated_at->diffForHumans() }}</span>
    </div>
  </div>
</div>

{{-- ── TAB: Security ── --}}
<div class="profile-panel" id="panel-password">
  <div class="profile-card">
    <div class="card-title">Change Password</div>
    <div class="card-desc">Use a long, unique password to keep your account secure</div>

    @if($errors->updatePassword->any())
      <div class="alert alert-error">{{ $errors->updatePassword->first() }}</div>
    @endif

    <form method="POST" action="{{ route('password.update') }}">
      @csrf
      @method('put')

      <div class="field-group">
        <label class="field-label" for="current_password">Current Password</label>
        <div class="field-wrap">
          <input class="field-input {{ $errors->updatePassword->has('current_password') ? 'error' : '' }}"
            id="current_password" name="current_password" type="password"
            placeholder="Your current password" autocomplete="current-password">
          <span class="field-icon" onclick="togglePass('current_password', this)">
            <svg viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
          </span>
        </div>
        @error('current_password', 'updatePassword') <div class="field-error">{{ $message }}</div> @enderror
      </div>

      <div class="field-row">
        <div class="field-group">
          <label class="field-label" for="password">New Password</label>
          <div class="field-wrap">
            <input class="field-input {{ $errors->updatePassword->has('password') ? 'error' : '' }}"
              id="password" name="password" type="password"
              placeholder="Min. 8 characters" autocomplete="new-password"
              oninput="checkStrength(this.value)">
            <span class="field-icon" onclick="togglePass('password', this)">
              <svg viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
            </span>
          </div>
          <div class="strength-row">
            <div class="strength-seg" id="s1"></div>
            <div class="strength-seg" id="s2"></div>
            <div class="strength-seg" id="s3"></div>
            <div class="strength-seg" id="s4"></div>
          </div>
          <div class="strength-text" id="strength-text"></div>
          @error('password', 'updatePassword') <div class="field-error">{{ $message }}</div> @enderror
        </div>
        <div class="field-group">
          <label class="field-label" for="password_confirmation">Confirm New Password</label>
          <div class="field-wrap">
            <input class="field-input"
              id="password_confirmation" name="password_confirmation" type="password"
              placeholder="Re-enter new password" autocomplete="new-password">
            <span class="field-icon" onclick="togglePass('password_confirmation', this)">
              <svg viewBox="0 0 24 24"><path d="M1 12s4-7 11-7 11 7 11 7-4 7-11 7-11-7-11-7z"/><circle cx="12" cy="12" r="3"/></svg>
            </span>
          </div>
        </div>
      </div>

      <div class="form-actions">
        <button type="submit" class="btn-primary">
          <svg viewBox="0 0 24 24"><rect x="3" y="11" width="18" height="11" rx="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
          Update Password
        </button>
      </div>
    </form>
  </div>

  <div class="profile-card">
    <div class="card-title" style="margin-bottom:12px;">Security Tips</div>
    @foreach([
      ['Use at least 12 characters with a mix of letters, numbers, and symbols.', '🔑'],
      ['Never reuse passwords across different websites.', '🛡️'],
      ['Consider using a password manager to stay secure.', '💡'],
    ] as [$tip, $icon])
    <div class="tip-row">
      <span class="tip-icon">{{ $icon }}</span>
      <span class="tip-text">{{ $tip }}</span>
    </div>
    @endforeach
  </div>
</div>

{{-- ── TAB: Account ── --}}
<div class="profile-panel" id="panel-account">
  <div class="profile-card">
    <div class="card-title">Account Details</div>
    <div class="card-desc">Your account information and status</div>

    <div class="info-row">
      <span class="info-label">User ID</span>
      <span class="info-value" style="font-family:monospace;font-size:.78rem;color:rgba(59,42,26,.4);">#{{ str_pad($user->id, 6, '0', STR_PAD_LEFT) }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Full Name</span>
      <span class="info-value">{{ $user->name }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Email</span>
      <span class="info-value" style="font-size:.8rem;">{{ $user->email }}</span>
    </div>
    <div class="info-row">
      <span class="info-label">Role</span>
      <span class="info-value"><span class="info-badge">{{ $user->role ?? 'Traveler' }}</span></span>
    </div>
    <div class="info-row">
      <span class="info-label">Joined</span>
      <span class="info-value">{{ $user->created_at->format('M d, Y') }}</span>
    </div>
  </div>

  <div class="danger-zone">
    <div class="danger-title">Danger Zone</div>
    <div class="danger-desc">
      Once your account is deleted, all of its resources and data will be permanently removed.
      This action cannot be undone — please be certain before proceeding.
    </div>
    <button type="button" class="btn-danger" onclick="openDeleteModal()">
      <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
      Delete My Account
    </button>
  </div>
</div>

{{-- Delete Modal --}}
<div class="modal-backdrop" id="deleteModal" onclick="handleModalBackdrop(event)">
  <div class="modal-box">
    <div class="modal-title">Delete Account?</div>
    <div class="modal-desc">
      This will permanently delete your account and all associated data including bookings, tickets, and payment history. This action cannot be reversed.
    </div>

    @if($errors->userDeletion->any())
      <div class="alert alert-error">{{ $errors->userDeletion->first() }}</div>
    @endif

    <form method="POST" action="{{ route('profile.destroy') }}">
      @csrf
      @method('delete')
      <div class="field-group">
        <label class="field-label" for="delete_password">Confirm your password</label>
        <input class="field-input" id="delete_password" name="password" type="password"
          placeholder="Enter your password" required>
      </div>
      <div class="modal-actions">
        <button type="button" class="btn-ghost" onclick="closeDeleteModal()">Cancel</button>
        <button type="submit" class="btn-danger">
          <svg viewBox="0 0 24 24"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14H6L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4h6v2"/></svg>
          Delete Account
        </button>
      </div>
    </form>
  </div>
</div>

<script>
function switchTab(tab) {
  ['info','password','account'].forEach(t => {
    document.getElementById('panel-' + t).classList.remove('active');
    document.getElementById('tab-' + t).classList.remove('active');
  });
  document.getElementById('panel-' + tab).classList.add('active');
  document.getElementById('tab-' + tab).classList.add('active');
}

@if($errors->updatePassword->any())
  switchTab('password');
@elseif($errors->userDeletion->any())
  switchTab('account');
  openDeleteModal();
@endif

if (window.location.hash === '#password') switchTab('password');
if (window.location.hash === '#account')  switchTab('account');

function togglePass(id, icon) {
  const input = document.getElementById(id);
  input.type = input.type === 'password' ? 'text' : 'password';
  icon.style.color = input.type === 'text' ? 'var(--teal)' : 'rgba(59,42,26,.3)';
}

function checkStrength(val) {
  const segs = ['s1','s2','s3','s4'].map(id => document.getElementById(id));
  const label = document.getElementById('strength-text');
  const colors = { 0:'rgba(59,42,26,.08)', 1:'#b44444', 2:'#e09a44', 3:'var(--gold)', 4:'var(--teal)' };
  let score = 0;
  if (val.length >= 8) score++;
  if (/[A-Z]/.test(val)) score++;
  if (/[0-9]/.test(val)) score++;
  if (/[^A-Za-z0-9]/.test(val)) score++;
  const labels = ['','Weak','Fair','Good','Strong'];
  segs.forEach((s, i) => s.style.background = i < score ? colors[score] : 'rgba(59,42,26,.08)');
  label.textContent = val.length ? labels[score] : '';
  label.style.color = colors[score];
}

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
@endsection