
<?php $__env->startSection('page-title', 'Edit User'); ?>

<?php $__env->startSection('content'); ?>
<style>
  .back-link {
    display: inline-flex; align-items: center; gap: 6px;
    color: rgba(59,42,26,.4); text-decoration: none;
    font-size: .82rem; font-weight: 500; margin-bottom: 22px;
    transition: color .15s;
  }
  .back-link:hover { color: var(--teal); }
  .back-link svg { width: 14px; height: 14px; stroke: currentColor; fill: none; stroke-width: 2; stroke-linecap: round; }

  .form-card {
    background: var(--white); border: 1.5px solid rgba(59,42,26,.08);
    border-radius: var(--radius); padding: 28px 30px;
    max-width: 620px;
    box-shadow: 0 4px 24px rgba(59,42,26,.07);
  }
  .form-card-title {
    font-family: var(--ff-head); font-size: 1.25rem; font-weight: 700;
    color: var(--brown); margin-bottom: 22px;
    padding-bottom: 16px; border-bottom: 1.5px solid rgba(59,42,26,.07);
    display: flex; align-items: center; gap: 10px;
  }
  .form-card-title span {
    font-size: .75rem; font-weight: 700; letter-spacing: .1em;
    text-transform: uppercase; background: rgba(45,110,110,.08);
    color: var(--teal); border: 1px solid rgba(45,110,110,.18);
    border-radius: 20px; padding: 3px 10px;
  }

  .form-group { margin-bottom: 18px; }
  .form-label {
    display: block; font-size: .7rem; font-weight: 700;
    letter-spacing: .1em; text-transform: uppercase;
    color: rgba(59,42,26,.38); margin-bottom: 7px;
  }
  .form-input {
    width: 100%; background: var(--cream);
    border: 1.5px solid rgba(59,42,26,.12);
    border-radius: var(--radius-sm); padding: 10px 14px;
    font-size: .88rem; font-family: var(--ff-body);
    color: var(--brown); outline: none; transition: border-color .2s;
  }
  .form-input:focus { border-color: var(--teal); background: var(--white); }
  .form-input.error { border-color: #b44444; }
  .form-error { font-size: .75rem; color: #b44444; margin-top: 5px; }
  .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }

  .btn-save {
    background: var(--teal); color: var(--white);
    border: none; border-radius: 50px;
    padding: 10px 28px; font-size: .88rem; font-weight: 600;
    cursor: pointer; font-family: var(--ff-body);
    transition: background .18s, transform .15s;
    box-shadow: 0 4px 14px rgba(45,110,110,.25);
  }
  .btn-save:hover { background: var(--teal-lt); transform: translateY(-1px); }
  .btn-cancel {
    background: transparent; color: rgba(59,42,26,.45);
    border: 1.5px solid rgba(59,42,26,.14); border-radius: 50px;
    padding: 10px 22px; font-size: .88rem; font-weight: 500;
    cursor: pointer; text-decoration: none; font-family: var(--ff-body);
    transition: all .15s; display: inline-flex; align-items: center;
  }
  .btn-cancel:hover { color: var(--brown); border-color: rgba(59,42,26,.3); }

  @media (max-width: 540px) { .form-row { grid-template-columns: 1fr; } }
</style>

<a href="<?php echo e(route('admin.users.index')); ?>" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Back to Users
</a>

<div class="form-card">
  <div class="form-card-title">
    Edit User: <?php echo e($user->name); ?>

    <span><?php echo e(ucfirst($user->role)); ?></span>
  </div>
    
  <form method="POST" action="<?php echo e(route('admin.users.update', $user)); ?>">
    <?php echo csrf_field(); ?> <?php echo method_field('PATCH'); ?>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Name</label>
        <input type="text" name="name" class="form-input <?php echo e($errors->has('name') ? 'error' : ''); ?>"
               value="<?php echo e(old('name', $user->name)); ?>" required>
        <?php $__errorArgs = ['name'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label class="form-label">Phone</label>
        <input type="text" name="phone" class="form-input"
               value="<?php echo e(old('phone', $user->phone)); ?>" placeholder="Optional">
      </div>
    </div>

    <div class="form-group">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-input <?php echo e($errors->has('email') ? 'error' : ''); ?>"
             value="<?php echo e(old('email', $user->email)); ?>" required>
      <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Role</label>
        <select name="role" class="form-input">
          <?php $__currentLoopData = ['traveler','business','tourist','commuter','corporate','passenger','admin','superadmin']; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $r): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <option value="<?php echo e($r); ?>" <?php echo e(old('role', $user->role) === $r ? 'selected' : ''); ?>><?php echo e(ucfirst($r)); ?></option>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </select>
        <?php $__errorArgs = ['role'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="form-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <select name="status" class="form-input">
          <option value="active"   <?php echo e(old('status', $user->status) === 'active'   ? 'selected' : ''); ?>>Active</option>
          <option value="inactive" <?php echo e(old('status', $user->status) === 'inactive' ? 'selected' : ''); ?>>Inactive</option>
        </select>
      </div>
    </div>

    <div style="display:flex;gap:10px;margin-top:6px;align-items:center;">
      <button type="submit" class="btn-save">Save Changes</button>
      <a href="<?php echo e(route('admin.users.index')); ?>" class="btn-cancel">Cancel</a>
    </div>
  </form>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('admin.layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/users/edit.blade.php ENDPATH**/ ?>