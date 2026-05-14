@extends('layouts.user')

@section('page-title', 'Promo Codes')

@section('content')
<style>
/* ── Page header ── */
.page-header {
    display: flex; align-items: center;
    gap: 16px; margin-bottom: 30px;
}
.page-header-icon {
    width: 48px; height: 48px;
    background: linear-gradient(135deg, var(--gold), var(--tan));
    border-radius: 14px;
    display: flex; align-items: center; justify-content: center;
    font-size: 22px; flex-shrink: 0;
    box-shadow: 0 4px 14px rgba(212,162,84,.25);
}
.page-title-h {
    font-family: var(--ff-head);
    font-size: 1.35rem; font-weight: 900; color: var(--brown);
}
.page-sub { font-size: .8rem; color: rgba(59,42,26,.45); margin-top: 3px; }

/* ── Grid ── */
.promos-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 18px;
}

/* ── Card shell ── */
.promo-card {
    background: var(--white);
    border: 1px solid rgba(59,42,26,.08);
    border-radius: var(--radius);
    overflow: hidden;
    box-shadow: 0 2px 16px rgba(59,42,26,.06);
    transition: transform .2s, box-shadow .2s, border-color .2s;
    position: relative;
}
.promo-card:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 36px rgba(59,42,26,.11);
    border-color: rgba(212,162,84,.4);
}

/* ── Top strip — dark brown to contrast badge (matches screenshot style) ── */
.promo-card-top {
    background: linear-gradient(135deg, #3b2a1a 0%, #4e3520 100%);
    padding: 20px 20px 18px;
    display: flex; align-items: flex-start;
    justify-content: space-between; gap: 12px;
}
.promo-discount-badge {
    background: var(--gold);
    color: var(--brown);
    font-size: 1.25rem; font-weight: 900;
    padding: 8px 14px; border-radius: 10px;
    white-space: nowrap; letter-spacing: -.5px;
    font-family: var(--ff-mono); flex-shrink: 0;
    box-shadow: 0 2px 10px rgba(212,162,84,.35);
}
.promo-title {
    font-family: var(--ff-head);
    font-size: 1rem; font-weight: 700;
    color: var(--sand); line-height: 1.3;
}
.promo-desc {
    font-size: .76rem; color: rgba(245,237,224,.45);
    margin-top: 5px; line-height: 1.5;
}

/* ── Card body — fully light ── */
.promo-card-body { padding: 18px 20px 20px; background: var(--white); }

/* ── Code row ── */
.promo-code-row {
    display: flex; align-items: center; gap: 10px;
    background: var(--sand);
    border: 1.5px dashed rgba(59,42,26,.18);
    border-radius: 12px; padding: 12px 16px;
    margin-bottom: 14px; cursor: pointer;
    transition: border-color .15s, background .15s;
}
.promo-code-row:hover { border-color: var(--gold); background: rgba(212,162,84,.07); }
.promo-code-label {
    font-size: .65rem; color: rgba(59,42,26,.4);
    text-transform: uppercase; letter-spacing: 1px; margin-bottom: 4px;
}
.promo-code-value {
    font-size: 1.25rem; font-weight: 800;
    color: var(--teal); font-family: var(--ff-mono);
    letter-spacing: 2.5px;
}
.copy-icon { color: rgba(59,42,26,.3); flex-shrink: 0; transition: color .15s; }
.promo-code-row:hover .copy-icon { color: var(--gold); }

/* ── Copy toast ── */
.copy-toast {
    position: absolute; top: 50%; left: 50%;
    transform: translate(-50%, -50%);
    background: rgba(45,110,110,.92); color: var(--white);
    padding: 6px 18px; border-radius: 20px;
    font-size: .78rem; font-weight: 700;
    pointer-events: none; opacity: 0; transition: opacity .2s;
    white-space: nowrap; z-index: 10;
}
.copy-toast.show { opacity: 1; }

/* ── Scope ── */
.promo-scope {
    font-size: .76rem; color: rgba(59,42,26,.55);
    background: rgba(45,110,110,.06);
    border: 1px solid rgba(45,110,110,.14);
    border-radius: 8px; padding: 7px 12px;
    margin-bottom: 13px;
    display: flex; align-items: center; gap: 7px;
}

/* ── Meta row ── */
.promo-meta {
    display: flex; justify-content: space-between; align-items: center;
    font-size: .74rem; color: rgba(59,42,26,.4); margin-bottom: 16px;
}
.promo-expires span { color: var(--gold); font-weight: 700; }

/* ── CTA button ── */
.use-promo-btn {
    display: block; width: 100%;
    background: var(--teal); color: var(--white);
    border: none; border-radius: 50px;
    padding: 12px; font-size: .88rem; font-weight: 700;
    text-align: center; text-decoration: none;
    cursor: pointer; font-family: var(--ff-body);
    transition: background .18s, transform .15s;
    letter-spacing: .02em;
}
.use-promo-btn:hover { background: var(--teal-lt); transform: translateY(-1px); }

/* ── Empty state ── */
.empty-state { text-align: center; padding: 80px 20px; color: rgba(59,42,26,.35); }
.empty-icon  { font-size: 48px; opacity: .2; margin-bottom: 14px; }
.empty-title { font-family: var(--ff-head); font-size: 1rem; font-weight: 700; color: rgba(59,42,26,.45); margin-bottom: 6px; }
.empty-sub   { font-size: .84rem; }

@media (max-width: 768px) { .promos-grid { grid-template-columns: 1fr; } }
</style>

<div class="max-w-7xl mx-auto">

    {{-- Page header --}}
    <div class="page-header">
        <div class="page-header-icon">🏷️</div>
        <div>
            <div class="page-title-h">Active Promo Codes</div>
            <div class="page-sub">Copy a code and paste it at checkout to save on your next booking.</div>
        </div>
    </div>

    @if($promos->isEmpty())
        <div class="empty-state">
            <div class="empty-icon">🎫</div>
            <div class="empty-title">No active promos right now</div>
            <div class="empty-sub">Check back soon — deals are added regularly.</div>
        </div>
    @else
        <div class="promos-grid">
            @foreach($promos as $promo)
            <div class="promo-card" id="card-{{ $promo->id }}">

                {{-- Dark top strip with title + gold badge --}}
                <div class="promo-card-top">
                    <div style="flex:1; min-width:0;">
                        <div class="promo-title">{{ $promo->title }}</div>
                        @if($promo->description)
                            <div class="promo-desc">{{ $promo->description }}</div>
                        @endif
                    </div>
                    <div class="promo-discount-badge">{{ $promo->formatted_discount }}</div>
                </div>

                {{-- Light body --}}
                <div class="promo-card-body">

                    {{-- Copyable code --}}
                    <div class="promo-code-row" onclick="copyCode('{{ $promo->promo_code }}', {{ $promo->id }})">
                        <div style="flex:1;">
                            <div class="promo-code-label">Promo Code</div>
                            <div class="promo-code-value">{{ $promo->promo_code }}</div>
                        </div>
                        <svg class="copy-icon" xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16">
                            <path d="M4 1.5H3a2 2 0 0 0-2 2V14a2 2 0 0 0 2 2h10a2 2 0 0 0 2-2V3.5a2 2 0 0 0-2-2h-1v1h1a1 1 0 0 1 1 1V14a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V3.5a1 1 0 0 1 1-1h1z"/>
                            <path d="M9.5 1a.5.5 0 0 1 .5.5v1a.5.5 0 0 1-.5.5h-3a.5.5 0 0 1-.5-.5v-1a.5.5 0 0 1 .5-.5zm-3-1A1.5 1.5 0 0 0 5 1.5v1A1.5 1.5 0 0 0 6.5 4h3A1.5 1.5 0 0 0 11 2.5v-1A1.5 1.5 0 0 0 9.5 0z"/>
                        </svg>
                    </div>
                    <div class="copy-toast" id="toast-{{ $promo->id }}">✓ Copied!</div>

                    {{-- Scope --}}
                    <div class="promo-scope">
                        <span>✈️</span>
                        @if($promo->applies_to_all)
                            Valid on all trips
                        @elseif($promo->trips->count())
                            Valid on: {{ $promo->trips->pluck('name')->join(', ') }}
                        @else
                            Selected trips only
                        @endif
                    </div>

                    {{-- Expires + type --}}
                    <div class="promo-meta">
                        <div class="promo-expires">
                            Expires <span>{{ $promo->end_date->format('M d, Y') }}</span>
                        </div>
                        <div>{{ $promo->discount_type === 'percentage' ? 'Percentage off' : 'Fixed discount' }}</div>
                    </div>

                    {{-- CTA --}}
                    <a href="{{ route('bookings.create') }}" class="use-promo-btn">
                        Book &amp; Use This Code →
                    </a>
                </div>

            </div>
            @endforeach
        </div>
    @endif

</div>

<script>
function copyCode(code, id) {
    navigator.clipboard.writeText(code).then(() => {
        const toast = document.getElementById('toast-' + id);
        toast.classList.add('show');
        setTimeout(() => toast.classList.remove('show'), 1800);
    });
}
</script>
@endsection