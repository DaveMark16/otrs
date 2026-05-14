@extends('admin.layouts.app')
@section('page-title', 'Edit Promo')

@section('content')
<style>
  .back-link { display:inline-flex;align-items:center;gap:6px;color:rgba(59,42,26,.4);text-decoration:none;font-size:.82rem;font-weight:500;margin-bottom:18px;transition:color .15s; }
  .back-link:hover { color:var(--teal); }
  .back-link svg { width:14px;height:14px;stroke:currentColor;fill:none;stroke-width:2;stroke-linecap:round; }
  .page-hd { margin-bottom:22px; }
  .page-title { font-family:var(--ff-head);font-size:1.3rem;font-weight:900;color:var(--brown); }
  .page-sub { font-size:.8rem;color:rgba(59,42,26,.4);margin-top:3px; }
  .f-error-banner { background:rgba(180,68,68,.06);border:1.5px solid rgba(180,68,68,.2);border-radius:var(--radius-sm);padding:12px 16px;margin-bottom:18px;font-size:.84rem;color:#b44444; }
</style>

<a href="{{ route('admin.promos.index') }}" class="back-link">
  <svg viewBox="0 0 24 24"><polyline points="15 18 9 12 15 6"/></svg>
  Back to Promos
</a>
<div class="page-hd">
  <div class="page-title">Edit Promo</div>
  <div class="page-sub">Editing: <span style="color:var(--teal);font-weight:600;">{{ $promo->title }}</span></div>
</div>

@if($errors->any())
  <div class="f-error-banner">Please fix the following errors before continuing.</div>
@endif

@include('admin.promos.form', [
    'promo'  => $promo,
    'trips'  => $trips,
    'action' => route('admin.promos.update', $promo),
    'method' => 'PUT',
])
@endsection