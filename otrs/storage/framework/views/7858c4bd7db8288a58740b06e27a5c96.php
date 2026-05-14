
<?php $__env->startSection('page-title', 'Add Schedule'); ?>

<?php $__env->startSection('content'); ?>
<style>
.page-header{display:flex;align-items:center;justify-content:space-between;margin-bottom:20px}
.page-title{font-size:18px;font-weight:700;color:#fff}
.page-sub{font-size:11px;color:#555;margin-top:2px}
.panel{background:#1a1b1b;border:1px solid #2a2b2b;border-radius:12px;padding:24px;margin-bottom:16px}
.f-grid{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.f-group{margin-bottom:16px}
.f-label{font-size:11px;color:#aaa;margin-bottom:6px;display:block;text-transform:uppercase;letter-spacing:.5px}
.req{color:#FF6044}
.f-input,.f-select{width:100%;background:#0e0f0f;border:0.5px solid #2a2b2b;border-radius:8px;padding:10px 14px;font-size:13px;color:#fff;outline:none;font-family:sans-serif;transition:.15s}
.f-input:focus,.f-select:focus{border-color:#FF6044}
.f-select option{background:#1a1b1b}
.btn-row{display:flex;gap:12px;justify-content:flex-end;margin-top:8px}
.btn-cancel{background:transparent;color:#888;border:0.5px solid #2a2b2b;border-radius:8px;padding:10px 22px;font-size:13px;cursor:pointer;text-decoration:none;display:inline-block;transition:.15s}
.btn-cancel:hover{border-color:#555;color:#ccc}
.btn-save{background:#FF6044;color:#fff;border:none;border-radius:8px;padding:10px 28px;font-size:13px;font-weight:600;cursor:pointer;transition:.15s}
.btn-save:hover{background:#e5532e}
.alert-error{background:rgba(224,85,85,.1);border:0.5px solid rgba(224,85,85,.4);border-radius:8px;padding:10px 14px;font-size:12px;color:#e05555;margin-bottom:14px}
.section-title{font-size:13px;font-weight:600;color:#ccc;margin-bottom:16px;padding-bottom:10px;border-bottom:0.5px solid #2a2b2b}
@media(max-width:640px){.f-grid{grid-template-columns:1fr}}
</style>

<div class="page-header">
    <div>
        <div class="page-title">Add New Schedule</div>
        <div class="page-sub">Create a new flight schedule for users to book</div>
    </div>
    <a href="<?php echo e(route('admin.schedules.index')); ?>" class="btn-cancel">← Back</a>
</div>

<?php if($errors->isNotEmpty()): ?>
    <div class="alert-error"><strong>Please fix the following errors:</strong><br><?php echo e($errors->first()); ?></div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('admin.schedules.store')); ?>">
<?php echo csrf_field(); ?>

<div class="panel">
    <div class="section-title">✈ Trip & Schedule Details</div>

    <div class="f-group">
        <label class="f-label">Trip <span class="req">*</span></label>
        <select name="trip_id" class="f-select" required>
            <option value="">— Select a Trip —</option>
            <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <option value="<?php echo e($trip->id); ?>" <?php echo e(old('trip_id')==$trip->id?'selected':''); ?>>
                    <?php echo e($trip->name); ?> (<?php echo e($trip->origin); ?> → <?php echo e($trip->destination); ?>)
                    <?php if($trip->operator): ?> — <?php echo e($trip->operator); ?> <?php endif; ?>
                </option>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php if($trips->isEmpty()): ?>
            <div style="font-size:11px;color:#ffc444;margin-top:6px">⚠ No active trips found. <a href="<?php echo e(route('admin.trips.create')); ?>" style="color:#FF6044">Add a trip first →</a></div>
        <?php endif; ?>
    </div>

    <div class="f-grid">
        <div class="f-group">
            <label class="f-label">Departure Date & Time <span class="req">*</span></label>
            <input type="datetime-local" name="departure_at" class="f-input"
                   value="<?php echo e(old('departure_at')); ?>" required>
        </div>
        <div class="f-group">
            <label class="f-label">Arrival Date & Time <span class="req">*</span></label>
            <input type="datetime-local" name="arrival_at" class="f-input"
                   value="<?php echo e(old('arrival_at')); ?>" required>
        </div>
    </div>
</div>

<div class="panel">
    <div class="section-title">💺 Capacity & Pricing</div>

    <div class="f-grid">
        <div class="f-group">
            <label class="f-label">Total Capacity <span class="req">*</span></label>
            <input type="number" name="capacity" class="f-input"
                   value="<?php echo e(old('capacity', 150)); ?>" min="1" max="1000" required>
        </div>
        <div class="f-group">
            <label class="f-label">Fare Class <span class="req">*</span></label>
            <select name="fare_class" class="f-select" required>
                <option value="">— Select Class —</option>
                <option value="economy"  <?php echo e(old('fare_class')==='economy'?'selected':''); ?>>Economy</option>
                <option value="business" <?php echo e(old('fare_class')==='business'?'selected':''); ?>>Business</option>
                <option value="first"    <?php echo e(old('fare_class')==='first'?'selected':''); ?>>First Class</option>
            </select>
        </div>
        <div class="f-group">
            <label class="f-label">Base Fare (PHP) <span class="req">*</span></label>
            <input type="number" name="base_fare" class="f-input"
                   value="<?php echo e(old('base_fare')); ?>" min="0" step="0.01" placeholder="e.g. 2500.00" required>
        </div>
        <div class="f-group">
            <label class="f-label">Status <span class="req">*</span></label>
            <select name="status" class="f-select" required>
                <option value="scheduled" <?php echo e(old('status','scheduled')==='scheduled'?'selected':''); ?>>Scheduled</option>
                <option value="cancelled" <?php echo e(old('status')==='cancelled'?'selected':''); ?>>Cancelled</option>
                <option value="completed" <?php echo e(old('status')==='completed'?'selected':''); ?>>Completed</option>
            </select>
        </div>
    </div>
    <div style="font-size:11px;color:#555;margin-top:-8px">
        💡 Available seats will automatically be set equal to total capacity when created.
    </div>
</div>

<div class="btn-row">
    <a href="<?php echo e(route('admin.schedules.index')); ?>" class="btn-cancel">Cancel</a>
    <button type="submit" class="btn-save">✓ Create Schedule</button>
</div>
</form>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/schedules/create.blade.php ENDPATH**/ ?>