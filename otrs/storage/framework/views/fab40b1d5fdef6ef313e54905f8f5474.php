
<?php $__env->startSection('page-title', 'Schedules'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .page-header { display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px; }
  .page-title  { font-family:var(--ff-head);font-size:1.4rem;font-weight:900;color:var(--brown); }
  .page-sub    { font-size:.8rem;color:rgba(59,42,26,.4);margin-top:3px; }
  .btn-primary { background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:10px 22px;font-size:.86rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .18s,transform .15s;box-shadow:0 4px 14px rgba(45,110,110,.25);font-family:var(--ff-body); }
  .btn-primary:hover { background:var(--teal-lt);transform:translateY(-1px); }

  /* Filters */
  .filters-bar { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:16px 18px;display:flex;gap:10px;margin-bottom:18px;align-items:center;flex-wrap:wrap;box-shadow:0 2px 10px rgba(59,42,26,.04); }
  .filters-bar input,.filters-bar select { background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:50px;padding:8px 16px;font-size:.84rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s; }
  .filters-bar input { flex:1;min-width:220px; }
  .filters-bar input:focus,.filters-bar select:focus { border-color:var(--teal); }
  .filters-bar input::placeholder { color:rgba(59,42,26,.3); }
  .filter-btn  { background:var(--teal);border:none;border-radius:50px;padding:8px 22px;font-size:.84rem;font-weight:600;color:var(--white);cursor:pointer;font-family:var(--ff-body);transition:background .18s; }
  .filter-btn:hover { background:var(--teal-lt); }
  .clear-link  { color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;padding:7px 14px;border:1.5px solid rgba(59,42,26,.12);border-radius:50px;transition:all .15s;white-space:nowrap; }
  .clear-link:hover { color:var(--brown);border-color:rgba(59,42,26,.28); }

  /* Table */
  .table-wrap { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 16px rgba(59,42,26,.06); }
  table { width:100%;border-collapse:collapse; }
  thead th { padding:12px 16px;text-align:left;font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);border-bottom:1.5px solid rgba(59,42,26,.07);background:var(--sand);white-space:nowrap; }
  tbody tr { border-bottom:1px solid rgba(59,42,26,.06);transition:background .1s; }
  tbody tr:last-child { border-bottom:none; }
  tbody tr:hover { background:rgba(245,237,224,.45); }
  tbody td { padding:12px 16px;font-size:.83rem;color:rgba(59,42,26,.55);vertical-align:middle; }

  /* Pills */
  .pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:700;white-space:nowrap; }
  .pill-green { background:rgba(45,110,110,.1);color:var(--teal); }
  .pill-amber { background:rgba(212,162,84,.14);color:#9a7030; }
  .pill-red   { background:rgba(180,60,60,.08);color:#b44444; }
  .pill-blue  { background:rgba(45,110,110,.08);color:var(--teal); }
  .pill-gray  { background:rgba(59,42,26,.07);color:rgba(59,42,26,.45); }

  /* Action buttons */
  .act-btn { display:inline-flex;align-items:center;gap:4px;padding:5px 13px;border-radius:50px;font-size:.75rem;font-weight:600;text-decoration:none;border:1.5px solid;cursor:pointer;background:transparent;transition:all .15s;font-family:var(--ff-body);white-space:nowrap; }
  .act-edit { color:var(--teal);border-color:rgba(45,110,110,.3); }
  .act-edit:hover { background:rgba(45,110,110,.08); }
  .act-del  { color:#b44444;border-color:rgba(180,68,68,.25); }
  .act-del:hover  { background:rgba(180,68,68,.08); }

  /* Route cell */
  .trip-name { font-weight:600;color:var(--brown);font-size:.85rem; }
  .trip-sub  { font-size:.72rem;color:rgba(59,42,26,.38);margin-top:2px; }
  .trip-sub .arr { color:rgba(59,42,26,.25); }

  .pager { margin-top:16px;display:flex;justify-content:flex-end; }

  @media(max-width:768px){ table { font-size:.75rem; } }
</style>

<div class="page-header">
  <div>
    <div class="page-title">Schedules</div>
    <div class="page-sub">Manage all flight schedules</div>
  </div>
  <a href="<?php echo e(route('admin.schedules.create')); ?>" class="btn-primary">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Schedule
  </a>
</div>

<form method="GET" action="<?php echo e(route('admin.schedules.index')); ?>">
  <div class="filters-bar">
    <input type="text" name="search" placeholder="Search trip, route, operator…" value="<?php echo e(request('search')); ?>">
    <select name="fare_class">
      <option value="">All Classes</option>
      <option value="economy"  <?php echo e(request('fare_class')==='economy'  ?'selected':''); ?>>Economy</option>
      <option value="business" <?php echo e(request('fare_class')==='business' ?'selected':''); ?>>Business</option>
      <option value="first"    <?php echo e(request('fare_class')==='first'    ?'selected':''); ?>>First Class</option>
    </select>
    <select name="status">
      <option value="">All Statuses</option>
      <option value="scheduled" <?php echo e(request('status')==='scheduled' ?'selected':''); ?>>Scheduled</option>
      <option value="completed" <?php echo e(request('status')==='completed' ?'selected':''); ?>>Completed</option>
      <option value="cancelled" <?php echo e(request('status')==='cancelled' ?'selected':''); ?>>Cancelled</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
    <?php if(request()->hasAny(['search','fare_class','status'])): ?>
      <a href="<?php echo e(route('admin.schedules.index')); ?>" class="clear-link">Clear</a>
    <?php endif; ?>
  </div>
</form>

<div class="table-wrap">
  <?php if($schedules->count()): ?>
  <table>
    <thead>
      <tr>
        <th>Trip / Route</th>
        <th>Departure</th>
        <th>Arrival</th>
        <th>Class</th>
        <th>Fare</th>
        <th>Seats</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__currentLoopData = $schedules; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $schedule): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <tr>
        <td>
          <div class="trip-name"><?php echo e($schedule->trip->name ?? '—'); ?></div>
          <div class="trip-sub">
            <?php echo e($schedule->trip->origin ?? '?'); ?>

            <span class="arr">→</span>
            <?php echo e($schedule->trip->destination ?? '?'); ?>

            <?php if($schedule->trip->operator ?? null): ?>
              &nbsp;·&nbsp;<?php echo e($schedule->trip->operator); ?>

            <?php endif; ?>
          </div>
        </td>
        <td>
          <div style="font-weight:600;color:var(--brown);font-size:.83rem;"><?php echo e($schedule->departure_at->format('M d, Y')); ?></div>
          <div style="font-size:.72rem;color:rgba(59,42,26,.38);"><?php echo e($schedule->departure_at->format('H:i')); ?></div>
        </td>
        <td>
          <div style="font-weight:600;color:var(--brown);font-size:.83rem;"><?php echo e($schedule->arrival_at->format('M d, Y')); ?></div>
          <div style="font-size:.72rem;color:rgba(59,42,26,.38);"><?php echo e($schedule->arrival_at->format('H:i')); ?></div>
        </td>
        <td>
          <?php $fc = $schedule->fare_class; ?>
          <span class="pill <?php echo e($fc==='first'?'pill-amber':($fc==='business'?'pill-blue':'pill-gray')); ?>">
            <?php echo e(ucfirst($fc)); ?>

          </span>
        </td>
        <td style="font-family:monospace;font-weight:700;color:var(--gold);">&#8369;<?php echo e(number_format($schedule->base_fare, 2)); ?></td>
        <td>
          <span style="font-weight:700;color:<?php echo e($schedule->available_seats < 10 ? '#b44444' : 'var(--teal)'); ?>;">
            <?php echo e($schedule->available_seats); ?>

          </span>
          <span style="color:rgba(59,42,26,.25);font-size:.78rem;"> / <?php echo e($schedule->capacity); ?></span>
        </td>
        <td>
          <?php $st = $schedule->status; ?>
          <span class="pill <?php echo e($st==='scheduled'?'pill-green':($st==='completed'?'pill-blue':'pill-red')); ?>">
            <?php echo e(ucfirst($st)); ?>

          </span>
        </td>
        <td>
          <div style="display:flex;gap:5px;align-items:center;">
            <a href="<?php echo e(route('admin.schedules.edit', $schedule)); ?>" class="act-btn act-edit">Edit</a>
            <form method="POST" action="<?php echo e(route('admin.schedules.destroy', $schedule)); ?>"
                  onsubmit="return confirm('Delete this schedule?')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="act-btn act-del">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </tbody>
  </table>
  <?php else: ?>
    <div style="padding:52px;text-align:center;color:rgba(59,42,26,.3);font-size:.88rem;">
      No schedules found.
      <a href="<?php echo e(route('admin.schedules.create')); ?>" style="color:var(--teal);text-decoration:none;margin-left:4px;font-weight:600;">Add one →</a>
    </div>
  <?php endif; ?>
</div>

<div class="pager"><?php echo e($schedules->withQueryString()->links()); ?></div>

<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/schedules/index.blade.php ENDPATH**/ ?>