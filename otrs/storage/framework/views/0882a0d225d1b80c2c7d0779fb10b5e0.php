
<?php $__env->startSection('page-title', 'Edit Schedule'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .back-link{display:inline-flex;align-items:center;gap:6px;color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;font-weight:500;transition:color .15s;}
  .back-link:hover{color:var(--teal);}
  .back-link svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;}
  .sch-header{display:flex;align-items:flex-start;justify-content:space-between;margin-bottom:22px;flex-wrap:wrap;gap:12px;}
  .sch-title{font-family:var(--ff-head);font-size:1.3rem;font-weight:900;color:var(--brown);}
  .sch-sub{font-size:.8rem;color:rgba(59,42,26,.4);margin-top:3px;}
  .panel{background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:24px 26px;margin-bottom:16px;box-shadow:0 2px 12px rgba(59,42,26,.05);}
  .section-title{font-family:var(--ff-head);font-size:.95rem;font-weight:700;color:var(--brown);margin-bottom:18px;padding-bottom:12px;border-bottom:1.5px solid rgba(59,42,26,.07);display:flex;align-items:center;gap:8px;}
  .section-title svg{width:14px;height:14px;stroke:var(--teal);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0;}
  .f-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px;}
  .f-group{margin-bottom:4px;}
  .f-label{font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:7px;display:block;}
  .f-label .req{color:#b44444;margin-left:2px;}
  .f-input,.f-select{width:100%;background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:var(--radius-sm);padding:10px 14px;font-size:.88rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s;}
  .f-input:focus,.f-select:focus{border-color:var(--teal);background:var(--white);}
  .f-hint{font-size:.72rem;color:rgba(59,42,26,.35);margin-top:5px;}
  .f-warn{font-size:.72rem;color:#9a7030;margin-top:5px;}
  .f-error-banner{background:rgba(180,68,68,.06);border:1.5px solid rgba(180,68,68,.2);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:18px;font-size:.84rem;color:#b44444;}
  .btn-row{display:flex;gap:10px;justify-content:flex-end;margin-top:8px;align-items:center;}
  .btn-save{background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:10px 28px;font-size:.88rem;font-weight:600;cursor:pointer;font-family:var(--ff-body);transition:background .18s,transform .15s;box-shadow:0 4px 14px rgba(45,110,110,.25);}
  .btn-save:hover{background:var(--teal-lt);transform:translateY(-1px);}
  .btn-cancel{background:transparent;color:rgba(59,42,26,.45);border:1.5px solid rgba(59,42,26,.14);border-radius:50px;padding:10px 22px;font-size:.88rem;font-weight:500;cursor:pointer;text-decoration:none;font-family:var(--ff-body);transition:all .15s;display:inline-flex;align-items:center;}
  .btn-cancel:hover{color:var(--brown);border-color:rgba(59,42,26,.3);}
  @media(max-width:640px){.f-grid{grid-template-columns:1fr;}.sch-header{flex-direction:column;}}
</style>

<div class="sch-header">
  <div>
    <div class="sch-title">Edit Schedule #<?php echo e($schedule->id); ?></div>
    <div class="sch-sub"><?php echo e($schedule->trip->name); ?> — <?php echo e($schedule->trip->origin); ?> → <?php echo e($schedule->trip->destination); ?></div>
  </div>
  <a href="<?php echo e(route('admin.schedules.index')); ?>" class="back-link">
    <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
    Back
  </a>
</div>

<?php if($errors->isNotEmpty()): ?>
  <div class="f-error-banner">Please fix the following errors: <?php echo e($errors->first()); ?></div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.schedules.update', $schedule)); ?>">
<?php echo csrf_field(); ?> <?php echo method_field('PUT'); ?>

<div class="panel">
  <div class="section-title">
    <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
    Trip & Schedule Details
  </div>
  <div class="f-group" style="margin-bottom:16px;">
    <label class="f-label">Trip <span class="req">*</span></label>
    <select name="trip_id" class="f-select" required>
      <option value="">— Select a Trip —</option>
      <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <option value="<?php echo e($trip->id); ?>" <?php echo e(old('trip_id',$schedule->trip_id)==$trip->id?'selected':''); ?>>
          <?php echo e($trip->name); ?> (<?php echo e($trip->origin); ?> → <?php echo e($trip->destination); ?>)<?php if($trip->operator): ?> — <?php echo e($trip->operator); ?><?php endif; ?>
        </option>
      <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </select>
  </div>
  <div class="f-grid">
    <div class="f-group">
      <label class="f-label">Departure Date & Time <span class="req">*</span></label>
      <input type="datetime-local" name="departure_at" class="f-input"
             value="<?php echo e(old('departure_at', $schedule->departure_at->format('Y-m-d\TH:i'))); ?>" required>
    </div>
    <div class="f-group">
      <label class="f-label">Arrival Date & Time <span class="req">*</span></label>
      <input type="datetime-local" name="arrival_at" class="f-input"
             value="<?php echo e(old('arrival_at', $schedule->arrival_at->format('Y-m-d\TH:i'))); ?>" required>
    </div>
  </div>
</div>

<div class="panel">
  <div class="section-title">
    <svg viewBox="0 0 24 24"><path d="M20.59 13.41l-7.17 7.17a2 2 0 0 1-2.83 0L2 12V2h10l8.59 8.59a2 2 0 0 1 0 2.82z"/><line x1="7" y1="7" x2="7.01" y2="7"/></svg>
    Capacity & Pricing
  </div>
  <div class="f-grid">
    <div class="f-group">
      <label class="f-label">Total Capacity <span class="req">*</span></label>
      <input type="number" name="capacity" class="f-input"
             value="<?php echo e(old('capacity', $schedule->capacity)); ?>" min="1" max="1000" required>
    </div>
    <div class="f-group">
      <label class="f-label">Available Seats <span class="req">*</span></label>
      <input type="number" name="available_seats" class="f-input"
             value="<?php echo e(old('available_seats', $schedule->available_seats)); ?>" min="0" required>
      <div class="f-hint">Current bookings may have reduced this.</div>
    </div>
    <div class="f-group">
      <label class="f-label">Fare Class <span class="req">*</span></label>
      <select name="fare_class" class="f-select" required>
        <option value="economy"  <?php echo e(old('fare_class',$schedule->fare_class)==='economy'?'selected':''); ?>>Economy</option>
        <option value="business" <?php echo e(old('fare_class',$schedule->fare_class)==='business'?'selected':''); ?>>Business</option>
        <option value="first"    <?php echo e(old('fare_class',$schedule->fare_class)==='first'?'selected':''); ?>>First Class</option>
      </select>
    </div>
    <div class="f-group">
      <label class="f-label">Base Fare (PHP) <span class="req">*</span></label>
      <input type="number" name="base_fare" class="f-input"
             value="<?php echo e(old('base_fare', $schedule->base_fare)); ?>" min="0" step="0.01" required>
    </div>
    <div class="f-group">
      <label class="f-label">Status <span class="req">*</span></label>
      <select name="status" class="f-select" required>
        <option value="scheduled" <?php echo e(old('status',$schedule->status)==='scheduled'?'selected':''); ?>>Scheduled</option>
        <option value="cancelled" <?php echo e(old('status',$schedule->status)==='cancelled'?'selected':''); ?>>Cancelled</option>
        <option value="completed" <?php echo e(old('status',$schedule->status)==='completed'?'selected':''); ?>>Completed</option>
      </select>
    </div>
  </div>
</div>

<div class="btn-row">
  <a href="<?php echo e(route('admin.schedules.index')); ?>" class="btn-cancel">Cancel</a>
  <button type="submit" class="btn-save">Update Schedule</button>
</div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/schedules/edit.blade.php ENDPATH**/ ?>