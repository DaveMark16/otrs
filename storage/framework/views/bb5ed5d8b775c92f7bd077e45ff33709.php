<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title>OTRS Admin — <?php echo $__env->yieldContent('page-title', 'Admin Panel'); ?></title>
    <link rel="preconnect" href="https://fonts.googleapis.com" />
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin />
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,400;0,700;0,900;1,400&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet" />
    <?php echo app('Illuminate\Foundation\Vite')(['resources/css/app.css', 'resources/js/app.js']); ?>
    <style>
        :root {
            --sand:      #f5ede0;
            --cream:     #faf6f0;
            --brown:     #3b2a1a;
            --brown-lt:  #4e3826;
            --tan:       #c49a6c;
            --gold:      #d4a254;
            --gold-lt:   #e2b46a;
            --teal:      #2d6e6e;
            --teal-lt:   #3d8f8f;
            --white:     #ffffff;
            --radius:    16px;
            --radius-sm: 10px;
            --ff-head:   'Playfair Display', Georgia, serif;
            --ff-body:   'DM Sans', sans-serif;
            --sidebar-w: 256px;
            --topbar-h:  64px;
        }
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: var(--ff-body); background: var(--cream); color: var(--brown); min-height: 100vh; display: flex; overflow-x: hidden; }
        a { text-decoration: none; color: inherit; }

        /* Sidebar — uses teal as the admin accent */
        .sidebar { width: var(--sidebar-w); min-width: var(--sidebar-w); background: var(--teal); min-height: 100vh; display: flex; flex-direction: column; position: sticky; top: 0; height: 100vh; overflow-y: auto; z-index: 200; scrollbar-width: none; transition: transform .28s ease; }
        .sidebar::-webkit-scrollbar { display: none; }
        .sb-brand { padding: 26px 22px 20px; border-bottom: 1px solid rgba(255,255,255,.12); flex-shrink: 0; }
        .sb-logo { font-family: var(--ff-head); font-size: 1.75rem; font-weight: 900; color: var(--white); letter-spacing: -.5px; line-height: 1; }
        .sb-logo span { color: var(--gold); }
        .sb-badge { display: inline-block; margin-top: 5px; font-size: .67rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; background: rgba(212,162,84,.18); color: var(--gold); border: 1px solid rgba(212,162,84,.35); border-radius: 20px; padding: 2px 10px; }
        .sb-user { display: flex; align-items: center; gap: 12px; padding: 16px 22px; border-bottom: 1px solid rgba(255,255,255,.1); }
        .sb-avatar { width: 38px; height: 38px; background: linear-gradient(135deg, var(--gold), var(--tan)); border-radius: 50%; display: flex; align-items: center; justify-content: center; font-family: var(--ff-head); font-size: .95rem; font-weight: 700; color: var(--brown); flex-shrink: 0; }
        .sb-user-name { font-size: .86rem; font-weight: 600; color: rgba(255,255,255,.9); white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }
        .sb-user-role { font-size: .71rem; color: var(--gold); margin-top: 1px; opacity: .85; }
        .sb-nav { flex: 1; padding: 16px 12px; }
        .sb-section { font-size: .67rem; font-weight: 700; letter-spacing: .14em; text-transform: uppercase; color: rgba(255,255,255,.3); padding: 12px 10px 6px; margin-top: 4px; }
        .sb-item { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); color: rgba(255,255,255,.55); font-size: .86rem; font-weight: 500; margin-bottom: 2px; transition: background .15s, color .15s; }
        .sb-item svg { width: 15px; height: 15px; flex-shrink: 0; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
        .sb-item:hover { background: rgba(255,255,255,.1); color: var(--white); }
        .sb-item.active { background: rgba(212,162,84,.18); color: var(--gold); font-weight: 600; }
        .sb-item.active svg { stroke: var(--gold); }
        .sb-footer { padding: 14px 12px; border-top: 1px solid rgba(255,255,255,.1); flex-shrink: 0; }
        .sb-logout { display: flex; align-items: center; gap: 10px; padding: 9px 12px; border-radius: var(--radius-sm); color: rgba(255,255,255,.38); font-size: .84rem; font-family: var(--ff-body); cursor: pointer; transition: background .15s, color .15s; background: none; border: none; width: 100%; }
        .sb-logout svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; flex-shrink: 0; }
        .sb-logout:hover { background: rgba(245,100,80,.15); color: #f08070; }

        /* Main */
        .main { flex: 1; min-width: 0; display: flex; flex-direction: column; }
        .topbar { background: var(--white); border-bottom: 1px solid rgba(59,42,26,.08); padding: 0 32px; height: var(--topbar-h); display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
        .topbar-left { display: flex; align-items: center; gap: 12px; }
        .topbar-title { font-family: var(--ff-head); font-size: 1.15rem; font-weight: 700; color: var(--brown); }
        .topbar-pill { font-size: .7rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; background: rgba(45,110,110,.08); color: var(--teal); border: 1px solid rgba(45,110,110,.18); border-radius: 20px; padding: 3px 10px; }
        .topbar-right { display: flex; align-items: center; gap: 14px; }
        .topbar-date { font-size: .78rem; color: rgba(59,42,26,.4); }
        .topbar-btn { background: var(--teal); color: var(--white); padding: .48rem 1.15rem; border-radius: 50px; font-size: .8rem; font-weight: 600; display: inline-flex; align-items: center; gap: .4rem; transition: background .18s, transform .15s; box-shadow: 0 3px 12px rgba(45,110,110,.22); }
        .topbar-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }
        .content { padding: 30px 32px 48px; flex: 1; background: var(--cream); }
        .flash { margin-bottom: 20px; padding: 12px 16px; border-radius: var(--radius-sm); font-size: .88rem; font-weight: 500; display: flex; align-items: center; gap: 8px; }
        .flash-success { background: rgba(45,110,110,.07); border: 1px solid rgba(45,110,110,.2); color: var(--teal); }
        .flash-error { background: rgba(180,60,60,.07); border: 1px solid rgba(180,60,60,.2); color: #b44444; }

        /* Mobile */
        .mobile-bar { display: none; background: var(--teal); padding: 0 20px; height: 58px; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 200; }
        .mobile-logo { font-family: var(--ff-head); font-size: 1.3rem; font-weight: 900; color: var(--white); }
        .mobile-logo span { color: var(--gold); }
        .hamburger { display: flex; flex-direction: column; gap: 5px; cursor: pointer; padding: 4px; }
        .hamburger span { width: 22px; height: 2px; background: rgba(255,255,255,.85); border-radius: 2px; }
        .sidebar-overlay { display: none; position: fixed; inset: 0; background: rgba(59,42,26,.5); z-index: 150; backdrop-filter: blur(3px); }
        .sidebar-overlay.open { display: block; }
        .sb-close { display: none; position: absolute; top: 14px; right: 14px; background: rgba(255,255,255,.1); border: none; color: rgba(255,255,255,.6); cursor: pointer; padding: 5px; border-radius: 6px; }
        .sb-close:hover { background: rgba(255,255,255,.2); color: var(--white); }
        .sb-close svg { width: 16px; height: 16px; display: block; stroke: currentColor; fill: none; stroke-width: 2; }

        @media (max-width: 768px) {
            body { flex-direction: column; }
            .sidebar { position: fixed; left: -100%; top: 0; height: 100vh; transition: left .28s ease; }
            .sidebar.open { left: 0; }
            .sb-close { display: flex; align-items: center; justify-content: center; }
            .mobile-bar { display: flex; }
            .topbar { display: none; }
            .content { padding: 20px 16px 36px; }
        }
        @media (max-width: 480px) { .content { padding: 16px 14px 32px; } }
    </style>
</head>
<body>

<div class="mobile-bar">
    <div class="mobile-logo">OTR<span>S</span></div>
    <div class="hamburger" id="hamburger"><span></span><span></span><span></span></div>
</div>
<div class="sidebar-overlay" id="overlay" onclick="closeSidebar()"></div>

<aside class="sidebar" id="sidebar">
    <button class="sb-close" onclick="closeSidebar()" aria-label="Close menu">
        <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
    </button>
    <div class="sb-brand">
        <div class="sb-logo">OTR<span>S</span></div>
        <div class="sb-badge">Admin Panel</div>
    </div>
    <div class="sb-user">
        <div class="sb-avatar"><?php echo e(substr(auth()->user()->name ?? 'AD', 0, 2)); ?></div>
        <div style="min-width:0;">
            <div class="sb-user-name"><?php echo e(auth()->user()->name ?? 'Admin'); ?></div>
            <div class="sb-user-role"><?php echo e(ucfirst(auth()->user()->role ?? 'admin')); ?></div>
        </div>
    </div>
    <nav class="sb-nav">
        <div class="sb-section">Overview</div>
        <a href="<?php echo e(route('admin.dashboard')); ?>" class="sb-item <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><rect x="3" y="3" width="7" height="7" rx="1"/><rect x="14" y="3" width="7" height="7" rx="1"/><rect x="3" y="14" width="7" height="7" rx="1"/><rect x="14" y="14" width="7" height="7" rx="1"/></svg>
            Dashboard
        </a>
        <div class="sb-section">Management</div>
        <a href="<?php echo e(route('admin.bookings.index')); ?>" class="sb-item <?php echo e(request()->routeIs('admin.bookings.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><path d="M8 6h13M8 12h13M8 18h13M3 6h.01M3 12h.01M3 18h.01" stroke-linecap="round"/></svg>
            Bookings
        </a>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="sb-item <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87M16 3.13a4 4 0 0 1 0 7.75"/></svg>
            Users
        </a>
        <a href="<?php echo e(route('admin.trips.index')); ?>" class="sb-item <?php echo e(request()->routeIs('admin.trips.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
            Trips
        </a>
        <a href="<?php echo e(route('admin.schedules.index')); ?>" class="sb-item <?php echo e(request()->routeIs('admin.schedules.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
            Schedules
        </a>
        <div class="sb-section">Finance</div>
        <a href="<?php echo e(route('admin.payments.index')); ?>" class="sb-item <?php echo e(request()->routeIs('admin.payments.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24"><rect x="2" y="5" width="20" height="14" rx="2"/><path d="M2 10h20"/></svg>
            Payments
        </a>
        <div class="sb-section">Promotions</div>
        <a href="<?php echo e(route('admin.promos.index')); ?>" class="sb-item <?php echo e(request()->routeIs('admin.promos.*') ? 'active' : ''); ?>" onclick="closeSidebar()">
            <svg viewBox="0 0 24 24" stroke-linecap="round" stroke-linejoin="round"><path d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path d="M6 6h.008v.008H6V6z"/></svg>
            Promos
        </a>
    </nav>
    <div class="sb-footer">
        <form method="POST" action="<?php echo e(route('logout')); ?>">
            <?php echo csrf_field(); ?>
            <button type="submit" class="sb-logout">
                <svg viewBox="0 0 24 24"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
                Sign Out
            </button>
        </form>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <div class="topbar-left">
            <div class="topbar-title"><?php echo $__env->yieldContent('page-title', 'Admin Panel'); ?></div>
            <span class="topbar-pill">Admin Panel</span>
        </div>
        <div class="topbar-right">
            <div class="topbar-date"><?php echo e(now()->format('l, F j, Y')); ?></div>
        </div>
    </div>
    <div class="content">
        <?php if(session('success')): ?>
            <div class="flash flash-success">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>
        <?php if(session('error')): ?>
            <div class="flash flash-error">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <?php echo e(session('error')); ?>

            </div>
        <?php endif; ?>
        <?php echo $__env->yieldContent('content'); ?>
    </div>
</div>

<script>
    const sidebar   = document.getElementById('sidebar');
    const overlay   = document.getElementById('overlay');
    const hamburger = document.getElementById('hamburger');
    if (hamburger) {
        hamburger.addEventListener('click', () => {
            sidebar.classList.toggle('open');
            overlay.classList.toggle('open');
            document.body.style.overflow = sidebar.classList.contains('open') ? 'hidden' : '';
        });
    }
    function closeSidebar() {
        sidebar.classList.remove('open');
        overlay.classList.remove('open');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => { if (e.key === 'Escape') closeSidebar(); });
</script>
</body>
</html><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/layouts/app.blade.php ENDPATH**/ ?>