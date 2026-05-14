
<style>
  .form-card { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:22px 26px;margin-bottom:16px;box-shadow:0 2px 12px rgba(59,42,26,.05); }
  .form-card-title { font-family:var(--ff-head);font-size:.95rem;font-weight:700;color:var(--brown);margin-bottom:18px;padding-bottom:12px;border-bottom:1.5px solid rgba(59,42,26,.07);display:flex;align-items:center;gap:8px; }
  .form-card-title svg { width:14px;height:14px;stroke:var(--teal);fill:none;stroke-width:1.8;stroke-linecap:round;stroke-linejoin:round;flex-shrink:0; }
  .form-group { margin-bottom:16px; }
  .form-row { display:grid;grid-template-columns:1fr 1fr;gap:16px; }
  .f-label { display:block;font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:7px; }
  .f-label .req { color:#b44444;margin-left:2px; }
  .f-input { width:100%;background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:var(--radius-sm);padding:10px 14px;font-size:.88rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s; }
  .f-input:focus { border-color:var(--teal);background:var(--white); }
  .f-input::placeholder { color:rgba(59,42,26,.25); }
  textarea.f-input { resize:vertical;min-height:80px; }
  .f-error { font-size:.74rem;color:#b44444;margin-top:5px; }
  .f-hint  { font-size:.72rem;color:rgba(59,42,26,.35);margin-top:5px; }

  /* Prefix input */
  .prefix-wrap { display:flex;align-items:stretch; }
  .prefix-tag { background:var(--sand);border:1.5px solid rgba(59,42,26,.12);border-right:none;border-radius:var(--radius-sm) 0 0 var(--radius-sm);padding:10px 14px;font-size:.88rem;color:rgba(59,42,26,.45);font-family:var(--ff-body);white-space:nowrap;display:flex;align-items:center; }
  .prefix-wrap .f-input { border-radius:0 var(--radius-sm) var(--radius-sm) 0; }

  /* Code generate */
  .code-gen-wrap { display:flex;gap:8px;align-items:flex-start; }
  .code-gen-wrap .f-input { flex:1; }
  .btn-gen { background:var(--sand);border:1.5px solid rgba(59,42,26,.12);border-radius:50px;padding:10px 16px;font-size:.78rem;font-weight:600;color:rgba(59,42,26,.5);cursor:pointer;white-space:nowrap;transition:all .15s;font-family:var(--ff-body);display:inline-flex;align-items:center;gap:5px; }
  .btn-gen:hover { color:var(--teal);border-color:rgba(45,110,110,.3); }
  .btn-gen svg { width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }

  /* Toggle */
  .toggle-wrap { display:flex;align-items:center;gap:10px;margin-bottom:14px; }
  .toggle { position:relative;display:inline-block;width:38px;height:22px; }
  .toggle input { opacity:0;width:0;height:0; }
  .slider { position:absolute;cursor:pointer;top:0;left:0;right:0;bottom:0;background:rgba(59,42,26,.12);border-radius:22px;transition:.2s; }
  .slider:before { position:absolute;content:"";height:16px;width:16px;left:3px;bottom:3px;background:rgba(59,42,26,.3);border-radius:50%;transition:.2s; }
  .toggle input:checked + .slider { background:rgba(45,110,110,.25); }
  .toggle input:checked + .slider:before { transform:translateX(16px);background:var(--teal); }
  .toggle-text { font-size:.85rem;color:rgba(59,42,26,.6); }
  .toggle-text strong { color:var(--brown); }

  /* Trip grid */
  .trip-grid { display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:8px;margin-top:8px;max-height:260px;overflow-y:auto;padding-right:4px; }
  .trip-check { display:flex;align-items:center;gap:10px;background:var(--cream);border:1.5px solid rgba(59,42,26,.09);border-radius:var(--radius-sm);padding:9px 12px;cursor:pointer;transition:all .15s; }
  .trip-check:hover { border-color:var(--teal);background:rgba(45,110,110,.04); }
  .trip-check input[type=checkbox] { accent-color:var(--teal);width:14px;height:14px;flex-shrink:0;cursor:pointer; }
  .trip-check-label { font-size:.78rem;color:rgba(59,42,26,.55);cursor:pointer;line-height:1.4; }
  .trip-name { font-weight:600;color:var(--brown); }
  .trip-route { font-size:.7rem;color:rgba(59,42,26,.38); }

  /* Buttons */
  .btn-save { background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:10px 28px;font-size:.88rem;font-weight:600;cursor:pointer;font-family:var(--ff-body);transition:background .18s,transform .15s;box-shadow:0 4px 14px rgba(45,110,110,.25); }
  .btn-save:hover { background:var(--teal-lt);transform:translateY(-1px); }
  .btn-cancel { background:transparent;color:rgba(59,42,26,.45);border:1.5px solid rgba(59,42,26,.14);border-radius:50px;padding:10px 22px;font-size:.88rem;font-weight:500;cursor:pointer;text-decoration:none;font-family:var(--ff-body);transition:all .15s;display:inline-flex;align-items:center; }
  .btn-cancel:hover { color:var(--brown);border-color:rgba(59,42,26,.3); }

  @media(max-width:640px){ .form-row { grid-template-columns:1fr; } }
</style>

<form method="POST" action="<?php echo e($action); ?>">
  <?php echo csrf_field(); ?>
  <?php if($method === 'PUT'): ?> <?php echo method_field('PUT'); ?> <?php endif; ?>

  
  <div class="form-card">
    <div class="form-card-title">
      <svg viewBox="0 0 24 24"><path d="M9.568 3H5.25A2.25 2.25 0 003 5.25v4.318c0 .597.237 1.17.659 1.591l9.581 9.581c.699.699 1.78.872 2.607.33a18.095 18.095 0 005.223-5.223c.542-.827.369-1.908-.33-2.607L11.16 3.66A2.25 2.25 0 009.568 3z"/></svg>
      Promo Details
    </div>
    <div class="form-group">
      <label class="f-label">Title <span class="req">*</span></label>
      <input type="text" name="title" class="f-input"
             value="<?php echo e(old('title', $promo->title ?? '')); ?>"
             placeholder="e.g. Summer Flash Sale" required>
      <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="f-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="form-group">
      <label class="f-label">Description</label>
      <textarea name="description" class="f-input"
                placeholder="Optional note about this promo…"><?php echo e(old('description', $promo->description ?? '')); ?></textarea>
      <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="f-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
    <div class="form-group">
      <label class="f-label">Promo Code</label>
      <div class="code-gen-wrap">
        <input type="text" name="promo_code" id="promo_code" class="f-input"
               value="<?php echo e(old('promo_code', $promo->promo_code ?? '')); ?>"
               placeholder="Leave empty to auto-generate"
               style="text-transform:uppercase;letter-spacing:.05em;">
        <button type="button" class="btn-gen" onclick="generateCode()">
          <svg viewBox="0 0 24 24"><polyline points="1,4 1,10 7,10"/><path d="M3.51 15a9 9 0 1 0 .49-3.51"/></svg>
          Generate
        </button>
      </div>
      <div class="f-hint">Only letters, numbers and hyphens. Auto-generated if left blank.</div>
      <?php $__errorArgs = ['promo_code'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="f-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
  </div>

  
  <div class="form-card">
    <div class="form-card-title">
      <svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg>
      Discount
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="f-label">Type <span class="req">*</span></label>
        <select name="discount_type" id="discount_type" class="f-input" onchange="updateDiscountUI()">
          <option value="percentage" <?php echo e(old('discount_type', $promo->discount_type ?? 'percentage')==='percentage'?'selected':''); ?>>Percentage (%)</option>
          <option value="fixed"      <?php echo e(old('discount_type', $promo->discount_type ?? '')==='fixed'?'selected':''); ?>>Fixed Amount (₱)</option>
        </select>
        <?php $__errorArgs = ['discount_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="f-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label class="f-label">Value <span class="req">*</span></label>
        <div class="prefix-wrap">
          <span class="prefix-tag" id="discount_prefix">%</span>
          <input type="number" name="discount_value" id="discount_value" class="f-input"
                 step="0.01" min="0.01"
                 value="<?php echo e(old('discount_value', $promo->discount_value ?? '')); ?>"
                 placeholder="e.g. 20" required>
        </div>
        <?php $__errorArgs = ['discount_value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="f-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>
  </div>

  
  <div class="form-card">
    <div class="form-card-title">
      <svg viewBox="0 0 24 24"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      Validity Period
    </div>
    <div class="form-row">
      <div class="form-group">
        <label class="f-label">Start Date <span class="req">*</span></label>
        <input type="date" name="start_date" class="f-input"
               value="<?php echo e(old('start_date', isset($promo) ? $promo->start_date->format('Y-m-d') : '')); ?>" required>
        <?php $__errorArgs = ['start_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="f-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
      <div class="form-group">
        <label class="f-label">End Date <span class="req">*</span></label>
        <input type="date" name="end_date" class="f-input"
               value="<?php echo e(old('end_date', isset($promo) ? $promo->end_date->format('Y-m-d') : '')); ?>" required>
        <?php $__errorArgs = ['end_date'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="f-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
      </div>
    </div>
    <div class="f-hint">Status (Active / Upcoming / Expired) is calculated automatically from these dates.</div>
  </div>

  
  <div class="form-card">
    <div class="form-card-title">
      <svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>
      Applicable Trips
    </div>
    <div class="toggle-wrap">
      <label class="toggle">
        <input type="checkbox" id="applies_to_all" name="applies_to_all" value="1"
               <?php echo e(old('applies_to_all', ($promo->applies_to_all ?? true) ? '1' : '') == '1' ? 'checked' : ''); ?>

               onchange="toggleTripSelector()">
        <span class="slider"></span>
      </label>
      <span class="toggle-text">Apply to <strong>all trips</strong></span>
    </div>
    <div id="trip-selector" style="<?php echo e(old('applies_to_all', ($promo->applies_to_all ?? true) ? '1' : '') == '1' ? 'display:none' : ''); ?>">
      <label class="f-label" style="margin-bottom:8px;">Select Trips</label>
      <?php $selectedIds = old('trip_ids', isset($promo) ? $promo->trips->pluck('id')->toArray() : []); ?>
      <?php if($trips->count()): ?>
        <div class="trip-grid">
          <?php $__currentLoopData = $trips; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trip): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
          <label class="trip-check">
            <input type="checkbox" name="trip_ids[]" value="<?php echo e($trip->id); ?>"
                   <?php echo e(in_array($trip->id, (array)$selectedIds) ? 'checked' : ''); ?>>
            <span class="trip-check-label">
              <span class="trip-name"><?php echo e($trip->name); ?></span><br>
              <span class="trip-route"><?php echo e($trip->origin); ?> → <?php echo e($trip->destination); ?></span>
            </span>
          </label>
          <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
      <?php else: ?>
        <p style="font-size:.83rem;color:rgba(59,42,26,.3);">No active trips available.</p>
      <?php endif; ?>
      <?php $__errorArgs = ['trip_ids'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?><div class="f-error"><?php echo e($message); ?></div><?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
    </div>
  </div>

  <div style="display:flex;gap:10px;align-items:center;">
    <button type="submit" class="btn-save"><?php echo e($method === 'PUT' ? 'Save Changes' : 'Create Promo'); ?></button>
    <a href="<?php echo e(route('admin.promos.index')); ?>" class="btn-cancel">Cancel</a>
  </div>
</form>

<script>
function updateDiscountUI() {
    const type = document.getElementById('discount_type').value;
    document.getElementById('discount_prefix').textContent = type === 'percentage' ? '%' : '₱';
    const inp = document.getElementById('discount_value');
    inp.max = type === 'percentage' ? '100' : '';
}
function toggleTripSelector() {
    const all = document.getElementById('applies_to_all').checked;
    document.getElementById('trip-selector').style.display = all ? 'none' : '';
}
function generateCode() {
    const chars = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    const rand = n => Array.from({length:n}, () => chars[Math.floor(Math.random()*chars.length)]).join('');
    document.getElementById('promo_code').value = rand(4) + '-' + rand(4);
}
updateDiscountUI();
</script><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/admin/promos/form.blade.php ENDPATH**/ ?>