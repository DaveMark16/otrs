
<?php $__env->startSection('page-title', 'Promo Management'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .page-header { display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px; }
  .page-title { font-family:var(--ff-head);font-size:1.4rem;font-weight:900;color:var(--brown); }
  .page-sub { font-size:.8rem;color:rgba(59,42,26,.4);margin-top:3px; }
  .btn-primary { background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:10px 22px;font-size:.86rem;font-weight:600;cursor:pointer;text-decoration:none;display:inline-flex;align-items:center;gap:6px;transition:background .18s,transform .15s;box-shadow:0 4px 14px rgba(45,110,110,.25);font-family:var(--ff-body); }
  .btn-primary:hover { background:var(--teal-lt);transform:translateY(-1px); }

  .flash-success { background:rgba(45,110,110,.06);border:1.5px solid rgba(45,110,110,.2);border-radius:var(--radius-sm);padding:12px 16px;color:var(--teal);font-size:.84rem;margin-bottom:18px;display:flex;align-items:center;gap:8px; }

  .filters-bar { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:16px 18px;display:flex;gap:10px;margin-bottom:18px;align-items:center;flex-wrap:wrap;box-shadow:0 2px 10px rgba(59,42,26,.04); }
  .filters-bar input,.filters-bar select { background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:50px;padding:8px 16px;font-size:.84rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s; }
  .filters-bar input { flex:1;min-width:220px; }
  .filters-bar input:focus,.filters-bar select:focus { border-color:var(--teal); }
  .filters-bar input::placeholder { color:rgba(59,42,26,.3); }
  .filter-btn { background:var(--teal);border:none;border-radius:50px;padding:8px 22px;font-size:.84rem;font-weight:600;color:var(--white);cursor:pointer;font-family:var(--ff-body);transition:background .18s; }
  .filter-btn:hover { background:var(--teal-lt); }
  .clear-link { color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;padding:7px 14px;border:1.5px solid rgba(59,42,26,.12);border-radius:50px;transition:all .15s; }
  .clear-link:hover { color:var(--brown);border-color:rgba(59,42,26,.28); }

  .table-wrap { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 16px rgba(59,42,26,.06); }
  table { width:100%;border-collapse:collapse; }
  thead th { padding:12px 16px;text-align:left;font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);border-bottom:1.5px solid rgba(59,42,26,.07);background:var(--sand);white-space:nowrap; }
  tbody tr { border-bottom:1px solid rgba(59,42,26,.06);transition:background .1s; }
  tbody tr:last-child { border-bottom:none; }
  tbody tr:hover { background:rgba(245,237,224,.45); }
  tbody td { padding:12px 16px;font-size:.83rem;color:rgba(59,42,26,.55);vertical-align:middle; }

  .pill { display:inline-flex;align-items:center;padding:3px 10px;border-radius:20px;font-size:.7rem;font-weight:700; }
  .pill-green { background:rgba(45,110,110,.1);color:var(--teal); }
  .pill-amber { background:rgba(212,162,84,.14);color:#9a7030; }
  .pill-gray  { background:rgba(59,42,26,.07);color:rgba(59,42,26,.45); }
  .pill-blue  { background:rgba(45,110,110,.08);color:var(--teal); }

  .code-tag { font-family:monospace;background:rgba(45,110,110,.07);border:1.5px solid rgba(45,110,110,.15);border-radius:6px;padding:3px 9px;font-size:.73rem;font-weight:700;color:var(--teal);letter-spacing:.06em; }

  .act-btn { padding:5px 13px;border-radius:50px;font-size:.75rem;font-weight:600;cursor:pointer;border:1.5px solid;background:transparent;text-decoration:none;transition:all .15s;font-family:var(--ff-body);display:inline-flex;align-items:center;gap:4px;white-space:nowrap; }
  .act-view   { color:var(--teal);border-color:rgba(45,110,110,.3); }
  .act-view:hover   { background:rgba(45,110,110,.08); }
  .act-edit   { color:rgba(59,42,26,.5);border-color:rgba(59,42,26,.18); }
  .act-edit:hover   { background:rgba(59,42,26,.05);color:var(--brown); }
  .act-delete { color:#b44444;border-color:rgba(180,68,68,.25); }
  .act-delete:hover { background:rgba(180,68,68,.08); }

  .pag-wrap { padding:14px 18px;border-top:1.5px solid rgba(59,42,26,.07);display:flex;justify-content:center; }

  .empty-state { padding:60px 20px;text-align:center; }
  .empty-state svg { width:36px;height:36px;margin:0 auto 12px;display:block;stroke:rgba(59,42,26,.2);fill:none;stroke-width:1.5;stroke-linecap:round; }
  .empty-state p { color:rgba(59,42,26,.35);font-size:.88rem;margin-bottom:10px; }
  .empty-state a { color:var(--teal);text-decoration:none;font-size:.84rem;font-weight:600; }
</style>

<div class="page-header">
  <div>
    <div class="page-title">Promo Management</div>
    <div class="page-sub">Create and manage discount promos &amp; promo codes</div>
  </div>
  <a href="<?php echo e(route('admin.promos.create')); ?>" class="btn-primary">
    <svg width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Promo
  </a>
</div>

<?php if(session('success')): ?>
  <div class="flash-success">
    <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
    <?php echo e(session('success')); ?>

  </div>
<?php endif; ?>

<form method="GET" action="<?php echo e(route('admin.promos.index')); ?>">
  <div class="filters-bar">
    <input type="text" name="search" placeholder="Search title or code…" value="<?php echo e(request('search')); ?>">
    <select name="status">
      <option value="">All Status</option>
      <option value="active"   <?php echo e(request('status')==='active'   ?'selected':''); ?>>Active</option>
      <option value="upcoming" <?php echo e(request('status')==='upcoming' ?'selected':''); ?>>Upcoming</option>
      <option value="expired"  <?php echo e(request('status')==='expired'  ?'selected':''); ?>>Expired</option>
    </select>
    <button type="submit" class="filter-btn">Filter</button>
    <?php if(request()->hasAny(['search','status'])): ?>
      <a href="<?php echo e(route('admin.promos.index')); ?>" class="clear-link">Clear</a>
    <?php endif; ?>
  </div>
</form>

<div class="table-wrap">
  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Title</th>
        <th>Code</th>
        <th>Discount</th>
        <th>Validity</th>
        <th>Trips</th>
        <th>Status</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $__empty_1 = true; $__currentLoopData = $promos; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $promo): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
      <tr>
        <td style="color:rgba(59,42,26,.3);font-size:.75rem;"><?php echo e($promo->id); ?></td>
        <td style="font-weight:600;color:var(--brown);max-width:180px;">
          <div style="overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"><?php echo e($promo->title); ?></div>
        </td>
        <td><span class="code-tag"><?php echo e($promo->promo_code); ?></span></td>
        <td style="font-weight:700;color:var(--gold);"><?php echo e($promo->formatted_discount); ?></td>
        <td>
          <div style="font-size:.8rem;font-weight:600;color:var(--brown);"><?php echo e($promo->start_date->format('M d, Y')); ?></div>
          <div style="font-size:.72rem;color:rgba(59,42,26,.35);">→ <?php echo e($promo->end_date->format('M d, Y')); ?></div>
        </td>
        <td style="text-align:center;">
          <?php if($promo->applies_to_all): ?>
            <span class="pill pill-blue">All</span>
          <?php else: ?>
            <span style="font-weight:700;color:var(--brown);"><?php echo e($promo->trips_count); ?></span>
          <?php endif; ?>
        </td>
        <td>
          <?php $status = $promo->status; ?>
          <span class="pill <?php echo e($status==='active'?'pill-green':($status==='upcoming'?'pill-amber':'pill-gray')); ?>">
            <?php echo e(ucfirst($status)); ?>

          </span>
        </td>
        <td>
          <div style="display:flex;gap:5px;flex-wrap:wrap;align-items:center;">
            <a href="<?php echo e(route('admin.promos.show', $promo)); ?>" class="act-btn act-view">View</a>
            <a href="<?php echo e(route('admin.promos.edit', $promo)); ?>" class="act-btn act-edit">Edit</a>
            <form method="POST" action="<?php echo e(route('admin.promos.destroy', $promo)); ?>"
                  onsubmit="return confirm('Delete this promo?')" style="display:inline">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="act-btn act-delete">Delete</button>
            </form>
          </div>
        </td>
      </tr>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
      <tr>
        <td colspan="8">
          <div class="empty-state">
            <svg viewBox="0 0 24 24"><path d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/><path d="M6 6h.008v.008H6V6z"/></svg>
            <p>No promos found.</p>
            <a href="<?php echo e(route('admin.promos.create')); ?>">Create your first promo →</a>
          </div>
        </td>
      </tr>
      <?php endif; ?>
    </tbody>
  </table>
  <?php if($promos->hasPages()): ?>
    <div class="pag-wrap"><?php echo e($promos->links()); ?></div>
  <?php endif; ?>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/promos/index.blade.php ENDPATH**/ ?>