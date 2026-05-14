<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return view('landing');
})->name('home');

// Public booking page — browse flights without auth
Route::get('/book', [App\Http\Controllers\BookingPageController::class, 'index'])->name('booking-page');

// ─────────────────────────────────────────────────────────────────
// USER ROUTES — authenticated, non-admin only
// ─────────────────────────────────────────────────────────────────
Route::middleware(['auth'])->group(function () {

    // Dashboard — redirects admin away to admin panel
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])
        ->name('dashboard');

    // Bookings
    Route::get('/bookings', [App\Http\Controllers\BookingController::class, 'index'])->name('bookings.index');
    Route::get('/bookings/create', [App\Http\Controllers\BookingController::class, 'create'])->name('bookings.create');
    Route::post('/bookings', [App\Http\Controllers\BookingController::class, 'store'])->name('bookings.store');
    Route::get('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'show'])->name('bookings.show');
    Route::get('/bookings/{booking}/edit', [App\Http\Controllers\BookingController::class, 'edit'])->name('bookings.edit');
    Route::put('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'update'])->name('bookings.update');
    Route::delete('/bookings/{booking}', [App\Http\Controllers\BookingController::class, 'destroy'])->name('bookings.destroy');
    Route::post('/bookings/{booking}/pay', [App\Http\Controllers\BookingController::class, 'pay'])->name('bookings.pay');
    Route::post('/bookings/check-promo', [App\Http\Controllers\BookingController::class, 'checkPromo'])->name('bookings.check-promo');
    Route::get('/bookings/{booking}/receipt', [App\Http\Controllers\BookingController::class, 'receipt'])->name('bookings.receipt');

    // Schedules
    Route::get('/schedules', [App\Http\Controllers\ScheduleController::class, 'index'])->name('schedules.index');
    Route::get('/schedules/{trip}', [App\Http\Controllers\ScheduleController::class, 'show'])->name('schedules.show');

    // Tickets
    Route::get('/tickets', [App\Http\Controllers\TicketController::class, 'index'])->name('tickets.index');
    Route::post('/tickets/{ticket}/cancel', [App\Http\Controllers\TicketController::class, 'cancel'])->name('tickets.cancel');

    // Payments (user view)
    Route::get('/payments', [App\Http\Controllers\PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [App\Http\Controllers\PaymentController::class, 'show'])->name('payments.show');
    Route::post('/payments/{payment}/refund', [App\Http\Controllers\PaymentController::class, 'refund'])->name('payments.refund');

    // Promos (user-facing)
    Route::get('/promos', [App\Http\Controllers\PromoPageController::class, 'index'])->name('promos.index');

    // Profile
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ─────────────────────────────────────────────────────────────────
// ADMIN ROUTES — authenticated + admin/superadmin role ONLY
// ─────────────────────────────────────────────────────────────────
Route::middleware(['auth', 'role:admin,superadmin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Admin Dashboard
        Route::get('/dashboard', [App\Http\Controllers\Admin\AdminDashboardController::class, 'index'])
            ->name('dashboard');

        // Booking Management
        Route::get('/bookings', [App\Http\Controllers\Admin\AdminBookingController::class, 'index'])
            ->name('bookings.index');
        Route::get('/bookings/{booking}', [App\Http\Controllers\Admin\AdminBookingController::class, 'show'])
            ->name('bookings.show');
        Route::patch('/bookings/{booking}/approve', [App\Http\Controllers\Admin\AdminBookingController::class, 'approve'])
            ->name('bookings.approve');
        Route::patch('/bookings/{booking}/reject', [App\Http\Controllers\Admin\AdminBookingController::class, 'reject'])
            ->name('bookings.reject');
        Route::patch('/bookings/{booking}/status', [App\Http\Controllers\Admin\AdminBookingController::class, 'updateStatus'])
            ->name('bookings.status');
        Route::delete('/bookings/{booking}', [App\Http\Controllers\Admin\AdminBookingController::class, 'destroy'])
            ->name('bookings.destroy');

        // User Management
        Route::get('/users', [App\Http\Controllers\Admin\AdminUserController::class, 'index'])
            ->name('users.index');
        Route::get('/users/{user}/edit', [App\Http\Controllers\Admin\AdminUserController::class, 'edit'])
            ->name('users.edit');
        Route::patch('/users/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'update'])
            ->name('users.update');
        Route::delete('/users/{user}', [App\Http\Controllers\Admin\AdminUserController::class, 'destroy'])
            ->name('users.destroy');
        Route::patch('/users/{user}/toggle', [App\Http\Controllers\Admin\AdminUserController::class, 'toggle'])
            ->name('users.toggle');
        Route::patch('/users/{user}/role', [App\Http\Controllers\Admin\AdminUserController::class, 'updateRole'])
            ->name('users.role');

        // Trip Management (full CRUD)
        Route::get('/trips', [App\Http\Controllers\Admin\AdminTripController::class, 'index'])
            ->name('trips.index');
        Route::get('/trips/create', [App\Http\Controllers\Admin\AdminTripController::class, 'create'])
            ->name('trips.create');
        Route::post('/trips', [App\Http\Controllers\Admin\AdminTripController::class, 'store'])
            ->name('trips.store');
        Route::get('/trips/{trip}/edit', [App\Http\Controllers\Admin\AdminTripController::class, 'edit'])
            ->name('trips.edit');
        Route::put('/trips/{trip}', [App\Http\Controllers\Admin\AdminTripController::class, 'update'])
            ->name('trips.update');
        Route::delete('/trips/{trip}', [App\Http\Controllers\Admin\AdminTripController::class, 'destroy'])
            ->name('trips.destroy');

        // Schedule Management
        Route::get('/schedules', [App\Http\Controllers\Admin\AdminScheduleController::class, 'index'])
            ->name('schedules.index');
        Route::get('/schedules/create', [App\Http\Controllers\Admin\AdminScheduleController::class, 'create'])
            ->name('schedules.create');
        Route::post('/schedules', [App\Http\Controllers\Admin\AdminScheduleController::class, 'store'])
            ->name('schedules.store');
        Route::get('/schedules/{schedule}/edit', [App\Http\Controllers\Admin\AdminScheduleController::class, 'edit'])
            ->name('schedules.edit');
        Route::put('/schedules/{schedule}', [App\Http\Controllers\Admin\AdminScheduleController::class, 'update'])
            ->name('schedules.update');
        Route::delete('/schedules/{schedule}', [App\Http\Controllers\Admin\AdminScheduleController::class, 'destroy'])
            ->name('schedules.destroy');

        // Payment Management
        Route::get('/payments', [App\Http\Controllers\Admin\AdminPaymentController::class, 'index'])
            ->name('payments.index');
        Route::patch('/payments/{payment}/verify', [App\Http\Controllers\Admin\AdminPaymentController::class, 'verify'])
            ->name('payments.verify');
        Route::patch('/payments/{payment}/status', [App\Http\Controllers\Admin\AdminPaymentController::class, 'updateStatus'])
            ->name('payments.status');

        // Promo Management
        Route::get('/promos', [App\Http\Controllers\Admin\AdminPromoController::class, 'index'])
            ->name('promos.index');
        Route::get('/promos/create', [App\Http\Controllers\Admin\AdminPromoController::class, 'create'])
            ->name('promos.create');
        Route::post('/promos', [App\Http\Controllers\Admin\AdminPromoController::class, 'store'])
            ->name('promos.store');
        Route::get('/promos/{promo}', [App\Http\Controllers\Admin\AdminPromoController::class, 'show'])
            ->name('promos.show');
        Route::get('/promos/{promo}/edit', [App\Http\Controllers\Admin\AdminPromoController::class, 'edit'])
            ->name('promos.edit');
        Route::put('/promos/{promo}', [App\Http\Controllers\Admin\AdminPromoController::class, 'update'])
            ->name('promos.update');
        Route::delete('/promos/{promo}', [App\Http\Controllers\Admin\AdminPromoController::class, 'destroy'])
            ->name('promos.destroy');
    });

require __DIR__.'/auth.php';