
<?php $__env->startSection('title', 'Edit Booking'); ?>
<?php $__env->startSection('page-title', 'Edit Booking'); ?>

<?php $__env->startSection('content'); ?>
<style>
    .breadcrumb{font-size:12px;color:#555;margin-bottom:20px}
    .breadcrumb a{color:#888;text-decoration:none}.breadcrumb a:hover{color:#FF6044}
    .breadcrumb span{color:#FF6044}
    .panel{background:#1a1b1b;border:0.5px solid #2a2b2b;border-radius:10px;padding:20px;margin-bottom:14px}
    .p-head{display:flex;align-items:center;gap:12px;margin-bottom:18px;padding-bottom:14px;border-bottom:0.5px solid #2a2b2b}
    .p-icon{width:36px;height:36px;background:#ef9f27;border-radius:8px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
    .p-icon svg{width:18px;height:18px}
    .p-title{font-size:14px;font-weight:600;color:#fff}
    .p-sub{font-size:11px;color:#555;margin-top:2px}
    .ref-tag{font-size:12px;color:#FF6044;font-family:monospace;background:rgba(255,96,68,.1);padding:4px 10px;border-radius:6px;display:inline-block;margin-bottom:14px}
    .f-group{margin-bottom:14px}
    .f-row{display:grid;grid-template-columns:1fr 1fr;gap:12px}
    .f-label{font-size:11px;color:#aaa;margin-bottom:6px;display:block;text-transform:uppercase;letter-spacing:0.5px}
    .req{color:#FF6044}
    .f-input{width:100%;background:#0e0f0f;border:0.5px solid #333;border-radius:8px;padding:10px 14px;font-size:13px;color:#fff;outline:none;font-family:sans-serif}
    .f-input:focus{border-color:#FF6044}
    .f-readonly{background:#0a0b0b;color:#555;cursor:not-allowed}
    .info-box{background:rgba(55,138,221,.08);border:0.5px solid rgba(55,138,221,.3);border-radius:8px;padding:12px 14px;font-size:12px;color:#378add;margin-bottom:14px}
    .s-box{background:#0e0f0f;border:0.5px solid #2a2b2b;border-radius:8px;padding:16px}
    .s-head{font-size:10px;color:#555;letter-spacing:1px;text-transform:uppercase;margin-bottom:12px}
    .s-row{display:flex;justify-content:space-between;padding:6px 0;border-bottom:0.5px solid #1a1b1b;font-size:12px}
    .s-row:last-child{border-bottom:none}
    .s-k{color:#555}.s-v{color:#ccc;font-weight:500}
    .s-total{display:flex;justify-content:space-between;align-items:center;padding-top:12px;margin-top:6px;border-top:0.5px solid #2a2b2b}
    .s-tl{font-size:13px;color:#ccc;font-weight:500}
    .s-tv{font-size:24px;font-weight:700;color:#FF6044}
    .btn-row{display:flex;gap:10px;justify-content:flex-end;margin-top:20px}
    .btn-cancel{background:transparent;color:#888;border:0.5px solid #2a2b2b;border-radius:8px;padding:10px 20px;font-size:13px;cursor:pointer;text-decoration:none;display:inline-block}
    .btn-cancel:hover{border-color:#555;color:#ccc}
    .btn-save{background:#ef9f27;color:#fff;border:none;border-radius:8px;padding:11px 26px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:8px}
    .btn-save:hover{background:#d98e1c}
    .alert-error{background:rgba(224,85,85,0.1);border:0.5px solid rgba(224,85,85,0.4);border-radius:8px;padding:10px 14px;font-size:12px;color:#e05555;margin-bottom:14px}
    .grid2{display:grid;grid-template-columns:minmax(0,1.6fr) minmax(0,1fr);gap:16px}
</style>

<div class="breadcrumb">
    <a href="<?php echo e(route('bookings.index')); ?>">My Bookings</a> →
    <a href="<?php echo e(route('bookings.show', $booking->id)); ?>"><?php echo e($booking->reference_no); ?></a> →
    <span>Edit</span>
</div>

<div class="ref-tag"><?php echo e($booking->reference_no); ?></div>

<div class="info-box">
    ℹ You can only update the number of passengers and contact email. Trip schedule cannot be changed after booking.
</div>

<?php if($errors->isNotEmpty()): ?>
    <div class="alert-error"><?php echo e($errors->first()); ?></div>
<?php endif; ?>

<form method="POST" action="<?php echo e(route('bookings.update', $booking->id)); ?>" id="booking-edit-form">
<?php echo csrf_field(); ?>
<?php echo method_field('PUT'); ?>
<input type="hidden" name="status" value="<?php echo e($booking->status); ?>" />
<div class="grid2">
    <div>
        <div class="panel">
            <div class="p-head">
                <div class="p-icon">
                    <svg viewBox="0 0 24 24" fill="none"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7" stroke="#fff" stroke-width="1.8"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z" stroke="#fff" stroke-width="1.8"/></svg>
                </div>
                <div>
                    <div class="p-title">Update Booking</div>
                    <div class="p-sub">Modify passenger count or contact email</div>
                </div>
            </div>

            <div class="f-group">
                <label class="f-label">Trip Schedule (cannot be changed)</label>
                <input type="text" class="f-input f-readonly" readonly
                    value="<?php echo e($booking->schedule->trip->name); ?> · <?php echo e($booking->schedule->departure_at->format('M d, Y h:i A')); ?>" />
            </div>

            <div class="f-row">
                <div class="f-group">
                    <label class="f-label">Number of Passengers <span class="req">*</span></label>
                    <input type="number" class="f-input" name="passenger_count" id="pax-input"
                        value="<?php echo e(old('passenger_count', $booking->passenger_count)); ?>"
                        min="1" max="<?php echo e($booking->schedule->available_seats); ?>"
                        oninput="updateTotal()" required />
                    <div id="pax-error" style="display:none;margin-top:6px;font-size:12px;color:#e24b4a;background:rgba(226,75,74,.08);border:0.5px solid rgba(226,75,74,.3);border-radius:6px;padding:7px 11px;">
                        &#10006; Only <strong><?php echo e($booking->schedule->available_seats); ?></strong> seat(s) available. You cannot book more than that.
                    </div>
                </div>
                <div class="f-group">
                    <label class="f-label">Contact Email <span class="req">*</span></label>
                    <input type="email" class="f-input" name="contact_email"
                           value="<?php echo e(old('contact_email', $booking->contact_email)); ?>" required />
                </div>
            </div>
        </div>
    </div>

    <div>
        <div class="panel">
            <div class="s-box">
                <div class="s-head">Updated Summary</div>
                <div class="s-row"><span class="s-k">Trip</span><span class="s-v"><?php echo e($booking->schedule->trip->name); ?></span></div>
                <div class="s-row"><span class="s-k">Route</span><span class="s-v"><?php echo e($booking->schedule->trip->origin); ?> → <?php echo e($booking->schedule->trip->destination); ?></span></div>
                <div class="s-row"><span class="s-k">Departure</span><span class="s-v"><?php echo e($booking->schedule->departure_at->format('M d, Y h:i A')); ?></span></div>
                <div class="s-row"><span class="s-k">Fare Class</span><span class="s-v"><?php echo e(ucfirst($booking->schedule->fare_class)); ?></span></div>
                <div class="s-row">
                    <span class="s-k">Available Seats</span>
                    <span class="s-v" style="color:<?php echo e($booking->schedule->available_seats <= 5 ? '#e24b4a' : ($booking->schedule->available_seats <= 20 ? '#ef9f27' : '#4caf81')); ?>">
                        <?php echo e($booking->schedule->available_seats); ?>

                        <?php if($booking->schedule->available_seats <= 5): ?>
                            &nbsp;⚠ Almost full
                        <?php elseif($booking->schedule->available_seats <= 20): ?>
                            &nbsp;· Limited
                        <?php endif; ?>
                    </span>
                </div>
                <div class="s-row"><span class="s-k">Base Fare / pax</span><span class="s-v">₱<?php echo e(number_format($booking->schedule->base_fare, 2)); ?></span></div>
                <div class="s-row"><span class="s-k">Passengers</span><span class="s-v" id="disp-pax"><?php echo e($booking->passenger_count); ?></span></div>
                <div class="s-total">
                    <span class="s-tl">New Total</span>
                    <span class="s-tv" id="disp-total">₱<?php echo e(number_format($booking->schedule->base_fare * $booking->passenger_count, 2)); ?></span>
                </div>
            </div>
        </div>

        <div class="btn-row">
            <a href="<?php echo e(route('bookings.show', $booking->id)); ?>" class="btn-cancel">Cancel</a>
            <button type="submit" class="btn-save" id="save-btn">
                <svg viewBox="0 0 24 24" fill="none" width="15" height="15"><path d="M19 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h11l5 5v11a2 2 0 0 1-2 2z" stroke="#fff" stroke-width="2"/><polyline points="17 21 17 13 7 13 7 21" stroke="#fff" stroke-width="2"/><polyline points="7 3 7 8 15 8" stroke="#fff" stroke-width="2"/></svg>
                Save Changes
            </button>
        </div>
    </div>
</div>
</form>

<script>
var baseFare = <?php echo e($booking->schedule->base_fare); ?>;
var maxSeats = <?php echo e($booking->schedule->available_seats); ?>;

function updateTotal() {
    var paxInput = document.getElementById('pax-input');
    var errorBox = document.getElementById('pax-error');
    var saveBtn  = document.getElementById('save-btn');
    var pax      = parseInt(paxInput.value) || 1;

    if (pax > maxSeats) {
        errorBox.style.display = 'block';
        paxInput.style.borderColor = '#e24b4a';
        saveBtn.disabled = true;
        saveBtn.style.opacity = '0.4';
        saveBtn.style.cursor = 'not-allowed';
    } else {
        errorBox.style.display = 'none';
        paxInput.style.borderColor = '';
        saveBtn.disabled = false;
        saveBtn.style.opacity = '1';
        saveBtn.style.cursor = 'pointer';
    }

    var total = baseFare * pax;
    document.getElementById('disp-pax').textContent = pax;
    document.getElementById('disp-total').textContent = '₱' + total.toLocaleString('en-PH', {minimumFractionDigits:2});
}

document.getElementById('booking-edit-form').addEventListener('submit', function(e) {
    var pax = parseInt(document.getElementById('pax-input').value) || 1;
    if (pax > maxSeats) {
        e.preventDefault();
        document.getElementById('pax-error').style.display = 'block';
        document.getElementById('pax-input').style.borderColor = '#e24b4a';
    }
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.user', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/bookings/edit.blade.php ENDPATH**/ ?>