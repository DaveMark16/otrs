
<?php $__env->startSection('page-title', 'Dashboard'); ?>

<?php $__env->startSection('content'); ?>
<style>
  /* ── Stats Grid ── */
  .stats-grid { display: grid; grid-template-columns: repeat(4,1fr); gap: 14px; margin-bottom: 14px; }
  .stat-card {
    background: var(--white); border: 1.5px solid rgba(59,42,26,.08);
    border-radius: var(--radius); padding: 20px 22px;
    position: relative; overflow: hidden;
    transition: transform .2s, box-shadow .2s;
    box-shadow: 0 2px 12px rgba(59,42,26,.05);
  }
  .stat-card:hover { transform: translateY(-3px); box-shadow: 0 10px 28px rgba(59,42,26,.10); }
  .stat-card::before { content:''; position:absolute; top:0; left:0; right:0; height:3px; background: var(--ac, var(--teal)); }
  .stat-icon-wrap {
    width: 36px; height: 36px; border-radius: 10px;
    display: flex; align-items: center; justify-content: center;
    margin-bottom: 14px; flex-shrink: 0;
  }
  .stat-icon-wrap svg { width: 17px; height: 17px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
  .stat-label { font-size: .68rem; font-weight: 700; letter-spacing: .1em; text-transform: uppercase; color: rgba(59,42,26,.38); margin-bottom: 6px; }
  .stat-value { font-family: var(--ff-head); font-size: 2rem; font-weight: 900; color: var(--brown); line-height: 1; }
  .stat-sub { font-size: .72rem; color: rgba(59,42,26,.35); margin-top: 5px; }

  /* ── Row 2 ── */
  .row2 { display: grid; grid-template-columns: 1.55fr 1fr; gap: 18px; }

  /* ── Panel ── */
  .panel {
    background: var(--white); border: 1.5px solid rgba(59,42,26,.08);
    border-radius: var(--radius); overflow: hidden;
    box-shadow: 0 2px 12px rgba(59,42,26,.05);
    margin-bottom: 18px;
  }
  .panel:last-child { margin-bottom: 0; }
  .panel-head {
    display: flex; justify-content: space-between; align-items: center;
    padding: 18px 22px 0; margin-bottom: 14px;
  }
  .panel-title-wrap { display: flex; align-items: center; gap: 8px; }
  .panel-title-dot { width: 8px; height: 8px; border-radius: 50%; background: var(--gold); flex-shrink: 0; }
  .panel-title { font-family: var(--ff-head); font-size: 1.05rem; font-weight: 700; color: var(--brown); }
  .panel-link { font-size: .78rem; font-weight: 600; color: var(--teal); opacity: .8; text-decoration: none; transition: opacity .15s; }
  .panel-link:hover { opacity: 1; }

  /* ── Mini table ── */
  .mini-table { width: 100%; border-collapse: collapse; }
  .mini-table thead th {
    padding: 10px 16px; font-size: .67rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: rgba(59,42,26,.35); border-bottom: 1.5px solid rgba(59,42,26,.07);
    background: var(--sand); text-align: left; white-space: nowrap;
  }
  .mini-table thead th:last-child { text-align: right; }
  .mini-table tbody tr { border-bottom: 1px solid rgba(59,42,26,.06); transition: background .1s; }
  .mini-table tbody tr:last-child { border-bottom: none; }
  .mini-table tbody tr:hover { background: rgba(245,237,224,.45); }
  .mini-table tbody td { padding: 11px 16px; font-size: .82rem; color: rgba(59,42,26,.55); vertical-align: middle; }
  .mini-table tbody td:last-child { text-align: right; }
  .td-amount { font-weight: 700; color: var(--gold); }
  .ref-badge { font-family: monospace; font-size: .72rem; font-weight: 700; color: var(--teal); }

  /* ── Pills ── */
  .pill { display: inline-flex; align-items: center; padding: 3px 10px; border-radius: 20px; font-size: .7rem; font-weight: 700; letter-spacing: .03em; }
  .pill-green { background: rgba(45,110,110,.1);  color: var(--teal); }
  .pill-amber { background: rgba(212,162,84,.14); color: #9a7030; }
  .pill-red   { background: rgba(180,60,60,.08);  color: #b44444; }
  .pill-gray  { background: rgba(59,42,26,.07);   color: rgba(59,42,26,.45); }
  .pill-blue  { background: rgba(45,110,110,.08); color: var(--teal); }

  /* ── User avatar ── */
  .user-av {
    width: 28px; height: 28px; border-radius: 50%;
    background: linear-gradient(135deg, var(--gold), var(--tan));
    display: inline-flex; align-items: center; justify-content: center;
    font-family: var(--ff-head); font-size: .72rem; font-weight: 700;
    color: var(--brown); flex-shrink: 0;
  }
  .user-chip { display: flex; align-items: center; gap: 9px; }

  /* ── Quick actions ── */
  .quick-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 10px; padding: 0 22px 20px; }
  .quick-btn {
    background: var(--sand); border: 1.5px solid rgba(59,42,26,.08);
    border-radius: var(--radius-sm); padding: 14px 14px;
    text-decoration: none; transition: all .2s;
    display: flex; align-items: center; gap: 11px;
  }
  .quick-btn:hover { background: rgba(45,110,110,.07); border-color: rgba(45,110,110,.2); transform: translateY(-2px); }
  .quick-icon {
    width: 34px; height: 34px; border-radius: 9px;
    background: var(--white); display: flex; align-items: center; justify-content: center;
    box-shadow: 0 2px 8px rgba(59,42,26,.08); flex-shrink: 0; color: var(--teal);
  }
  .quick-icon svg { width: 15px; height: 15px; stroke: currentColor; fill: none; stroke-width: 1.8; stroke-linecap: round; stroke-linejoin: round; }
  .quick-label { font-size: .8rem; font-weight: 600; color: rgba(59,42,26,.65); }

  /* ── Recent users ── */
  .rur { display: flex; align-items: center; gap: 10px; padding: 10px 22px; border-bottom: 1px solid rgba(59,42,26,.06); }
  .rur:last-child { border-bottom: none; }
  .rur-meta { flex: 1; min-width: 0; }
  .rur-name  { font-size: .85rem; font-weight: 600; color: var(--brown); }
  .rur-email { font-size: .72rem; color: rgba(59,42,26,.38); margin-top: 1px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; }

  /* ── View link ── */
  .view-link { font-size: .75rem; font-weight: 600; color: var(--teal); text-decoration: none; display: inline-flex; align-items: center; gap: 3px; opacity: .8; transition: opacity .15s; }
  .view-link:hover { opacity: 1; }
  .view-link svg { width: 11px; height: 11px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }

  /* ── Empty ── */
  .empty { padding: 32px; text-align: center; color: rgba(59,42,26,.35); font-size: .85rem; }

  @media (max-width: 900px) { .row2 { grid-template-columns: 1fr; } }
  @media (max-width: 768px) { .stats-grid { grid-template-columns: repeat(2,1fr); } }
</style>


<div class="stats-grid" style="margin-bottom:14px;">
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-icon-wrap" style="background:rgba(45,110,110,.1);color:var(--teal)">
      <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
    </div>
    <div class="stat-label">Total Users</div>
    <div class="stat-value"><?php echo e($stats['total_users']); ?></div>
    <div class="stat-sub"><?php echo e($stats['admins'] ?? 0); ?> admins</div>
  </div>
  <div class="stat-card" style="--ac:var(--gold)">
    <div class="stat-icon-wrap" style="background:rgba(212,162,84,.12);color:var(--gold)">
      <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    </div>
    <div class="stat-label">Total Bookings</div>
    <div class="stat-value"><?php echo e($stats['total_bookings']); ?></div>
    <div class="stat-sub">All time</div>
  </div>
  <div class="stat-card" style="--ac:#a07830">
    <div class="stat-icon-wrap" style="background:rgba(160,120,48,.1);color:#a07830">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
    </div>
    <div class="stat-label">Pending</div>
    <div class="stat-value"><?php echo e($stats['pending']); ?></div>
    <div class="stat-sub">Needs approval</div>
  </div>
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-icon-wrap" style="background:rgba(45,110,110,.1);color:var(--teal)">
      <svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
    </div>
    <div class="stat-label">Total Revenue</div>
    <div class="stat-value" style="font-size:1.5rem;">&#8369;<?php echo e(number_format($stats['total_revenue'], 0)); ?></div>
    <div class="stat-sub">Confirmed bookings</div>
  </div>
</div>


<div class="stats-grid" style="margin-bottom:26px;">
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-icon-wrap" style="background:rgba(45,110,110,.1);color:var(--teal)">
      <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
    </div>
    <div class="stat-label">Confirmed</div>
    <div class="stat-value"><?php echo e($stats['confirmed']); ?></div>
    <div class="stat-sub">Approved bookings</div>
  </div>
  <div class="stat-card" style="--ac:#b44444">
    <div class="stat-icon-wrap" style="background:rgba(180,68,68,.08);color:#b44444">
      <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
    </div>
    <div class="stat-label">Cancelled</div>
    <div class="stat-value"><?php echo e($stats['cancelled']); ?></div>
    <div class="stat-sub">Rejected / cancelled</div>
  </div>
  <div class="stat-card" style="--ac:var(--tan)">
    <div class="stat-icon-wrap" style="background:rgba(196,154,108,.12);color:var(--tan)">
      <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
    </div>
    <div class="stat-label">Total Trips</div>
    <div class="stat-value"><?php echo e($stats['total_trips']); ?></div>
    <div class="stat-sub">Active routes</div>
  </div>
  <div class="stat-card" style="--ac:var(--teal)">
    <div class="stat-icon-wrap" style="background:rgba(45,110,110,.1);color:var(--teal)">
      <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
    </div>
    <div class="stat-label">Verified Payments</div>
    <div class="stat-value" style="font-size:1.5rem;">&#8369;<?php echo e(number_format($stats['paid_payments'], 0)); ?></div>
    <div class="stat-sub">Paid transactions</div>
  </div>
</div>


<div class="row2">

  
  <div class="panel">
    <div class="panel-head">
      <div class="panel-title-wrap">
        <span class="panel-title-dot"></span>
        <span class="panel-title">Recent Bookings</span>
      </div>
      <a href="<?php echo e(route('admin.bookings.index')); ?>" class="panel-link">View all →</a>
    </div>
    <?php if($recent_bookings->count()): ?>
    <table class="mini-table">
      <thead>
        <tr>
          <th>Reference</th>
          <th>Passenger</th>
          <th>Route</th>
          <th>Status</th>
          <th style="text-align:right">Amount</th>
          <th style="text-align:right">Action</th>
        </tr>
      </thead>
      <tbody>
        <?php $__currentLoopData = $recent_bookings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $b): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <tr>
          <td><span class="ref-badge"><?php echo e($b->reference_no); ?></span></td>
          <td>
            <div class="user-chip">
              <div class="user-av"><?php echo e(strtoupper(substr($b->user->name ?? 'U', 0, 2))); ?></div>
              <span style="font-weight:600;color:var(--brown);font-size:.83rem;"><?php echo e($b->user->name ?? '—'); ?></span>
            </div>
          </td>
          <td><?php echo e($b->schedule->trip->origin ?? '?'); ?> → <?php echo e($b->schedule->trip->destination ?? '?'); ?></td>
          <td>
            <?php $bs = $b->status; ?>
            <span class="pill <?php echo e($bs==='confirmed'?'pill-green':($bs==='pending'?'pill-amber':($bs==='cancelled'?'pill-red':($bs==='ticketed'?'pill-blue':'pill-gray')))); ?>">
              <?php echo e(ucfirst($bs)); ?>

            </span>
          </td>
          <td class="td-amount">&#8369;<?php echo e(number_format($b->total_amount, 2)); ?></td>
          <td>
            <a href="<?php echo e(route('admin.bookings.show', $b)); ?>" class="view-link">
              <svg viewBox="0 0 24 24"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
              View
            </a>
          </td>
        </tr>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
      </tbody>
    </table>
    <?php else: ?>
      <div class="empty">No recent bookings.</div>
    <?php endif; ?>
  </div>

  
  <div>
    
    <div class="panel">
      <div class="panel-head">
        <div class="panel-title-wrap">
          <span class="panel-title-dot" style="background:var(--teal);"></span>
          <span class="panel-title">Quick Actions</span>
        </div>
      </div>
      <div class="quick-grid">
        <a href="<?php echo e(route('admin.bookings.index', ['status'=>'pending'])); ?>" class="quick-btn">
          <div class="quick-icon" style="color:#a07830">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>
          </div>
          <span class="quick-label">Pending Bookings</span>
        </a>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="quick-btn">
          <div class="quick-icon">
            <svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/><path d="M23 21v-2a4 4 0 0 0-3-3.87"/><path d="M16 3.13a4 4 0 0 1 0 7.75"/></svg>
          </div>
          <span class="quick-label">Manage Users</span>
        </a>
        <a href="<?php echo e(route('admin.trips.create')); ?>" class="quick-btn">
          <div class="quick-icon" style="color:var(--tan)">
            <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
          </div>
          <span class="quick-label">Add Trip</span>
        </a>
        <a href="<?php echo e(route('admin.payments.index')); ?>" class="quick-btn">
          <div class="quick-icon">
            <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
          </div>
          <span class="quick-label">Payments</span>
        </a>
      </div>
    </div>

    
    <div class="panel">
      <div class="panel-head">
        <div class="panel-title-wrap">
          <span class="panel-title-dot" style="background:var(--teal);"></span>
          <span class="panel-title">Recent Users</span>
        </div>
        <a href="<?php echo e(route('admin.users.index')); ?>" class="panel-link">View all →</a>
      </div>
      <?php $__currentLoopData = $recent_users; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $u): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <div class="rur">
        <div class="user-av"><?php echo e(strtoupper(substr($u->name, 0, 2))); ?></div>
        <div class="rur-meta">
          <div class="rur-name"><?php echo e($u->name); ?></div>
          <div class="rur-email"><?php echo e($u->email); ?></div>
        </div>
        <span class="pill <?php echo e($u->role==='admin'||$u->role==='superadmin'?'pill-amber':'pill-gray'); ?>"><?php echo e(ucfirst($u->role)); ?></span>
      </div>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  </div>

</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/dashboard.blade.php ENDPATH**/ ?>