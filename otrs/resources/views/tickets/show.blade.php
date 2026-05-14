@extends('layouts.user')

@section('content')
<link href="https://cdn.jsdelivr.net/npm/tailwindcss@2/dist/tailwind.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
<style>
    body { background: #121313; }
    .payment-card {
        background: #1a1b1b;
        border: 1px solid #2a2b2b;
        border-radius: 24px;
        transition: transform 0.2s, box-shadow 0.2s;
    }
    .payment-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 20px 25px -12px rgba(0,0,0,0.3);
    }
    .status-badge {
        display: inline-flex;
        align-items: center;
        padding: 6px 14px;
        border-radius: 40px;
        font-size: 12px;
        font-weight: 600;
    }
    .status-paid {
        background: rgba(76,175,129,0.15);
        color: #4caf81;
        border: 1px solid rgba(76,175,129,0.3);
    }
    .status-pending {
        background: rgba(239,159,39,0.15);
        color: #ef9f27;
        border: 1px solid rgba(239,159,39,0.3);
    }
    .status-failed {
        background: rgba(226,75,74,0.15);
        color: #e24b4a;
        border: 1px solid rgba(226,75,74,0.3);
    }
    .info-card {
        background: #121313;
        border-radius: 16px;
        padding: 16px;
        border: 1px solid #2a2b2b;
    }
    .back-link {
        display: inline-flex;
        align-items: center;
        gap: 6px;
        background: #1a1b1b;
        border: 1px solid #2a2b2b;
        border-radius: 40px;
        padding: 6px 14px;
        font-size: 12px;
        color: #FF6044;
        transition: 0.2s;
        text-decoration: none;
        margin-bottom: 20px;
    }
    .back-link:hover {
        background: #222;
        border-color: #FF6044;
        color: white;
    }
</style>

<div class="max-w-4xl mx-auto py-6 px-4 md:px-6">
    <a href="{{ route('payments.index') }}" class="back-link inline-flex">
        <i class="fas fa-arrow-left text-xs"></i> Back to Payments
    </a>

    <div class="payment-card overflow-hidden">
        <div class="flex flex-wrap justify-between items-center p-6 border-b border-[#2a2b2b] bg-[#1e1f20]">
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wider">Transaction Reference</p>
                <h2 class="text-2xl md:text-3xl font-mono font-bold text-[#FF6044] mt-1">{{ $payment->transaction_ref }}</h2>
            </div>
            <div class="mt-3 sm:mt-0">
                <span class="status-badge status-{{ $payment->status }}">
                    <i class="fas {{ $payment->status == 'paid' ? 'fa-check-circle' : ($payment->status == 'pending' ? 'fa-clock' : 'fa-times-circle') }} mr-1"></i>
                    {{ ucfirst($payment->status) }}
                </span>
            </div>
        </div>

        <div class="p-6 md:p-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Left column -->
                <div class="space-y-6">
                    <div>
                        <div class="flex items-center gap-2 text-[#FF6044] mb-3">
                            <i class="fas fa-user-circle text-lg"></i>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Passenger</span>
                        </div>
                        <div class="info-card">
                            <p class="text-white font-semibold text-base">{{ $payment->booking->user->name }}</p>
                            <p class="text-gray-400 text-sm mt-0.5">{{ $payment->booking->user->email }}</p>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 text-[#FF6044] mb-3">
                            <i class="fas fa-plane-departure text-sm"></i>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Booking Reference</span>
                        </div>
                        <div class="info-card">
                            <p class="font-mono text-[#FF6044]">{{ $payment->booking->reference_no }}</p>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 text-[#FF6044] mb-3">
                            <i class="fas fa-credit-card text-sm"></i>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Payment Method</span>
                        </div>
                        <div class="info-card">
                            <p class="text-white">{{ ucfirst($payment->method) }}</p>
                        </div>
                    </div>
                </div>

                <!-- Right column -->
                <div class="space-y-6">
                    <div>
                        <div class="flex items-center gap-2 text-[#FF6044] mb-3">
                            <i class="fas fa-ticket-alt text-sm"></i>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Trip Details</span>
                        </div>
                        <div class="info-card">
                            <div class="flex flex-wrap items-center gap-3">
                                <span class="font-medium text-white">{{ $payment->booking->schedule->trip->origin ?? '?' }}</span>
                                <i class="fas fa-long-arrow-alt-right text-[#FF6044] text-sm"></i>
                                <span class="font-medium text-white">{{ $payment->booking->schedule->trip->destination ?? '?' }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-4 text-sm text-gray-400">
                                <i class="far fa-calendar-alt"></i>
                                <span>Departure: <span class="text-white font-medium">{{ $payment->booking->schedule->departure_at ? $payment->booking->schedule->departure_at->format('M d, Y · h:i A') : '—' }}</span></span>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 text-[#FF6044] mb-3">
                            <i class="fas fa-money-bill-wave text-sm"></i>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Amount</span>
                        </div>
                        <div class="info-card bg-gradient-to-r from-[#1f1a18] to-[#121313] border-[#FF6044]/30">
                            <p class="text-3xl font-bold text-[#FF6044]">₱{{ number_format($payment->amount, 2) }}</p>
                            <p class="text-gray-500 text-xs mt-1">Paid via {{ ucfirst($payment->method) }}</p>
                        </div>
                    </div>

                    <div>
                        <div class="flex items-center gap-2 text-[#FF6044] mb-3">
                            <i class="fas fa-calendar-check text-sm"></i>
                            <span class="text-xs font-semibold uppercase tracking-wider text-gray-400">Payment Date</span>
                        </div>
                        <div class="info-card">
                            <p class="text-white">{{ $payment->paid_at ? $payment->paid_at->format('M d, Y h:i A') : '—' }}</p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-dashed border-[#2a2b2b] text-center text-xs text-gray-500">
                <i class="fas fa-receipt mr-1"></i> This payment is associated with booking {{ $payment->booking->reference_no }}
            </div>
        </div>
    </div>
</div>
@endsection