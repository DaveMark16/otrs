<?php $__env->startSection('page-title', 'Booking Detail'); ?>

<?php $__env->startSection('content'); ?>
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"/>
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>

<style>
:root{--sand:#f5ede0;--cream:#faf6f0;--brown:#3b2a1a;--tan:#c49a6c;--gold:#d4a254;--teal:#2d6e6e;--teal-lt:#3d8f8f;--white:#ffffff;--radius:18px;--ff-head:'Playfair Display',Georgia,serif;--ff-body:'DM Sans',sans-serif;}

/* Back link */
.back-link{display:inline-flex;align-items:center;gap:6px;color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;font-weight:500;margin-bottom:20px;transition:color .15s;}
.back-link:hover{color:var(--teal);}
.back-link svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;}

/* Route hero bar */
.route-bar{background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:20px 28px;display:flex;align-items:center;justify-content:space-between;margin-bottom:14px;flex-wrap:wrap;gap:16px;box-shadow:0 2px 16px rgba(59,42,26,.06);}
.city-code{font-size:2rem;font-weight:900;color:var(--brown);font-family:monospace;letter-spacing:2px;line-height:1;}
.city-name{font-size:.75rem;color:rgba(59,42,26,.4);margin-top:3px;}
.city-time{font-size:1.05rem;font-weight:700;color:var(--teal);margin-top:5px;}
.city-date{font-size:.72rem;color:rgba(59,42,26,.35);}
.route-middle{flex:1;text-align:center;padding:0 20px;}
.duration-badge{display:inline-block;background:rgba(212,162,84,.12);border:1.5px solid rgba(212,162,84,.3);border-radius:20px;padding:4px 14px;font-size:.78rem;font-weight:700;color:var(--gold);}
.route-line{width:100%;height:2px;background:linear-gradient(90deg,var(--teal),rgba(196,154,108,.5),var(--gold));border-radius:2px;margin:8px 0;}
.fstats{display:flex;gap:20px;justify-content:center;flex-wrap:wrap;margin-top:8px;}
.fstat-label{font-size:.65rem;color:rgba(59,42,26,.35);text-transform:uppercase;letter-spacing:.08em;}
.fstat-val{font-size:.82rem;font-weight:700;color:var(--brown);margin-top:2px;}
.fstat-val.gold{color:var(--gold);}

/* Map */
#flight-map{width:100%;height:400px;border-radius:var(--radius);border:1.5px solid rgba(59,42,26,.08);margin-bottom:18px;overflow:hidden;position:relative;z-index:0;box-shadow:0 2px 16px rgba(59,42,26,.06);}
.leaflet-popup-content-wrapper{background:var(--white);color:var(--brown);border:1.5px solid rgba(59,42,26,.1);border-radius:10px;box-shadow:0 4px 20px rgba(59,42,26,.15);}
.leaflet-popup-tip{background:var(--white);}
.leaflet-popup-content{color:var(--brown);font-size:12px;font-family:var(--ff-body);}
.leaflet-control-zoom a{background:var(--white)!important;color:var(--brown)!important;border-color:rgba(59,42,26,.15)!important;}
.leaflet-control-attribution{background:rgba(250,246,240,.9)!important;color:rgba(59,42,26,.4)!important;}

/* Detail grid */
.detail-grid{display:grid;grid-template-columns:1.1fr 1fr;gap:18px;margin-bottom:18px;}

/* Cards */
.card{background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);overflow:hidden;box-shadow:0 2px 16px rgba(59,42,26,.06);}
.card-header{padding:18px 22px 0;border-bottom:0;margin-bottom:0;}
.card-section{padding:16px 22px;border-bottom:1px solid rgba(59,42,26,.06);}
.card-section:last-child{border-bottom:none;}
.section-eyebrow{font-size:.67rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.35);margin-bottom:10px;display:flex;align-items:center;gap:6px;}
.section-eyebrow svg{width:12px;height:12px;stroke:currentColor;fill:none;stroke-width:1.8;color:var(--teal);}

/* Booking ref header */
.card-ref-bar{display:flex;align-items:center;justify-content:space-between;padding:18px 22px;border-bottom:1.5px solid rgba(59,42,26,.07);background:var(--sand);}
.ref-label{font-size:.68rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:4px;}
.ref-val{font-family:monospace;font-size:1.5rem;font-weight:900;color:var(--teal);}

/* Status pills */
.pill{display:inline-flex;align-items:center;padding:5px 14px;border-radius:20px;font-size:.75rem;font-weight:700;}
.st-confirmed{background:rgba(45,110,110,.1);color:var(--teal);}
.st-pending{background:rgba(212,162,84,.12);color:#a07830;}
.st-cancelled{background:rgba(180,60,60,.08);color:#b44444;}
.st-ticketed{background:rgba(59,42,26,.07);color:var(--brown);}

/* Info rows */
.info-row{display:flex;justify-content:space-between;align-items:baseline;padding:7px 0;border-bottom:1px solid rgba(59,42,26,.05);font-size:.83rem;}
.info-row:last-child{border-bottom:none;}
.info-k{color:rgba(59,42,26,.38);font-size:.75rem;}
.info-v{color:var(--brown);font-weight:600;text-align:right;}
.info-v.gold{color:var(--gold);font-family:monospace;font-size:.95rem;}

/* User chip */
.user-chip{display:flex;align-items:center;gap:12px;padding:12px 0;}
.user-av{width:40px;height:40px;border-radius:50%;background:linear-gradient(135deg,var(--gold),var(--tan));display:flex;align-items:center;justify-content:center;font-family:var(--ff-head);font-size:.9rem;font-weight:700;color:var(--brown);flex-shrink:0;}
.user-name{font-weight:700;color:var(--brown);font-size:.9rem;}
.user-email{font-size:.73rem;color:rgba(59,42,26,.38);margin-top:1px;}

/* Amount box */
.amount-box{background:linear-gradient(135deg,rgba(45,110,110,.05),rgba(212,162,84,.05));border:1.5px solid rgba(212,162,84,.2);border-radius:12px;padding:16px 18px;}
.amount-main{font-family:var(--ff-head);font-size:2rem;font-weight:900;color:var(--gold);line-height:1;}
.amount-sub{font-size:.73rem;color:rgba(59,42,26,.38);margin-top:4px;}
.promo-tag{display:inline-flex;align-items:center;gap:6px;background:rgba(45,110,110,.07);border:1px solid rgba(45,110,110,.18);border-radius:6px;padding:4px 10px;font-size:.73rem;color:var(--teal);font-weight:600;margin-top:8px;}

/* Alert banners */
.alert{border-radius:12px;padding:13px 16px;display:flex;align-items:flex-start;gap:12px;margin-bottom:14px;}
.alert svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:2;flex-shrink:0;margin-top:1px;}
.alert-pending{background:rgba(212,162,84,.07);border:1.5px solid rgba(212,162,84,.22);}
.alert-pending svg,.alert-pending p{color:#9a7030;}
.alert-success{background:rgba(45,110,110,.07);border:1.5px solid rgba(45,110,110,.2);}
.alert-success svg,.alert-success p{color:var(--teal);}
.alert-title{font-weight:700;font-size:.84rem;margin:0 0 2px;}
.alert-desc{font-size:.76rem;opacity:.8;margin:0;}

/* Action buttons */
.btn{padding:10px 22px;border-radius:50px;font-size:.84rem;font-weight:600;cursor:pointer;display:inline-flex;align-items:center;gap:7px;transition:all .18s;text-decoration:none;font-family:var(--ff-body);border:none;}
.btn svg{width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round;}
.btn-pay{background:var(--teal);color:var(--white);box-shadow:0 4px 14px rgba(45,110,110,.25);}
.btn-pay:hover{background:var(--teal-lt);transform:translateY(-1px);}
.btn-edit{background:rgba(212,162,84,.12);color:#9a7030;border:1.5px solid rgba(212,162,84,.25);}
.btn-edit:hover{background:rgba(212,162,84,.2);}
.btn-cancel{background:rgba(180,68,68,.07);color:#b44444;border:1.5px solid rgba(180,68,68,.22);}
.btn-cancel:hover{background:rgba(180,68,68,.14);}
.btn-receipt{background:var(--sand);color:var(--teal);border:1.5px solid rgba(45,110,110,.2);}
.btn-receipt:hover{background:rgba(45,110,110,.08);}

/* Extra cards */
.extras{display:grid;grid-template-columns:repeat(3,1fr);gap:12px;margin-top:18px;}
.extra-card{background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:12px;padding:14px 16px;display:flex;align-items:center;gap:12px;transition:all .18s;}
.extra-card:hover{border-color:rgba(45,110,110,.2);background:rgba(45,110,110,.03);}
.extra-icon{width:36px;height:36px;background:rgba(45,110,110,.08);border-radius:9px;display:flex;align-items:center;justify-content:center;color:var(--teal);flex-shrink:0;}
.extra-icon svg{width:16px;height:16px;stroke:currentColor;fill:none;stroke-width:1.8;}
.extra-label{font-size:.72rem;color:rgba(59,42,26,.38);}
.extra-val{font-size:.82rem;font-weight:600;color:var(--brown);margin-top:1px;}

@media(max-width:900px){.detail-grid{grid-template-columns:1fr;}.extras{grid-template-columns:1fr 1fr;}}
@media(max-width:600px){.extras{grid-template-columns:1fr;}.route-middle{display:none;}}
</style>

<?php
  $schedule  = $booking->schedule;
  $trip      = $schedule->trip;
  $dep       = $schedule->departure_at;
  $arr       = $schedule->arrival_at;
  $mins      = $arr ? $dep->diffInMinutes($arr) : 0;
  $hours     = floor($mins / 60);
  $remMins   = $mins % 60;
  $durStr    = $hours > 0 ? "{$hours}h {$remMins}m" : "{$remMins}m";
  $originLabel = $trip->origin_country ?: ($trip->origin ?? 'Origin');
  $destLabel   = $trip->destination_country ?: ($trip->destination ?? 'Destination');
  $originCode  = strtoupper(substr(preg_replace('/[^a-zA-Z]/','', $originLabel), 0, 3));
  $destCode    = strtoupper(substr(preg_replace('/[^a-zA-Z]/','', $destLabel), 0, 3));
  $coords = ['Philippines'=>[12.8797,121.7740],'Indonesia'=>[-2.5489,118.0149],'Japan'=>[36.2048,138.2529],'South Korea'=>[35.9078,127.7669],'China'=>[35.8617,104.1954],'Singapore'=>[1.3521,103.8198],'Malaysia'=>[4.2105,101.9758],'Thailand'=>[15.8700,100.9925],'Vietnam'=>[14.0583,108.2772],'United Arab Emirates'=>[23.4241,53.8478],'UAE'=>[23.4241,53.8478],'Saudi Arabia'=>[23.8859,45.0792],'Qatar'=>[25.3548,51.1839],'Kuwait'=>[29.3117,47.4818],'United Kingdom'=>[55.3781,-3.4360],'UK'=>[55.3781,-3.4360],'Germany'=>[51.1657,10.4515],'France'=>[46.2276,2.2137],'Italy'=>[41.8719,12.5674],'Spain'=>[40.4637,-3.7492],'Turkey'=>[38.9637,35.2433],'United States'=>[37.0902,-95.7129],'USA'=>[37.0902,-95.7129],'Australia'=>[-25.2744,133.7751],'New Zealand'=>[-40.9006,174.8860],'Guam'=>[13.4443,144.7937],'Taiwan'=>[23.6978,120.9605],'Hong Kong'=>[22.3193,114.1694],'India'=>[20.5937,78.9629],'Cambodia'=>[12.5657,104.9910],'Myanmar'=>[19.1633,95.9560],'Oman'=>[21.4735,55.9754],'Canada'=>[56.1304,-106.3468],'Russia'=>[61.5240,105.3188]];
  $originCoords = $coords[$originLabel] ?? $coords[$trip->origin ?? ''] ?? [14.5995,120.9842];
  $destCoords   = $coords[$destLabel]   ?? $coords[$trip->destination ?? ''] ?? [10.3157,123.8854];
  $midLat = ($originCoords[0] + $destCoords[0]) / 2;
  $midLng = ($originCoords[1] + $destCoords[1]) / 2;
?>

<a href="<?php echo e(route('bookings.index')); ?>" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Back to My Bookings
</a>


<div class="route-bar">
  <div style="text-align:left;">
    <div class="city-code"><?php echo e($originCode); ?></div>
    <div class="city-name"><?php echo e($originLabel); ?><?php if($trip->origin && $trip->origin !== $originLabel): ?> · <?php echo e($trip->origin); ?><?php endif; ?></div>
    <div class="city-time"><?php echo e($dep ? $dep->format('h:i A') : '—'); ?></div>
    <div class="city-date"><?php echo e($dep ? $dep->format('M d, Y') : '—'); ?></div>
  </div>
  <div class="route-middle">
    <div class="duration-badge">⏱ <?php echo e($durStr); ?></div>
    <div class="route-line"></div>
    <div style="font-size:.72rem;color:rgba(59,42,26,.35);">Direct · <?php echo e($trip->operator ?? 'N/A'); ?></div>
    <div class="fstats">
      <div><div class="fstat-label">Hours</div><div class="fstat-val"><?php echo e($hours); ?>h</div></div>
      <div><div class="fstat-label">Minutes</div><div class="fstat-val"><?php echo e($remMins); ?>m</div></div>
      <div><div class="fstat-label">Class</div><div class="fstat-val"><?php echo e(ucfirst($schedule->fare_class ?? 'Economy')); ?></div></div>
      <div><div class="fstat-label">Pax</div><div class="fstat-val"><?php echo e($booking->passenger_count); ?></div></div>
      <div><div class="fstat-label">Fare</div><div class="fstat-val gold">₱<?php echo e(number_format($booking->total_amount, 0)); ?></div></div>
    </div>
  </div>
  <div style="text-align:right;">
    <div class="city-code"><?php echo e($destCode); ?></div>
    <div class="city-name"><?php echo e($destLabel); ?><?php if($trip->destination && $trip->destination !== $destLabel): ?> · <?php echo e($trip->destination); ?><?php endif; ?></div>
    <div class="city-time"><?php echo e($arr ? $arr->format('h:i A') : '—'); ?></div>
    <div class="city-date"><?php echo e($arr ? $arr->format('M d, Y') : '—'); ?></div>
  </div>
</div>


<div id="flight-map"></div>


<div class="detail-grid">

  
  <div class="card">
    <div class="card-ref-bar">
      <div>
        <div class="ref-label">Booking Reference</div>
        <div class="ref-val"><?php echo e($booking->reference_no); ?></div>
      </div>
      <?php $s = $booking->status; ?>
      <span class="pill st-<?php echo e($s); ?>"><?php echo e(ucfirst($s)); ?></span>
    </div>

    <div class="card-section">
      <div class="section-eyebrow"><svg viewBox="0 0 24 24"><path d="M20 21v-2a4 4 0 0 0-4-4H8a4 4 0 0 0-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>Passenger</div>
      <div class="user-chip">
        <div class="user-av"><?php echo e(strtoupper(substr($booking->user->name ?? 'U', 0, 2))); ?></div>
        <div>
          <div class="user-name"><?php echo e($booking->user->name ?? '—'); ?></div>
          <div class="user-email"><?php echo e($booking->user->email ?? '—'); ?></div>
        </div>
      </div>
    </div>

    <div class="card-section">
      <div class="section-eyebrow"><svg viewBox="0 0 24 24"><path d="M17.8 19.2L16 11l3.5-3.5C21 6 21 4 19 4c-1 0-1.5.5-3.5 2.5L11 8.2 2.8 6.4 2 7.2l3 5.5-2 1.7v2.2l3-1.5 1.5 3h2.2l1.7-2 5.5 3z"/></svg>Flight Details</div>
      <div class="info-row"><span class="info-k">Route</span><span class="info-v"><?php echo e($originLabel); ?> → <?php echo e($destLabel); ?></span></div>
      <div class="info-row"><span class="info-k">Departure</span><span class="info-v"><?php echo e($dep?->format('M d, Y · h:i A') ?? '—'); ?></span></div>
      <div class="info-row"><span class="info-k">Arrival</span><span class="info-v"><?php echo e($arr?->format('M d, Y · h:i A') ?? '—'); ?></span></div>
      <div class="info-row"><span class="info-k">Duration</span><span class="info-v"><?php echo e($durStr); ?></span></div>
      <div class="info-row"><span class="info-k">Airline</span><span class="info-v"><?php echo e($trip->operator ?? '—'); ?></span></div>
      <div class="info-row"><span class="info-k">Class</span><span class="info-v"><?php echo e(ucfirst($schedule->fare_class ?? 'Economy')); ?></span></div>
      <div class="info-row"><span class="info-k">Passengers</span><span class="info-v"><?php echo e($booking->passenger_count); ?> adult(s)</span></div>
      <div class="info-row"><span class="info-k">Booked</span><span class="info-v"><?php echo e($booking->created_at->format('M d, Y')); ?></span></div>
    </div>
  </div>

  
  <div>
    <div class="card" style="margin-bottom:14px;">
      <div class="card-section">
        <div class="section-eyebrow"><svg viewBox="0 0 24 24"><line x1="12" y1="1" x2="12" y2="23"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>Total Amount</div>
        <div class="amount-box">
          <?php if($booking->has_promo ?? false): ?>
            <div style="font-size:.76rem;color:rgba(59,42,26,.35);text-decoration:line-through;margin-bottom:2px;">₱<?php echo e(number_format($booking->original_amount ?? 0, 2)); ?></div>
          <?php endif; ?>
          <div class="amount-main">₱<?php echo e(number_format($booking->total_amount, 2)); ?></div>
          <div class="amount-sub">inclusive of taxes &amp; fees</div>
          <?php if($booking->has_promo ?? false): ?>
            <div class="promo-tag">🏷 <?php echo e($booking->promo->promo_code ?? ''); ?> — saved ₱<?php echo e(number_format($booking->discount_amount ?? 0, 2)); ?></div>
          <?php endif; ?>
        </div>
      </div>

      <?php if($booking->payment): ?>
      <div class="card-section">
        <div class="section-eyebrow"><svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>Payment</div>
        <div class="info-row"><span class="info-k">Method</span><span class="info-v"><?php echo e(ucfirst($booking->payment->method ?? '—')); ?></span></div>
        <div class="info-row"><span class="info-k">Status</span><span class="info-v"><?php echo e(ucfirst($booking->payment->status ?? '—')); ?></span></div>
        <div class="info-row"><span class="info-k">Ref</span><span class="info-v" style="font-size:.72rem;font-family:monospace;"><?php echo e($booking->payment->transaction_ref ?? '—'); ?></span></div>
      </div>
      <?php endif; ?>

      <div class="card-section">
        <?php if($s === 'ticketed' && $booking->payment): ?>
          <div class="alert alert-success">
            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
            <div>
              <p class="alert-title">Payment Successful — Ticket Issued</p>
              <p class="alert-desc">Your booking is confirmed and tickets are ready.</p>
            </div>
          </div>
          <a href="<?php echo e(route('bookings.receipt', $booking->id)); ?>" class="btn btn-receipt">
            <svg viewBox="0 0 24 24"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
            View Receipt &amp; Tickets
          </a>

        <?php elseif($s === 'confirmed' && !$booking->payment): ?>
          <div class="alert alert-success">
            <svg viewBox="0 0 24 24"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22,4 12,14.01 9,11.01"/></svg>
            <div>
              <p class="alert-title">Booking Approved</p>
              <p class="alert-desc">Complete payment to secure your seat.</p>
            </div>
          </div>
          <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <form method="POST" action="<?php echo e(route('bookings.pay', $booking->id)); ?>" style="display:inline"
                  onsubmit="return confirm('Pay ₱<?php echo e(number_format($booking->total_amount,2)); ?>?')">
              <?php echo csrf_field(); ?>
              <button type="submit" class="btn btn-pay">
                <svg viewBox="0 0 24 24"><rect x="1" y="4" width="22" height="16" rx="2"/><line x1="1" y1="10" x2="23" y2="10"/></svg>
                Pay Now
              </button>
            </form>
            <form method="POST" action="<?php echo e(route('bookings.destroy', $booking->id)); ?>" style="display:inline"
                  onsubmit="return confirm('Cancel this booking?')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="btn btn-cancel">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Cancel
              </button>
            </form>
          </div>

        <?php elseif($s === 'pending'): ?>
          <div class="alert alert-pending">
            <svg viewBox="0 0 24 24"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
            <div>
              <p class="alert-title">Waiting for Admin Approval</p>
              <p class="alert-desc">Pay Now will appear once your booking is confirmed.</p>
            </div>
          </div>
          <div style="display:flex;gap:10px;flex-wrap:wrap;">
            <a href="<?php echo e(route('bookings.edit', $booking->id)); ?>" class="btn btn-edit">
              <svg viewBox="0 0 24 24"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4L18.5 2.5z"/></svg>
              Edit
            </a>
            <form method="POST" action="<?php echo e(route('bookings.destroy', $booking->id)); ?>" style="display:inline"
                  onsubmit="return confirm('Cancel this booking?')">
              <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
              <button type="submit" class="btn btn-cancel">
                <svg viewBox="0 0 24 24"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
                Cancel
              </button>
            </form>
          </div>
        <?php endif; ?>
      </div>
    </div>
  </div>
</div>


<div class="extras">
  <div class="extra-card">
    <div class="extra-icon"><svg viewBox="0 0 24 24"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg></div>
    <div><div class="extra-label">Secure Payment</div><div class="extra-val">SSL Encrypted</div></div>
  </div>
  <div class="extra-card">
    <div class="extra-icon"><svg viewBox="0 0 24 24"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07A19.5 19.5 0 0 1 4.36 13a19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 3.11 2h3a2 2 0 0 1 2 1.72c.127.96.361 1.903.7 2.81a2 2 0 0 1-.45 2.11L7.91 9.91a16 16 0 0 0 6.18 6.18l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg></div>
    <div><div class="extra-label">24/7 Support</div><div class="extra-val">Always available</div></div>
  </div>
  <div class="extra-card">
    <div class="extra-icon" style="color:var(--gold);background:rgba(212,162,84,.1);"><svg viewBox="0 0 24 24"><path d="M9 14.25l6-6m4.5-3.493V21.75l-3.75-1.5-3.75 1.5-3.75-1.5-3.75 1.5V4.757c0-1.108.806-2.057 1.907-2.185a48.507 48.507 0 0111.186 0c1.1.128 1.907 1.077 1.907 2.185z"/></svg></div>
    <div><div class="extra-label">Refund Policy</div><div class="extra-val">Free cancellation 24h</div></div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
  var oLat=<?php echo e($originCoords[0]); ?>,oLng=<?php echo e($originCoords[1]); ?>,dLat=<?php echo e($destCoords[0]); ?>,dLng=<?php echo e($destCoords[1]); ?>;
  var midLat=<?php echo e($midLat); ?>,midLng=<?php echo e($midLng); ?>;
  var originCity=<?php echo json_encode($originLabel, 15, 512) ?>,destCity=<?php echo json_encode($destLabel, 15, 512) ?>;
  var operator=<?php echo json_encode($trip->operator ?? 'N/A', 15, 512) ?>,durStr=<?php echo json_encode($durStr, 15, 512) ?>;
  var depTime=<?php echo json_encode($dep ? $dep->format('M d, Y h:i A') : '—', 512) ?>;
  var arrTime=<?php echo json_encode($arr ? $arr->format('M d, Y h:i A') : '—', 512) ?>;

  var map=L.map('flight-map',{center:[midLat,midLng],zoom:4,zoomControl:true});
  L.tileLayer('https://{s}.basemaps.cartocdn.com/light_all/{z}/{x}/{y}{r}.png',{attribution:'© OpenStreetMap © CARTO',subdomains:'abcd',maxZoom:19}).addTo(map);

  var oIcon=L.divIcon({className:'',html:'<div style="width:14px;height:14px;background:var(--teal);border:2.5px solid #fff;border-radius:50%;box-shadow:0 0 12px rgba(45,110,110,.6);"></div>',iconSize:[14,14],iconAnchor:[7,7]});
  var dIcon=L.divIcon({className:'',html:'<div style="width:14px;height:14px;background:var(--gold);border:2.5px solid #fff;border-radius:50%;box-shadow:0 0 12px rgba(212,162,84,.6);"></div>',iconSize:[14,14],iconAnchor:[7,7]});
  var planeIcon=L.divIcon({className:'',html:'<div style="font-size:20px;filter:drop-shadow(0 0 4px rgba(45,110,110,.8));transform:rotate(45deg);">✈</div>',iconSize:[24,24],iconAnchor:[12,12]});

  var oM=L.marker([oLat,oLng],{icon:oIcon}).addTo(map);
  var dM=L.marker([dLat,dLng],{icon:dIcon}).addTo(map);
  oM.bindPopup('<div style="text-align:center;padding:4px 8px;font-family:DM Sans,sans-serif"><div style="font-size:14px;font-weight:800;color:#2d6e6e">'+originCity+'</div><div style="font-size:11px;color:#888;margin-top:2px">Departure</div><div style="font-size:12px;color:#3b2a1a;margin-top:4px">'+depTime+'</div></div>');
  dM.bindPopup('<div style="text-align:center;padding:4px 8px;font-family:DM Sans,sans-serif"><div style="font-size:14px;font-weight:800;color:#d4a254">'+destCity+'</div><div style="font-size:11px;color:#888;margin-top:2px">Arrival</div><div style="font-size:12px;color:#3b2a1a;margin-top:4px">'+arrTime+'</div></div>');

  function arc(lat1,lng1,lat2,lng2,n){var pts=[];for(var i=0;i<=n;i++){var t=i/n,lat=lat1+(lat2-lat1)*t,lng=lng1+(lng2-lng1)*t,c=Math.sin(Math.PI*t)*(Math.abs(lat2-lat1)*0.3+2);pts.push([lat+c,lng]);}return pts;}
  var pts=arc(oLat,oLng,dLat,dLng,60);
  L.polyline(pts,{color:'#2d6e6e',weight:2,opacity:.25,dashArray:'8,8'}).addTo(map);
  L.polyline(pts,{color:'#2d6e6e',weight:1.5,opacity:.7}).addTo(map);

  var pM=L.marker(pts[0],{icon:planeIcon}).addTo(map);
  pM.bindPopup('<div style="text-align:center;font-family:DM Sans,sans-serif"><div style="font-weight:700;color:#2d6e6e">✈ In Flight</div><div style="font-size:11px;color:#888;margin-top:3px">'+originCity+' → '+destCity+'</div></div>');

  var step=0,total=pts.length,fwd=true;
  setInterval(function(){
    fwd?step++:step--;
    if(step>=total-1)fwd=false;
    if(step<=0)fwd=true;
    pM.setLatLng(pts[step]);
    if(step<total-1){var p1=pts[step],p2=pts[step+1],a=Math.atan2(p2[1]-p1[1],p2[0]-p1[0])*180/Math.PI;var el=pM.getElement();if(el){var d=el.querySelector('div');if(d)d.style.transform='rotate('+(a+45)+'deg)';}}
  },80);

  map.fitBounds([[oLat,oLng],[dLat,dLng]],{padding:[60,60]});
  setTimeout(function(){oM.openPopup();},800);
});
</script>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\AMVI User\OneDrive - Agata Mining Ventures\Desktop\laravel\otrs\resources\views/bookings/show.blade.php ENDPATH**/ ?>