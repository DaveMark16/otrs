
<?php $__env->startSection('page-title', 'Promo Detail'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .back-link { display:inline-flex;align-items:center;gap:6px;color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;font-weight:500;margin-bottom:18px;transition:color .15s; }
  .back-link:hover { color:var(--teal); }
  .back-link svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }

  .page-header { display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px; }
  .page-title  { font-family:var(--ff-head);font-size:1.35rem;font-weight:900;color:var(--brown); }
  .page-sub    { font-size:.78rem;color:rgba(59,42,26,.38);margin-top:3px; }

  .btn-edit { background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:9px 22px;font-size:.84rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .18s;box-shadow:0 3px 12px rgba(45,110,110,.22); }
  .btn-edit:hover { background:var(--teal-lt); }
  .btn-del { background:transparent;color:#b44444;border:1.5px solid rgba(180,68,68,.3);border-radius:50px;padding:9px 22px;font-size:.84rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:all .15s;font-family:var(--ff-body); }
  .btn-del:hover { background:rgba(180,68,68,.07); }

  /* Hero card */
  .hero-card { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:24px 26px;margin-bottom:16px;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:20px;box-shadow:0 2px 12px rgba(59,42,26,.05); }
  .hero-discount { font-family:var(--ff-head);font-size:2.4rem;font-weight:900;color:var(--gold);line-height:1; }
  .hero-sub { font-size:.78rem;color:rgba(59,42,26,.38);margin-top:5px; }
  .hero-code-label { font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.35);margin-bottom:8px; }
  .code-tag { font-family:monospace;background:rgba(45,110,110,.07);border:1.5px solid rgba(45,110,110,.18);border-radius:8px;padding:6px 14px;font-size:1rem;font-weight:700;color:var(--teal);letter-spacing:.1em; }
  .hero-validity { font-size:.75rem;color:rgba(59,42,26,.35);margin-top:6px;text-align:right; }

  /* Pills */
  .pill { display:inline-flex;align-items:center;padding:4px 12px;border-radius:20px;font-size:.72rem;font-weight:700; }
  .pill-green { background:rgba(45,110,110,.1);color:var(--teal); }
  .pill-amber { background:rgba(212,162,84,.14);color:#9a7030; }
  .pill-gray  { background:rgba(59,42,26,.07);color:rgba(59,42,26,.45); }
  .pill-blue  { background:rgba(45,110,110,.08);color:var(--teal); }

  /* Detail card */
  .card { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:22px 26px;margin-bottom:16px;box-shadow:0 2px 12px rgba(59,42,26,.05); }
  .card:last-child { margin-bottom:0; }
  .card-title { font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.35);margin-bottom:18px;padding-bottom:12px;border-bottom:1.5px solid rgba(59,42,26,.07);display:flex;align-items:center;gap:8px; }
  .card-title-dot { width:7px;height:7px;border-radius:50%;background:var(--gold);flex-shrink:0; }

  .detail-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(180px,1fr));gap:18px; }
  .detail-item label { font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(59,42,26,.35);display:block;margin-bottom:5px; }
  .detail-item .val { font-size:.88rem;color:rgba(59,42,26,.65);font-weight:500; }

  /* Trip pill */
  .trip-pill { display:inline-flex;align-items:center;gap:7px;background:var(--sand);border:1.5px solid rgba(59,42,26,.09);border-radius:8px;padding:6px 12px;font-size:.78rem;margin:3px; }
  .trip-pill svg { width:12px;height:12px;stroke:rgba(59,42,26,.4);fill:none;stroke-width:1.8;flex-shrink:0; }
  .trip-pill .t-name { font-weight:600;color:var(--brown); }
  .trip-pill .t-route { color:rgba(59,42,26,.4);font-size:.71rem; }
</style>

<a href="<?php echo e(route('admin.promos.index')); ?>" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Back to Promos
</a>

<div class="page-header">
  <div>
    <div class="page-title"><?php echo e($promo->title); ?></div>
    <div class="page-sub">Promo ID #<?php echo e($promo->id); ?></div>
  </div>
  <div style="display:flex;gap:8px;align-items:center;">
    <a href="<?php echo e(route('admin.promos.edit', $promo)); ?>" class="btn-edit">Edit</a>
    <form method="POST" action="<?php echo e(route('admin.promos.destroy', $promo)); ?>"
          onsubmit="return confirm('Delete this promo permanently?')" style="display:inline">
      <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
      <button type="submit" class="btn-del">Delete</button>
    </form>
  </div>
</div>


<div class="hero-card">
  <div>
    <div class="hero-discount"><?php echo e($promo->formatted_discount); ?></div>
    <div class="hero-sub"><?php echo e($promo->discount_type === 'percentage' ? 'Percentage discount' : 'Fixed amount off'); ?></div>
  </div>
  <div style="text-align:center;">
    <div class="hero-code-label">Promo Code</div>
    <div class="code-tag"><?php echo e($promo->promo_code); ?></div>
  </div>
  <div style="text-align:right;">
    <?php $status = $promo->status; ?>
    <span class="pill <?php echo e($status==='active'?'pill-green':($status==='upcoming'?'pill-amber':'pill-gray')); ?>">
      <?php echo e(ucfirst($status)); ?>

    </span>
    <div class="hero-validity"><?php echo e($promo->start_date->format('M d, Y')); ?> — <?php echo e($promo->end_date->format('M d, Y')); ?></div>
  </div>
</div>


<div class="card">
  <div class="card-title"><span class="card-title-dot"></span>Details</div>
  <div class="detail-grid">
    <div class="detail-item">
      <label>Title</label>
      <div class="val"><?php echo e($promo->title); ?></div>
    </div>
    <div class="detail-item">
      <label>Discount Type</label>
      <div class="val"><?php echo e($promo->discount_type === 'percentage' ? 'Percentage (%)' : 'Fixed Amount (₱)'); ?></div>
    </div>
    <div class="detail-item">
      <label>Discount Value</label>
      <div class="val" style="color:var(--gold);font-weight:700;"><?php echo e($promo->formatted_discount); ?></div>
    </div>
    <div class="detail-item">
      <label>Start Date</label>
      <div class="val"><?php echo e($promo->start_date->format('F d, Y')); ?></div>
    </div>
    <div class="detail-item">
      <label>End Date</label>
      <div class="val"><?php echo e($promo->end_date->format('F d, Y')); ?></div>
    </div>
    <div class="detail-item">
      <label>Created At</label>
      <div class="val"><?php echo e($promo->created_at->format('M d, Y')); ?></div>
    </div>
  </div>
  <?php if($promo->description): ?>
  <div style="margin-top:18px;padding-top:16px;border-top:1.5px solid rgba(59,42,26,.07);">
    <label style="font-size:.68rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:rgba(59,42,26,.35);display:block;margin-bottom:6px;">Description</label>
    <p style="font-size:.85rem;color:rgba(59,42,26,.55);line-height:1.65;"><?php echo e($promo->description); ?></p>
  </div>
  <?php endif; ?>
</div>


<div class="card">
  <div class="card-title"><span class="card-title-dot" style="background:var(--teal);"></span>Applicable Trips</div>
  <?php if($promo->applies_to_all): ?>
    <div style="display:flex;align-items:center;gap:12px;">
      <span class="pill pill-blue">All Trips</span>
      <span style="font-size:.84rem;color:rgba(59,42,26,.4);">This promo applies to all available trips.</span>
    </div>
  <?php elseif($promo->trips->count()): ?>
    <div>
      <?php $__currentLoopData = $promo->trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
      <span class="trip-pill">
        <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
        <span class="t-name"><?php echo e($trip->name); ?></span>
        <span class="t-route"><?php echo e($trip->origin); ?> → <?php echo e($trip->destination); ?></span>
      </span>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </div>
  <?php else: ?>
    <p style="font-size:.84rem;color:rgba(59,42,26,.3);">No trips assigned.</p>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/promos/show.blade.php ENDPATH**/ ?>