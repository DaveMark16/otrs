<style>
  .back-link { display:inline-flex;align-items:center;gap:6px;color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;font-weight:500;margin-bottom:22px;transition:color .15s; }
  .back-link:hover { color:var(--teal); }
  .back-link svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }

  .form-card { background:var(--white);border:1.5px solid rgba(59,42,26,.08);border-radius:var(--radius);padding:28px 30px;max-width:680px;box-shadow:0 4px 24px rgba(59,42,26,.07); }
  .form-card-title { font-family:var(--ff-head);font-size:1.25rem;font-weight:700;color:var(--brown);margin-bottom:20px;padding-bottom:16px;border-bottom:1.5px solid rgba(59,42,26,.07); }

  /* Route preview */
  .route-preview { background:var(--sand);border:1.5px solid rgba(59,42,26,.09);border-radius:var(--radius-sm);padding:13px 18px;margin-bottom:22px;display:flex;align-items:center;justify-content:center;gap:12px;font-family:var(--ff-head);font-size:1.05rem;font-weight:700;min-height:50px; }
  .preview-origin { color:var(--brown); }
  .preview-arrow  { color:rgba(59,42,26,.25);font-size:1.1rem; }
  .preview-dest   { color:var(--teal); }

  .form-group { margin-bottom:18px; }
  .form-label { display:block;font-size:.7rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;color:rgba(59,42,26,.38);margin-bottom:7px; }
  .form-label .req { color:#b44444;margin-left:2px; }
  .form-label .opt { color:rgba(59,42,26,.28);font-weight:400;text-transform:none;letter-spacing:0;font-size:.7rem; }
  .form-input { width:100%;background:var(--cream);border:1.5px solid rgba(59,42,26,.12);border-radius:var(--radius-sm);padding:10px 14px;font-size:.88rem;font-family:var(--ff-body);color:var(--brown);outline:none;transition:border-color .2s;appearance:none;-webkit-appearance:none; }
  .form-input:focus { border-color:var(--teal);background:var(--white); }
  .form-input.error { border-color:#b44444; }
  .form-error { font-size:.74rem;color:#b44444;margin-top:5px; }
  .form-row { display:grid;grid-template-columns:1fr 1fr;gap:16px; }

  /* Select wrapper for chevron */
  .sel-wrap { position:relative; }
  .sel-wrap select { padding-right:34px; }
  .sel-wrap::after { content:'';position:absolute;right:13px;top:50%;transform:translateY(-50%);width:0;height:0;border-left:4px solid transparent;border-right:4px solid transparent;border-top:5px solid rgba(59,42,26,.35);pointer-events:none; }

  .errors-banner { background:rgba(180,68,68,.06);border:1.5px solid rgba(180,68,68,.2);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:18px;font-size:.84rem;color:#b44444; }

  .btn-save { background:var(--teal);color:var(--white);border:none;border-radius:50px;padding:10px 28px;font-size:.88rem;font-weight:600;cursor:pointer;font-family:var(--ff-body);transition:background .18s,transform .15s;box-shadow:0 4px 14px rgba(45,110,110,.25); }
  .btn-save:hover { background:var(--teal-lt);transform:translateY(-1px); }
  .btn-cancel { background:transparent;color:rgba(59,42,26,.45);border:1.5px solid rgba(59,42,26,.14);border-radius:50px;padding:10px 22px;font-size:.88rem;font-weight:500;cursor:pointer;text-decoration:none;font-family:var(--ff-body);transition:all .15s;display:inline-flex;align-items:center; }
  .btn-cancel:hover { color:var(--brown);border-color:rgba(59,42,26,.3); }

  @media(max-width:600px){ .form-row { grid-template-columns:1fr; } }
</style>

<a href="{{ route('admin.trips.index') }}" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Back to Trips
</a>

@if($errors->any())
  <div class="errors-banner" style="max-width:680px;">Please fix the errors below.</div>
@endif

<div class="form-card">
  <div class="form-card-title">{{ isset($trip) ? 'Edit Trip' : 'Add New Trip' }}</div>

  {{-- Route preview --}}
  <div class="route-preview" id="routePreview">
    <span class="preview-origin" id="previewOrigin">Origin</span>
    <span class="preview-arrow">→</span>
    <span class="preview-dest" id="previewDest">Destination</span>
  </div>

  @isset($trip)
    <form method="POST" action="{{ route('admin.trips.update', $trip) }}">
    @csrf @method('PUT')
  @else
    <form method="POST" action="{{ route('admin.trips.store') }}">
    @csrf
  @endisset

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Origin Country <span class="req">*</span></label>
        <div class="sel-wrap">
          <select name="origin_country" id="originSelect"
                  class="form-input {{ $errors->has('origin_country') ? 'error' : '' }}"
                  onchange="updatePreview()" required>
            <option value="">Select country…</option>
            @foreach($countries as $country)
              <option value="{{ $country }}" {{ old('origin_country', $trip->origin_country ?? '') === $country ? 'selected' : '' }}>
                {{ $country }}
              </option>
            @endforeach
          </select>
        </div>
        @error('origin_country')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Destination Country <span class="req">*</span></label>
        <div class="sel-wrap">
          <select name="destination_country" id="destSelect"
                  class="form-input {{ $errors->has('destination_country') ? 'error' : '' }}"
                  onchange="updatePreview()" required>
            <option value="">Select country…</option>
            @foreach($countries as $country)
              <option value="{{ $country }}" {{ old('destination_country', $trip->destination_country ?? '') === $country ? 'selected' : '' }}>
                {{ $country }}
              </option>
            @endforeach
          </select>
        </div>
        @error('destination_country')<div class="form-error">{{ $message }}</div>@enderror
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Transport Type <span class="req">*</span></label>
        <input type="hidden" name="type" value="air">
        <div class="form-input" style="background:var(--sand);color:rgba(59,42,26,.5);cursor:default;user-select:none;">✈ Air</div>
        @error('type')<div class="form-error">{{ $message }}</div>@enderror
      </div>
      <div class="form-group">
        <label class="form-label">Status</label>
        <div class="sel-wrap">
          <select name="status" class="form-input">
            <option value="active"   {{ old('status', $trip->status ?? 'active') === 'active'   ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ old('status', $trip->status ?? '')       === 'inactive' ? 'selected' : '' }}>Inactive</option>
          </select>
        </div>
      </div>
    </div>

    <div class="form-row">
      <div class="form-group">
        <label class="form-label">Operator <span class="opt">(optional)</span></label>
        <input type="text" name="operator" class="form-input"
               value="{{ old('operator', $trip->operator ?? '') }}"
               placeholder="e.g. Philippine Airlines">
      </div>
      <div class="form-group">
        <label class="form-label">Max Passengers <span class="req">*</span></label>
        <input type="number" name="max_passengers"
               class="form-input {{ $errors->has('max_passengers') ? 'error' : '' }}"
               value="{{ old('max_passengers', $trip->max_passengers ?? 50) }}"
               min="1" max="9999" required>
        @error('max_passengers')<div class="form-error">{{ $message }}</div>@enderror
      </div>
    </div>

    <div style="display:flex;gap:10px;margin-top:6px;align-items:center;">
      <button type="submit" class="btn-save">{{ isset($trip) ? 'Save Changes' : 'Create Trip' }}</button>
      <a href="{{ route('admin.trips.index') }}" class="btn-cancel">Cancel</a>
    </div>
  </form>
</div>

<script>
function updatePreview() {
  const o = document.getElementById('originSelect').value || 'Origin';
  const d = document.getElementById('destSelect').value || 'Destination';
  document.getElementById('previewOrigin').textContent = o;
  document.getElementById('previewDest').textContent = d;
}
updatePreview();
</script>