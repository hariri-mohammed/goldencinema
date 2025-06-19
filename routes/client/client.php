<?php

use App\Http\Controllers\BookingController;
use App\Http\Controllers\Client\PaymentController;
use App\Http\Controllers\Client\TicketController;
use App\Http\Controllers\Client\ClientProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Middleware\RedirectIfNotClient;

Route::middleware([RedirectIfNotClient::class])->group(function () {
    Route::get('client/payments/create', [PaymentController::class, 'create'])->name('client.payments.create');
    Route::post('client/payments', [PaymentController::class, 'store'])->name('client.payments.store');

    Route::get('client/tickets', [TicketController::class, 'index'])->name('client.tickets.index');
    Route::get('client/tickets/{ticket}', [TicketController::class, 'show'])->name('client.tickets.show');
    Route::get('client/tickets/{ticket}/pdf', [TicketController::class, 'downloadPdf'])->name('client.tickets.pdf');
    Route::get('client/tickets/{ticket}/download', [TicketController::class, 'downloadTicket'])->name('client.tickets.download');

    Route::get('client/bookings', [BookingController::class, 'index'])->name('client.bookings.index');
    Route::get('client/bookings/{booking}', [BookingController::class, 'showBooking'])->name('client.bookings.show');
    Route::post('client/bookings/{movie_show}', [BookingController::class, 'store'])->name('client.bookings.store');

    Route::get('client/profile', [ClientProfileController::class, 'show'])->name('client.profile');
    Route::get('client/profile/edit', [ClientProfileController::class, 'edit'])->name('client.profile.edit');
    Route::put('client/profile', [ClientProfileController::class, 'update'])->name('client.profile.update');
});