
<?php $__env->startSection('page-title', 'Booking Detail'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .back-link { display:inline-flex;align-items:center;gap:6px;color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;font-weight:500;margin-bottom:22px;transition:color .15s; }
  .back-link:hover { color:var(--teal); }
  .back-link svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }

  .detail-grid { display:grid;grid-template-columns:1.5fr 1fr;gap:18px; }

  /* Cards */
  .card { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:22px;margin-bottom:18px;box-shadow:0 2px 12px rgba(59,42,26,.05); }
  .card:last-child { margin-bottom:0; }
  .card-title { font-family:var(--ff-head);font-size:.95rem;font-weight:700;color:var(--brown);margin-bottom:16px;padding-bottom:12px;border-bottom:1.5px solid rgba(59,42,26,.07);display:flex;align-items:center;gap:8px; }
  .card-title-dot { width:8px;height:8px;border-radius:50%;background:var(--gold);flex-shrink:0; }
  .card-title svg { width:14px;height:14px;stroke:var(--teal);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0; }

  /* Field rows */
  .field-row { display:flex;justify-content:space-between;align-items:center;padding:9px 0;border-bottom:1px solid rgba(59,42,26,.06); }
  .field-row:last-child { border-bottom:none; }
  .field-label { font-size:.7rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(59,42,26,.38);display:flex;align-items:center;gap:6px; }
  .field-label svg { width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:1.8;opacity:.6; }
  .field-value { font-size:.84rem;color:rgba(59,42,26,.65);text-align:right; }

  /* Pills */
  .pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:700; }
  .pill-green { background:rgba(45,110,110,.1);color:var(--teal); }
  .pill-amber { background:rgba(212,162,84,.14);color:#9a7030; }
  .pill-red   { background:rgba(180,60,60,.08);color:#b44444; }
  .pill-gray  { background:rgba(59,42,26,.07);color:rgba(59,42,26,.45); }
  .pill-blue  { background:rgba(45,110,110,.08);color:var(--teal); }

  .ref-badge { font-family:monospace;font-size:.88rem;font-weight:700;color:var(--teal); }

  /* Buttons */
  .act-btn { padding:9px 16px;border-radius:50px;font-size:.8rem;font-weight:600;cursor:pointer;border:1.5px solid;text-decoration:none;display:inline-flex;align-items:center;gap:7px;font-family:var(--ff-body);transition:all .15s;white-space:nowrap; }
  .act-btn svg { width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }
  .act-approve { color:#2e7d52;border-color:rgba(46,125,82,.3);background:rgba(46,125,82,.06); }
  .act-approve:hover { background:rgba(46,125,82,.12); }
  .act-reject  { color:#b44444;border-color:rgba(180,68,68,.3);background:rgba(180,68,68,.06); }
  .act-reject:hover  { background:rgba(180,68,68,.12); }
  .act-delete  { color:#b44444;border-color:rgba(180,68,68,.2);background:transparent; }
  .act-delete:hover  { background:rgba(180,68,68,.07); }
  .act-view    { color:var(--teal);border-color:rgba(45,110,110,.3);background:rgba(45,110,110,.06); }
  .act-view:hover    { background:rgba(45,110,110,.12); }

  .btn-update { background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:9px 20px;font-size:.8rem;font-weight:600;cursor:pointer;font-family:var(--ff-body);display:inline-flex;align-items:center;gap:6px;transition:background .18s;box-shadow:0 3px 12px rgba(45,110,110,.22); }
  .btn-update:hover { background:var(--teal-lt); }
  .btn-update svg { width:13px;height:13px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }

  /* Status update */
  .section-label { font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.35);margin-bottom:8px; }
  .status-form { display:flex;gap:10px;align-items:center;flex-wrap:wrap; }
  .status-select { background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:var(--radius-sm);padding:8px 12px;font-size:.84rem;font-family:var(--ff-body);color:var(--brown);outline:none;flex:1;min-width:140px;transition:border-color .2s; }
  .status-select:focus { border-color:var(--teal); }

  /* Banners */
  .state-banner { border-radius:var(--radius-sm);padding:12px 14px;display:flex;align-items:center;gap:10px;margin-bottom:14px; }
  .state-banner svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0; }
  .state-banner-text { font-size:.82rem;font-weight:500; }
  .banner-confirmed { background:rgba(45,110,110,.06);border:1.5px solid rgba(45,110,110,.18); }
  .banner-confirmed svg,.banner-confirmed .state-banner-text { color:var(--teal); }
  .banner-rejected  { background:rgba(180,68,68,.06);border:1.5px solid rgba(180,68,68,.18); }
  .banner-rejected svg,.banner-rejected .state-banner-text { color:#b44444; }

  .divider { border:none;border-top:1.5px solid rgba(59,42,26,.07);margin:14px 0; }

  /* Alert */
  .alert-success { background:rgba(45,110,110,.06);border:1.5px solid rgba(45,110,110,.2);border-radius:var(--radius-sm);padding:12px 16px;color:var(--teal);font-size:.84rem;margin-bottom:18px;display:flex;align-items:center;gap:8px; }
  .alert-success svg { width:15px;height:15px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0; }

  /* Passenger avatar */
  .user-av-lg { width:42px;height:42px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--tan));display:flex;align-items:center;justify-content:center;font-family:var(--ff-head);font-size:1rem;font-weight:700;color:var(--brown);flex-shrink:0; }

  @media (max-width: 900px) { .detail-grid { grid-template-columns:1fr; } }
</style>

<a href="<?php echo e(route('admin.bookings.index')); ?>" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Back to Bookings
</a>

<?php if(session('success')): ?>
<div class="alert-success">
  <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
  <?php echo e(session('success')); ?>

</div>
<?php endif; ?>

<?php $s = $booking->status; ?>

<div class="detail-grid">

  
  <div>

    
    <div class="card">
      <div class="card-title">
        <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
        Booking Information
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>Reference No</span>
        <span class="ref-badge"><?php echo e($booking->reference_no); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>Status</span>
        <span class="pill <?php echo e($s==='confirmed'?'pill-green':($s==='pending'?'pill-amber':($s==='cancelled'||$s==='rejected'?'pill-red':($s==='ticketed'?'pill-blue':'pill-gray')))); ?>"><?php echo e(ucfirst($s)); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"/><circle cx="9" cy="7" r="4"/></svg>Passengers</span>
        <span class="field-value"><?php echo e($booking->passenger_count); ?> pax</span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>Total Amount</span>
        <span class="field-value" style="color:var(--gold);font-weight:700;font-family:monospace;">&#8369;<?php echo e(number_format($booking->total_amount,2)); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Booked On</span>
        <span class="field-value"><?php echo e($booking->created_at->format('M d, Y h:i A')); ?></span>
      </div>
    </div>

    
    <div class="card">
      <div class="card-title">
        <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
        Trip &amp; Schedule
      </div>
      <?php if($booking->schedule && $booking->schedule->trip): ?>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>Trip Name</span>
        <span class="field-value"><?php echo e($booking->schedule->trip->name); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><polyline points="9,18 15,12 9,6"/></svg>Route</span>
        <span class="field-value"><?php echo e($booking->schedule->trip->origin); ?> → <?php echo e($booking->schedule->trip->destination); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><polygon points="12,2 15.09,8.26 22,9.27 17,14.14 18.18,21.02 12,17.77 5.82,21.02 7,14.14 2,9.27 8.91,8.26 12,2"/></svg>Type</span>
        <span class="field-value"><?php echo e(ucfirst($booking->schedule->trip->type ?? '—')); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"/><polyline points="9,22 9,12 15,12 15,22"/></svg>Operator</span>
        <span class="field-value"><?php echo e($booking->schedule->trip->operator ?? '—'); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12,6 12,12 16,14"/></svg>Departure</span>
        <span class="field-value"><?php echo e(\Carbon\Carbon::parse($booking->schedule->departure_at)->format('M d, Y h:i A')); ?></span>
      </div>
      <?php else: ?>
        <p style="color:rgba(59,42,26,.3);font-size:.84rem;">No schedule information.</p>
      <?php endif; ?>
    </div>

    
    <div class="card">
      <div class="card-title">
        <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
        Payment
      </div>
      <?php if($booking->payment): ?>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><polyline points="1,4 1,10 7,10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>Method</span>
        <span class="field-value"><?php echo e(ucfirst($booking->payment->method ?? '—')); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>Amount</span>
        <span class="field-value" style="color:var(--teal);font-family:monospace;font-weight:700;"><?php echo e(number_format($booking->payment->amount,2)); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>Payment Status</span>
        <?php $ps = $booking->payment->status; ?>
        <span class="pill <?php echo e($ps==='paid'?'pill-green':($ps==='pending'?'pill-amber':'pill-red')); ?>"><?php echo e(ucfirst($ps)); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>Transaction Ref</span>
        <span class="field-value" style="font-family:monospace;font-size:.76rem;"><?php echo e($booking->payment->transaction_ref ?? '—'); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Paid At</span>
        <span class="field-value"><?php echo e($booking->payment->paid_at ? $booking->payment->paid_at->format('M d, Y h:i A') : '—'); ?></span>
      </div>
      <?php else: ?>
        <p style="color:rgba(59,42,26,.3);font-size:.84rem;">No payment recorded.</p>
      <?php endif; ?>
    </div>
  </div>

  
  <div>

    
    <div class="card">
      <div class="card-title">
        <svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
        Passenger
      </div>
      <?php if($booking->user): ?>
      <div style="display:flex;align-items:center;gap:12px;margin-bottom:14px;padding-bottom:14px;border-bottom:1px solid rgba(59,42,26,.07);">
        <div class="user-av-lg"><?php echo e(strtoupper(substr($booking->user->name,0,2))); ?></div>
        <div>
          <div style="font-weight:700;color:var(--brown);font-size:.95rem;"><?php echo e($booking->user->name); ?></div>
          <div style="color:rgba(59,42,26,.38);font-size:.75rem;margin-top:2px;"><?php echo e($booking->user->email); ?></div>
        </div>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.36 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>Phone</span>
        <span class="field-value"><?php echo e($booking->user->phone ?? '—'); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="3"/><path d="M19.07 4.93a10 10 0 0 1 0 14.14M4.93 4.93a10 10 0 0 0 0 14.14"/></svg>Role</span>
        <span class="field-value"><?php echo e(ucfirst($booking->user->role)); ?></span>
      </div>
      <div class="field-row">
        <span class="field-label"><svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>Account Status</span>
        <span class="pill <?php echo e($booking->user->status==='active'?'pill-green':'pill-red'); ?>"><?php echo e(ucfirst($booking->user->status ?? 'active')); ?></span>
      </div>
      <?php else: ?>
        <p style="color:rgba(59,42,26,.3);font-size:.84rem;">User not found.</p>
      <?php endif; ?>
    </div>

    
    <div class="card">
      <div class="card-title">
        <svg viewBox="0 0 24 24"><path d="M12 20h9"/><path d="M16.5 3.5a2.121 2.121 0 0 1 3 3L7 19l-4 1 1-4L16.5 3.5z"/></svg>
        Actions
      </div>

      <?php if($s === 'confirmed'): ?>
        <div class="state-banner banner-confirmed">
          <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
          <span class="state-banner-text">This booking has been confirmed.</span>
        </div>

      <?php elseif($s === 'cancelled' || $s === 'rejected'): ?>
        <div class="state-banner banner-rejected">
          <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><line x1="15" y1="9" x2="9" y2="15"/><line x1="9" y1="9" x2="15" y2="15"/></svg>
          <span class="state-banner-text">This booking has been <?php echo e($s); ?>.</span>
        </div>

      <?php elseif($s === 'pending'): ?>
        <div style="display:flex;gap:10px;margin-bottom:14px;flex-wrap:wrap;">
          <form method="POST" action="<?php echo e(route('admin.bookings.approve',$booking)); ?>"
                onsubmit="return confirm('Approve this booking?')" style="flex:1">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <button class="act-btn act-approve" style="width:100%;justify-content:center;">
              <svg viewBox="0 0 24 24"><polyline points="20,6 9,17 4,12"/></svg>
              Approve
            </button>
          </form>
          <form method="POST" action="<?php echo e(route('admin.bookings.reject',$booking)); ?>"
                onsubmit="return confirm('Reject this booking?')" style="flex:1">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <button class="act-btn act-reject" style="width:100%;justify-content:center;">
              <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
              Reject
            </button>
          </form>
        </div>
        <hr class="divider">
      <?php endif; ?>

      <?php if(!in_array($s, ['confirmed','cancelled','rejected'])): ?>
        <div style="margin-bottom:14px;">
          <div class="section-label">Update Status</div>
          <form method="POST" action="<?php echo e(route('admin.bookings.status',$booking)); ?>">
            <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>
            <div class="status-form">
              <select name="status" class="status-select">
                <?php $__currentLoopData = ['pending','confirmed','cancelled','expired','ticketed']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $opt): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                  <option value="<?php echo e($opt); ?>" <?php echo e($booking->status===$opt?'selected':''); ?>><?php echo e(ucfirst($opt)); ?></option>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
              </select>
              <button type="submit" class="btn-update">
                <svg viewBox="0 0 24 24"><polyline points="1,4 1,10 7,10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
                Update
              </button>
            </div>
          </form>
        </div>
        <hr class="divider">
      <?php endif; ?>

      <form method="POST" action="<?php echo e(route('admin.bookings.destroy',$booking)); ?>"
            onsubmit="return confirm('Permanently delete this booking? This cannot be undone.')">
        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
        <button class="act-btn act-delete" style="width:100%;justify-content:center;">
          <svg viewBox="0 0 24 24"><polyline points="3,6 5,6 21,6"/><path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6m3 0V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/></svg>
          Delete Booking
        </button>
      </form>
    </div>

  </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/bookings/show.blade.php ENDPATH**/ ?>