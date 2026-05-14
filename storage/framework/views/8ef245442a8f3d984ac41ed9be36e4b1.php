<?php $__env->startSection('page-title', 'Book a Trip'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .page-header { display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px; }
  .page-title  { font-family:var(--ff-head);font-size:1.4rem;font-weight:900;color:var(--brown); }
  .page-sub    { font-size:.8rem;color:rgba(59,42,26,.4);margin-top:3px; }

  /* Filters */
  .filters-bar { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:16px 18px;display:flex;gap:10px;margin-bottom:20px;align-items:center;flex-wrap:wrap;box-shadow:0 2px 10px rgba(59,42,26,.04); }
  .filters-bar input,.filters-bar select { background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:50px;padding:8px 16px;font-size:.84rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s; }
  .filters-bar input { flex:1;min-width:220px; }
  .filters-bar input:focus,.filters-bar select:focus { border-color:var(--teal); }
  .filters-bar input::placeholder { color:rgba(59,42,26,.3); }
  .filter-btn  { background:var(--teal);border:none;border-radius:50px;padding:8px 22px;font-size:.84rem;font-weight:600;color:var(--white);cursor:pointer;font-family:var(--ff-body);transition:background .18s; }
  .filter-btn:hover { background:var(--teal-lt); }
  .clear-link  { color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;padding:7px 14px;border:1.5px solid rgba(59,42,26,.12);border-radius:50px;transition:all .15s;white-space:nowrap; }
  .clear-link:hover { color:var(--brown);border-color:rgba(59,42,26,.28); }

  /* Trip cards grid */
  .trips-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(360px,1fr));gap:16px; }

  .trip-card { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 12px rgba(59,42,26,.05);transition:transform .18s,box-shadow .18s; }
  .trip-card:hover { transform:translateY(-3px);box-shadow:0 8px 28px rgba(59,42,26,.1); }

  .trip-card-head { padding:18px 20px 14px;border-bottom:1.5px solid rgba(59,42,26,.07);display:flex;align-items:flex-start;gap:14px; }
  .trip-type-icon { width:40px;height:40px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0; }
  .trip-type-icon.air  { background:rgba(45,110,110,.1);color:var(--teal); }
  .trip-type-icon.land { background:rgba(212,162,84,.1);color:#9a7030; }
  .trip-type-icon.sea  { background:rgba(45,110,110,.06);color:var(--teal); }
  .trip-type-icon svg  { width:20px;height:20px;stroke:currentColor;fill:none;stroke-width:1.7;stroke-linecap:round;stroke-linejoin:round; }

  .trip-route { font-family:var(--ff-head);font-size:1rem;font-weight:700;color:var(--brown);line-height:1.2; }
  .trip-operator { font-size:.75rem;color:rgba(59,42,26,.4);margin-top:4px; }

  .pill { display:inline-flex;align-items:center;padding:3px 9px;border-radius:20px;font-size:.68rem;font-weight:700; }
  .pill-blue  { background:rgba(45,110,110,.1);color:var(--teal); }
  .pill-amber { background:rgba(212,162,84,.14);color:#9a7030; }
  .pill-tan   { background:rgba(196,154,108,.14);color:#8a5c2a; }

  /* Schedule list inside card */
  .schedule-list { padding:0; }
  .schedule-row { display:flex;align-items:center;justify-content:space-between;padding:12px 20px;border-bottom:1px solid rgba(59,42,26,.05);gap:12px; }
  .schedule-row:last-child { border-bottom:none; }
  .sch-times { flex:1;min-width:0; }
  .sch-dep { font-size:.84rem;font-weight:700;color:var(--brown); }
  .sch-arr { font-size:.72rem;color:rgba(59,42,26,.4);margin-top:1px; }
  .sch-class { font-size:.7rem;font-weight:700;padding:2px 8px;border-radius:20px; }
  .sch-class.economy  { background:rgba(45,110,110,.1);color:var(--teal); }
  .sch-class.business { background:rgba(212,162,84,.14);color:#9a7030; }
  .sch-class.first    { background:rgba(59,42,26,.07);color:var(--brown); }
  .sch-fare { font-family:var(--ff-head);font-size:.92rem;font-weight:900;color:var(--teal);white-space:nowrap; }
  .sch-seats { font-size:.7rem;color:rgba(59,42,26,.4); }
  .sch-seats.low { color:#b44444;font-weight:700; }
  .btn-book { background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:6px 16px;font-size:.78rem;font-weight:700;cursor:pointer;font-family:var(--ff-body);text-decoration:none;display:inline-flex;align-items:center;gap:5px;transition:background .15s,transform .12s;white-space:nowrap; }
  .btn-book:hover { background:var(--teal-lt);transform:translateY(-1px); }
  .btn-book svg { width:11px;height:11px;stroke:currentColor;fill:none;stroke-width:2.5;stroke-linecap:round; }

  .no-schedules { padding:18px 20px;text-align:center;font-size:.8rem;color:rgba(59,42,26,.35); }
  .add-sch-link { color:var(--teal);font-weight:600;text-decoration:none;font-size:.78rem; }
  .add-sch-link:hover { text-decoration:underline; }

  .pager { margin-top:22px;display:flex;justify-content:flex-end; }

  .empty-state { text-align:center;padding:64px 20px;color:rgba(59,42,26,.3);font-size:.9rem; }
  .empty-state svg { width:48px;height:48px;stroke:rgba(59,42,26,.15);fill:none;stroke-width:1.2;margin-bottom:16px;display:block;margin-inline:auto; }
</style>

<div class="page-header">
  <div>
    <div class="page-title">Book a Trip</div>
    <div class="page-sub">Select a schedule below to create a booking for a user</div>
  </div>
  <a href="<?php echo e(route('admin.schedules.create')); ?>" style="display:inline-flex;align-items:center;gap:6px;font-size:.82rem;font-weight:600;color:var(--teal);text-decoration:none;border:1.5px solid rgba(45,110,110,.25);border-radius:50px;padding:7px 16px;transition:all .15s;" onmouseover="this.style.background='rgba(45,110,110,.06)'" onmouseout="this.style.background=''">
    <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Schedule
  </a>
</div>

<form method="GET" action="<?php echo e(route('admin.book-trip')); ?>">
  <div class="filters-bar">
    <input type="text" name="search" placeholder="Search country or operator…" value="<?php echo e(request('search')); ?>">
    <select name="type">
      <option value="">All Types</option>
      <option value="air"  <?php echo e(request('type')==='air'  ?'selected':''); ?>>✈ Air</option>
      <option value="land" <?php echo e(request('type')==='land' ?'selected':''); ?>>🚌 Land</option>
      <option value="sea"  <?php echo e(request('type')==='sea'  ?'selected':''); ?>>🚢 Sea</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
    <?php if(request()->hasAny(['search','type'])): ?>
      <a href="<?php echo e(route('admin.book-trip')); ?>" class="clear-link">Clear</a>
    <?php endif; ?>
  </div>
</form>

<?php if($trips->count()): ?>
  <div class="trips-grid">
    <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <div class="trip-card">
      <div class="trip-card-head">
        <div class="trip-type-icon <?php echo e($trip->type); ?>">
          <?php if($trip->type === 'air'): ?>
            <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
          <?php elseif($trip->type === 'sea'): ?>
            <svg viewBox="0 0 24 24"><path d="M2 20a2.4 2.4 0 0 0 2 1 2.4 2.4 0 0 0 2-1 2.4 2.4 0 0 1 2-1 2.4 2.4 0 0 1 2 1 2.4 2.4 0 0 0 2 1 2.4 2.4 0 0 0 2-1 2.4 2.4 0 0 1 2-1 2.4 2.4 0 0 1 2 1"/><path d="M4 18l-1-4h18l-2 4"/><path d="M10 10V7l2-3 2 3v3"/><path d="M7 10h10"/></svg>
          <?php else: ?>
            <svg viewBox="0 0 24 24"><rect x="1" y="3" width="15" height="13" rx="2"/><path d="M16 8h4l3 3v5h-7V8z"/><circle cx="5.5" cy="18.5" r="2.5"/><circle cx="18.5" cy="18.5" r="2.5"/></svg>
          <?php endif; ?>
        </div>
        <div style="flex:1;min-width:0;">
          <div class="trip-route"><?php echo e($trip->origin_country); ?> → <?php echo e($trip->destination_country); ?></div>
          <div class="trip-operator">
            <?php echo e($trip->operator ?? 'No operator'); ?>

            &nbsp;·&nbsp;
            <span class="pill <?php echo e($trip->type==='air'?'pill-blue':($trip->type==='sea'?'pill-blue':'pill-amber')); ?>"><?php echo e(ucfirst($trip->type)); ?></span>
          </div>
        </div>
      </div>

      <div class="schedule-list">
        <?php $__empty_1 = true; $__currentLoopData = $trip->schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $sch): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
          <div class="schedule-row">
            <div class="sch-times">
              <div class="sch-dep"><?php echo e($sch->departure_at->format('M d, Y · h:i A')); ?></div>
              <div class="sch-arr">Arrives <?php echo e($sch->arrival_at->format('M d · h:i A')); ?></div>
            </div>
            <span class="sch-class <?php echo e($sch->fare_class); ?>"><?php echo e(ucfirst($sch->fare_class)); ?></span>
            <div style="text-align:right;">
              <div class="sch-fare">₱<?php echo e(number_format($sch->base_fare, 0)); ?></div>
              <div class="sch-seats <?php echo e($sch->available_seats < 10 ? 'low' : ''); ?>">
                <?php echo e($sch->available_seats); ?> seats left
              </div>
            </div>
            <?php if($sch->available_seats > 0): ?>
              <a href="<?php echo e(route('admin.book-trip.form', $sch)); ?>" class="btn-book">
                <svg viewBox="0 0 24 24"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
                Book
              </a>
            <?php else: ?>
              <span style="font-size:.72rem;color:#b44444;font-weight:700;white-space:nowrap;">Full</span>
            <?php endif; ?>
          </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
          <div class="no-schedules">
            No upcoming schedules.
            <a href="<?php echo e(route('admin.schedules.create')); ?>" class="add-sch-link">Add one →</a>
          </div>
        <?php endif; ?>
      </div>
    </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
  </div>

  <div class="pager"><?php echo e($trips->withQueryString()->links()); ?></div>

<?php else: ?>
  <div class="empty-state">
    <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
    No active trips found. <a href="<?php echo e(route('admin.trips.create')); ?>" style="color:var(--teal);font-weight:600;">Add a trip →</a>
  </div>
<?php endif; ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/bookings/book-trip.blade.php ENDPATH**/ ?>