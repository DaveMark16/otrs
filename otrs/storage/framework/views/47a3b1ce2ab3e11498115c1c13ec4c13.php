<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
<meta charset="UTF-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<meta name="csrf-token" content="<?php echo e(csrf_token()); ?>" />
<title>OTRS — Dashboard</title>
<link rel="preconnect" href="https://fonts.googleapis.com" />
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
<style>
:root {
  --sand:    #f5ede0;
  --cream:   #faf6f0;
  --brown:   #3b2a1a;
  --tan:     #c49a6c;
  --gold:    #d4a254;
  --teal:    #2d6e6e;
  --teal-lt: #3d8f8f;
  --white:   #ffffff;
  --shadow:  0 8px 40px rgba(59,42,26,.10);
  --radius:  18px;
  --ff-head: 'Playfair Display', Georgia, serif;
  --ff-body: 'DM Sans', sans-serif;
  --sidebar-w: 260px;
}
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
html { scroll-behavior: smooth; }
body { font-family: var(--ff-body); background: var(--cream); color: var(--brown); min-height: 100vh; display: flex; }
a { text-decoration: none; color: inherit; }

/* Sidebar */
.sidebar { width: var(--sidebar-w); min-width: var(--sidebar-w); background: var(--brown); min-height: 100vh; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; overflow-y: auto; z-index: 100; }
.sb-brand { padding: 28px 24px 22px; border-bottom: 1px solid rgba(245,237,224,.1); flex-shrink: 0; }
.sb-logo { font-family: var(--ff-head); font-size: 1.7rem; font-weight: 900; color: var(--sand); letter-spacing: -.5px; }
.sb-logo span { color: var(--gold); }
.sb-tagline { font-size: .72rem; color: rgba(245,237,224,.38); margin-top: 3px; letter-spacing: .04em; }
.sb-user { display: flex; align-items: center; gap: 12px; padding: 18px 24px; border-bottom: 1px solid rgba(245,237,224,.1); }
.sb-avatar { width: 40px; height: 40px; background: linear-gradient(135deg, var(--gold), var(--tan)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: var(--brown); flex-shrink: 0; }
.sb-user-name { font-size: .88rem; font-weight: 600; color: var(--sand); }
.sb-user-role { font-size: .73rem; color: rgba(245,237,224,.4); margin-top: 1px; }
.sb-nav { flex: 1; padding: 18px 14px; }
.sb-section { font-size: .68rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: rgba(245,237,224,.3); padding: 10px 10px 6px; margin-top: 8px; }
.sb-item { display: flex; align-items: center; gap: 11px; padding: 10px 12px; border-radius: 10px; color: rgba(245,237,224,.6); font-size: .88rem; font-weight: 500; margin-bottom: 2px; transition: all .18s; }
.sb-item svg { width: 16px; height: 16px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.sb-item:hover { background: rgba(245,237,224,.08); color: var(--sand); }
.sb-item.active { background: rgba(212,162,84,.15); color: var(--gold); font-weight: 600; }
.sb-item.active svg { stroke: var(--gold); }
.sb-footer { padding: 16px 14px; border-top: 1px solid rgba(245,237,224,.1); }
.sb-logout { display: flex; align-items: center; gap: 10px; padding: 10px 12px; border-radius: 10px; color: rgba(245,237,224,.4); font-size: .85rem; cursor: pointer; transition: all .18s; background: none; border: none; font-family: var(--ff-body); width: 100%; }
.sb-logout svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; flex-shrink: 0; }
.sb-logout:hover { background: rgba(220,60,60,.12); color: #e07070; }

/* Main */
.main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
.topbar { background: var(--white); border-bottom: 1px solid rgba(59,42,26,.08); padding: 0 36px; height: 64px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
.topbar-title { font-family: var(--ff-head); font-size: 1.25rem; font-weight: 700; color: var(--brown); }
.topbar-right { display: flex; align-items: center; gap: 14px; }
.topbar-date { font-size: .8rem; color: rgba(59,42,26,.45); }
.topbar-book { background: var(--teal); color: var(--white); padding: .5rem 1.2rem; border-radius: 50px; font-size: .82rem; font-weight: 600; display: inline-flex; align-items: center; gap: .4rem; transition: background .18s, transform .15s; }
.topbar-book:hover { background: var(--teal-lt); transform: translateY(-1px); }
.topbar-book svg { width: 13px; height: 13px; stroke: currentColor; fill: none; stroke-width: 2.2; stroke-linecap: round; }
.content { padding: 32px 36px 48px; flex: 1; }

/* Greeting */
.greeting { margin-bottom: 28px; }
.greeting-eyebrow { display: flex; align-items: center; gap: .6rem; margin-bottom: .5rem; }
.greeting-eyebrow::before { content: ''; display: block; width: 28px; height: 2px; background: var(--gold); }
.greeting-eyebrow span { font-size: .75rem; font-weight: 600; letter-spacing: .12em; text-transform: uppercase; color: var(--gold); }
.greeting h1 { font-family: var(--ff-head); font-size: clamp(1.6rem, 3vw, 2.2rem); font-weight: 900; color: var(--brown); line-height: 1.15; }
.greeting h1 em { font-style: italic; color: var(--teal); }
.greeting-sub { font-size: .9rem; color: rgba(59,42,26,.55); margin-top: .4rem; }

/* Promo Banner */
.promo-banner { background: linear-gradient(135deg, rgba(45,110,110,.07) 0%, rgba(212,162,84,.06) 100%); border: 1.5px solid rgba(212,162,84,.3); border-radius: var(--radius); padding: 16px 22px; margin-bottom: 28px; display: flex; align-items: center; gap: 16px; flex-wrap: wrap; }
.promo-banner-icon { font-size: 22px; flex-shrink: 0; }
.promo-banner-body { flex: 1; min-width: 180px; }
.promo-banner-label { font-size: .72rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: var(--gold); margin-bottom: 5px; }
.promo-banner-codes { display: flex; flex-wrap: wrap; gap: 6px; }
.pbc { background: rgba(212,162,84,.12); border: 1px dashed rgba(212,162,84,.5); border-radius: 6px; padding: 3px 11px; font-size: .8rem; font-weight: 700; color: var(--gold); font-family: monospace; letter-spacing: 1.5px; cursor: pointer; transition: background .15s; }
.pbc:hover { background: rgba(212,162,84,.22); }
.promo-banner-cta { font-size: .8rem; font-weight: 600; color: var(--teal); border: 1.5px solid rgba(45,110,110,.3); border-radius: 50px; padding: .45rem 1.1rem; white-space: nowrap; transition: all .15s; flex-shrink: 0; }
.promo-banner-cta:hover { background: var(--teal); color: var(--white); }

/* Stats */
.stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 28px; }
.stat-card { background: var(--white); border-radius: var(--radius); padding: 22px 22px 20px; box-shadow: 0 2px 16px rgba(59,42,26,.06); border: 1px solid rgba(59,42,26,.07); transition: transform .2s, box-shadow .2s; position: relative; overflow: hidden; }
.stat-card::before { content: ''; position: absolute; top: 0; left: 0; right: 0; height: 3px; }
.stat-card.teal::before  { background: var(--teal); }
.stat-card.gold::before  { background: var(--gold); }
.stat-card.tan::before   { background: var(--tan); }
.stat-card.brown::before { background: var(--brown); }
.stat-card:hover { transform: translateY(-3px); box-shadow: 0 12px 36px rgba(59,42,26,.11); }
.stat-icon { width: 36px; height: 36px; border-radius: 10px; display: flex; align-items: center; justify-content: center; margin-bottom: 14px; }
.stat-icon.teal  { background: rgba(45,110,110,.1); color: var(--teal); }
.stat-icon.gold  { background: rgba(212,162,84,.12); color: var(--gold); }
.stat-icon.tan   { background: rgba(196,154,108,.12); color: var(--tan); }
.stat-icon.brown { background: rgba(59,42,26,.08); color: var(--brown); }
.stat-icon svg { width: 18px; height: 18px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.stat-label { font-size: .74rem; font-weight: 600; letter-spacing: .06em; text-transform: uppercase; color: rgba(59,42,26,.45); margin-bottom: 6px; }
.stat-value { font-family: var(--ff-head); font-size: 2rem; font-weight: 900; color: var(--brown); line-height: 1; }
.stat-sub { font-size: .75rem; color: rgba(59,42,26,.38); margin-top: 5px; }

/* Row 2 */
.row2 { display: grid; grid-template-columns: 1.55fr 1fr; gap: 20px; margin-bottom: 20px; }

/* Panel */
.panel { background: var(--white); border-radius: var(--radius); box-shadow: 0 2px 16px rgba(59,42,26,.06); border: 1px solid rgba(59,42,26,.07); overflow: hidden; }
.panel-head { display: flex; align-items: center; justify-content: space-between; padding: 20px 24px 0; margin-bottom: 16px; }
.panel-title { font-family: var(--ff-head); font-size: 1.05rem; font-weight: 700; color: var(--brown); display: flex; align-items: center; gap: 8px; }
.panel-title-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
.panel-link { font-size: .78rem; font-weight: 600; color: var(--teal); opacity: .8; transition: opacity .15s; }
.panel-link:hover { opacity: 1; }
.panel-body { padding: 0 24px 22px; }

/* Booking items */
.booking-item { display: flex; align-items: center; justify-content: space-between; padding: 12px 0; border-bottom: 1px solid rgba(59,42,26,.06); gap: 12px; }
.booking-item:last-child { border-bottom: none; }
.booking-route-wrap { display: flex; align-items: center; gap: 10px; }
.booking-plane-icon { width: 32px; height: 32px; background: rgba(45,110,110,.08); border-radius: 8px; display: flex; align-items: center; justify-content: center; color: var(--teal); font-size: 13px; flex-shrink: 0; }
.booking-route { font-size: .88rem; font-weight: 600; color: var(--brown); }
.booking-date  { font-size: .75rem; color: rgba(59,42,26,.45); margin-top: 2px; }
.booking-status { font-size: .72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; letter-spacing: .03em; white-space: nowrap; }
.status-confirmed { background: rgba(45,110,110,.1); color: var(--teal); }
.status-pending   { background: rgba(212,162,84,.12); color: #a07830; }
.status-ticketed  { background: rgba(59,42,26,.07); color: var(--brown); }
.status-cancelled { background: rgba(180,60,60,.08); color: #b44444; }

/* Quick actions */
.quick-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; }
.quick-btn { background: var(--sand); border: 1px solid rgba(59,42,26,.08); border-radius: 12px; padding: 16px 12px; text-align: center; text-decoration: none; transition: all .2s; display: flex; flex-direction: column; align-items: center; gap: 7px; }
.quick-btn:hover { background: rgba(45,110,110,.07); border-color: rgba(45,110,110,.2); transform: translateY(-2px); }
.quick-btn-icon { width: 34px; height: 34px; background: var(--white); border-radius: 9px; display: flex; align-items: center; justify-content: center; color: var(--teal); box-shadow: 0 2px 8px rgba(59,42,26,.08); }
.quick-btn-icon svg { width: 16px; height: 16px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
.quick-label { font-size: .77rem; font-weight: 600; color: rgba(59,42,26,.7); }

/* Upcoming */
.upcoming-item { display: flex; align-items: center; justify-content: space-between; padding: 14px 0; border-bottom: 1px solid rgba(59,42,26,.06); gap: 12px; }
.upcoming-item:last-child { border-bottom: none; }
.upcoming-route { font-size: .9rem; font-weight: 600; color: var(--brown); }
.upcoming-dep   { font-size: .78rem; color: rgba(59,42,26,.45); margin-top: 3px; }
.upcoming-country { font-size: .72rem; font-weight: 700; color: var(--teal); letter-spacing: .04em; }
.upcoming-badge { font-size: .72rem; font-weight: 700; padding: 3px 10px; border-radius: 20px; background: rgba(45,110,110,.1); color: var(--teal); }

/* Empty */
.empty { text-align: center; padding: 28px 16px; color: rgba(59,42,26,.35); font-size: .85rem; }
.empty-icon { font-size: 28px; opacity: .3; margin-bottom: 8px; }

/* Flash */
.flash { margin-bottom: 22px; padding: 12px 18px; border-radius: 12px; font-size: .88rem; font-weight: 500; }
.flash-success { background: rgba(45,110,110,.08); border: 1px solid rgba(45,110,110,.2); color: var(--teal); }
.flash-error   { background: rgba(180,60,60,.07); border: 1px solid rgba(180,60,60,.2); color: #b44444; }

/* Mobile */
.mobile-bar { display: none; background: var(--brown); padding: 14px 20px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 200; }
.hamburger { display: flex; flex-direction: column; gap: 5px; cursor: pointer; }
.hamburger span { width: 22px; height: 2px; background: var(--sand); border-radius: 2px; }
.sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(59,42,26,.5); z-index: 150; backdrop-filter: blur(2px); }

@media (max-width: 1100px) { .stats-grid { grid-template-columns: repeat(2, 1fr); } }
@media (max-width: 900px)  { .row2 { grid-template-columns: 1fr; } }
@media (max-width: 768px)  {
  body { flex-direction: column; }
  .sidebar { position: fixed; left: -100%; top: 0; height: 100vh; transition: left .28s ease; z-index: 200; }
  .sidebar.open { left: 0; }
  .sidebar-overlay.open { display: block; }
  .mobile-bar { display: flex; }
  .topbar { display: none; }
  .content { padding: 20px 18px 36px; }
  .stats-grid { grid-template-columns: repeat(2, 1fr); gap: 12px; }
}
</style>
</head>
<body>

<div class="mobile-bar">
  <div class="sb-logo" style="font-size:1.3rem;">OTR<span>S</span></div>
  <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
</div>
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
  <div class="sb-brand">
    <div class="sb-logo">OTR<span>S</span></div>
    <div class="sb-tagline">Online Tour Reservation System</div>
  </div>
  <div class="sb-user">
    <div class="sb-avatar"><?php echo e(strtoupper(substr(auth()->user()->name, 0, 1))); ?></div>
    <div>
      <div class="sb-user-name"><?php echo e(auth()->user()->name); ?></div>
      <div class="sb-user-role">Traveler</div>
    </div>
  </div>
  <nav class="sb-nav">
    <div class="sb-section">Main</div>
    <a href="<?php echo e(route('dashboard')); ?>" class="sb-item <?php echo e(request()->routeIs('dashboard') ? 'active' : ''); ?>" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
      Dashboard
    </a>
    <a href="<?php echo e(route('bookings.index')); ?>" class="sb-item <?php echo e(request()->routeIs('bookings.*') && !request()->routeIs('bookings.create') ? 'active' : ''); ?>" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      My Bookings
    </a>
    <a href="<?php echo e(route('tickets.index')); ?>" class="sb-item <?php echo e(request()->routeIs('tickets.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
      My Tickets
    </a>
    <a href="<?php echo e(route('bookings.create')); ?>" class="sb-item <?php echo e(request()->routeIs('bookings.create') || request()->routeIs('schedules.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
      Trips &amp; Schedules
    </a>
    <a href="<?php echo e(route('promos.index')); ?>" class="sb-item <?php echo e(request()->routeIs('promos.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg>
      Promo Codes
    </a>
    <div class="sb-section">Finance</div>
    <a href="<?php echo e(route('payments.index')); ?>" class="sb-item <?php echo e(request()->routeIs('payments.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2" ry="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
      Payments &amp; Refunds
    </a>
    <div class="sb-section">Account</div>
    <a href="<?php echo e(route('profile.edit')); ?>" class="sb-item <?php echo e(request()->routeIs('profile.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
      <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
      My Profile
    </a>
  </nav>
  <div class="sb-footer">
    <form method="POST" action="<?php echo e(route('logout')); ?>">
      <?php echo csrf_field(); ?>
      <button type="submit" class="sb-logout">
        <svg viewBox="0 0 24 24" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
        Sign Out
      </button>
    </form>
  </div>
</aside>

<div class="main">
  <div class="topbar">
    <div class="topbar-title">Welcome back, <em style="font-style:italic;color:var(--teal);"><?php echo e(explode(' ', auth()->user()->name)[0]); ?></em></div>
    <div class="topbar-right">
      <div class="topbar-date"><?php echo e(now()->format('l, F j, Y')); ?></div>
      <a href="<?php echo e(route('bookings.create')); ?>" class="topbar-book">
        <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
        Book a Trip
      </a>
    </div>
  </div>

  <div class="content">

    <?php if(session('success')): ?>
      <div class="flash flash-success"><?php echo e(session('success')); ?></div>
    <?php endif; ?>
    <?php if(session('error')): ?>
      <div class="flash flash-error"><?php echo e(session('error')); ?></div>
    <?php endif; ?>

    <div class="greeting">
      <div class="greeting-eyebrow"><span>Your Travel Hub</span></div>
      <h1>Hello, <em><?php echo e(explode(' ', auth()->user()->name)[0]); ?></em> 👋</h1>
      <div class="greeting-sub">Here's an overview of your journeys and upcoming adventures.</div>
    </div>

    <?php $activePromos = \App\Models\Promo::active()->orderBy('end_date')->limit(4)->get(); ?>
    <?php if($activePromos->isNotEmpty()): ?>
    <div class="promo-banner">
      <div class="promo-banner-icon">🏷️</div>
      <div class="promo-banner-body">
        <div class="promo-banner-label"><?php echo e($activePromos->count() === 1 ? 'Active Promo' : $activePromos->count() . ' Active Promos'); ?> — save on your next booking</div>
        <div class="promo-banner-codes">
          <?php $__currentLoopData = $activePromos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ap): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <span class="pbc" title="<?php echo e($ap->title); ?> · <?php echo e($ap->formatted_discount); ?> off"
              onclick="navigator.clipboard.writeText('<?php echo e($ap->promo_code); ?>').then(()=>{this.textContent='✓ Copied!';setTimeout(()=>this.textContent='<?php echo e($ap->promo_code); ?>',1600)})">
              <?php echo e($ap->promo_code); ?>

            </span>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      </div>
      <a href="<?php echo e(route('promos.index')); ?>" class="promo-banner-cta">View All Promos →</a>
    </div>
    <?php endif; ?>

    <div class="stats-grid">
      <div class="stat-card teal">
        <div class="stat-icon teal">
          <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
        </div>
        <div class="stat-label">Total Bookings</div>
        <div class="stat-value"><?php echo e($totalBookings); ?></div>
        <div class="stat-sub">All time reservations</div>
      </div>
      <div class="stat-card gold">
        <div class="stat-icon gold">
          <svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg>
        </div>
        <div class="stat-label">Active Tickets</div>
        <div class="stat-value"><?php echo e($activeTickets); ?></div>
        <div class="stat-sub"><?php echo e($upcomingTrips->count()); ?> upcoming</div>
      </div>
      <div class="stat-card tan">
        <div class="stat-icon tan">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
        </div>
        <div class="stat-label">Pending Payment</div>
        <div class="stat-value"><?php echo e($pendingPayments); ?></div>
        <div class="stat-sub">Awaiting confirmation</div>
      </div>
      <div class="stat-card brown">
        <div class="stat-icon brown">
          <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
        </div>
        <div class="stat-label">Total Spent</div>
        <div class="stat-value" style="font-size:1.5rem;">₱<?php echo e(number_format($totalSpent, 0)); ?></div>
        <div class="stat-sub">Confirmed bookings</div>
      </div>
    </div>

    <div class="row2">
      <div class="panel">
        <div class="panel-head">
          <div class="panel-title"><span class="panel-title-dot"></span> Recent Bookings</div>
          <a href="<?php echo e(route('bookings.index')); ?>" class="panel-link">View all →</a>
        </div>
        <div class="panel-body">
          <?php $__empty_1 = true; $__currentLoopData = $recentBookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $booking): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php $sched = $booking->schedule; $trip = $sched?->trip; ?>
            <div class="booking-item">
              <div class="booking-route-wrap">
                <div class="booking-plane-icon">✈</div>
                <div>
                  <div class="booking-route"><?php echo e($trip->origin_country ?? ($trip->origin ?? '?')); ?> → <?php echo e($trip->destination_country ?? ($trip->destination ?? '?')); ?></div>
                  <div class="booking-date"><?php echo e($sched?->departure_at?->format('M d, Y · h:i A') ?? '—'); ?></div>
                </div>
              </div>
              <?php
                $sc = match($booking->status) {
                  'confirmed' => 'status-confirmed',
                  'pending'   => 'status-pending',
                  'ticketed'  => 'status-ticketed',
                  'cancelled' => 'status-cancelled',
                  default     => 'status-pending',
                };
              ?>
              <span class="booking-status <?php echo e($sc); ?>"><?php echo e(ucfirst($booking->status)); ?></span>
            </div>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="empty"><div class="empty-icon">✈</div>No recent bookings yet.</div>
          <?php endif; ?>
        </div>
      </div>

      <div class="panel">
        <div class="panel-head">
          <div class="panel-title"><span class="panel-title-dot" style="background:var(--teal);"></span> Quick Actions</div>
        </div>
        <div class="panel-body">
          <div class="quick-grid">
            <a href="<?php echo e(route('bookings.create')); ?>" class="quick-btn">
              <div class="quick-btn-icon"><svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg></div>
              <div class="quick-label">Book a Trip</div>
            </a>
            <a href="<?php echo e(route('tickets.index')); ?>" class="quick-btn">
              <div class="quick-btn-icon"><svg viewBox="0 0 24 24"><path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2v2z"/></svg></div>
              <div class="quick-label">My Tickets</div>
            </a>
            <a href="<?php echo e(route('payments.index')); ?>" class="quick-btn">
              <div class="quick-btn-icon"><svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg></div>
              <div class="quick-label">Payments</div>
            </a>
            <a href="<?php echo e(route('promos.index')); ?>" class="quick-btn">
              <div class="quick-btn-icon" style="color:var(--gold);"><svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg></div>
              <div class="quick-label">Promos</div>
            </a>
          </div>
        </div>
      </div>
    </div>

    <div class="panel">
      <div class="panel-head">
        <div class="panel-title"><span class="panel-title-dot" style="background:var(--teal);"></span> Upcoming Trips</div>
        <a href="<?php echo e(route('schedules.index')); ?>" class="panel-link">View schedule →</a>
      </div>
      <div class="panel-body">
        <?php $__empty_1 = true; $__currentLoopData = $upcomingTrips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <?php $sc = $trip->schedule; $tr = $sc?->trip; ?>
          <div class="upcoming-item">
            <div class="booking-route-wrap">
              <div class="booking-plane-icon">✈</div>
              <div>
                <div class="upcoming-route"><?php echo e($tr->origin ?? '?'); ?> <span style="color:rgba(59,42,26,.35);font-weight:400;">→</span> <?php echo e($tr->destination ?? '?'); ?></div>
                <?php if($tr->origin_country ?? null): ?>
                  <div class="upcoming-country"><?php echo e($tr->origin_country); ?> → <?php echo e($tr->destination_country ?? ''); ?></div>
                <?php endif; ?>
                <div class="upcoming-dep"><?php echo e($sc?->departure_at?->format('M d, Y · h:i A') ?? '—'); ?></div>
              </div>
            </div>
            <span class="upcoming-badge"><?php echo e(ucfirst($trip->status)); ?></span>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="empty">
            <div class="empty-icon">🗺</div>
            No upcoming trips. <a href="<?php echo e(route('bookings.create')); ?>" style="color:var(--teal);font-weight:600;">Book one now →</a>
          </div>
        <?php endif; ?>
      </div>
    </div>

  </div>
</div>

<script>
  const sidebar   = document.getElementById('sidebar');
  const overlay   = document.getElementById('overlay');
  const hamburger = document.getElementById('hamburger');
  hamburger.addEventListener('click', () => {
    sidebar.classList.toggle('open');
    overlay.classList.toggle('open');
  });
  function closeSidebar() {
    sidebar.classList.remove('open');
    overlay.classList.remove('open');
  }
</script>
</body>
</html><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/dashboard.blade.php ENDPATH**/ ?>