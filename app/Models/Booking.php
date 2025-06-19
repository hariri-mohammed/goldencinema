<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Booking extends Model
{
    protected $fillable = [
        'movie_show_id',
        'client_id',
        'number_of_tickets',
        'total_price',
        'booking_date',
        'status',
        'payment_id',
    ];

    protected $casts = [
        'booking_date' => 'datetime',
    ];

    /**
     * Get the movie show that owns the booking.
     */
    public function movieShow(): BelongsTo
    {
        return $this->belongsTo(MovieShow::class);
    }

    /**
     * Get the client that owns the booking.
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Get the tickets for the booking.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    /**
     * Check if the booking can be cancelled
     */
    public function canBeCancelled(): bool
    {
        // With direct confirmation, cancellation logic might need to be redefined.
        // For now, it will always return false, as pending status is removed and only confirmed bookings exist.
        return false; // Or redefine based on future cancellation policy for confirmed bookings.
    }

    /**
     * Process refund for cancelled booking
     */
    public function processRefund(): bool
    {
        // This method assumes a cancellation process exists. 
        // With direct confirmation and no client-side cancellation, this might be handled differently.
        // If you need refunds for confirmed bookings, this logic needs to be integrated with a payment gateway.
        if (!$this->canBeCancelled()) {
            return false;
        }

        // Here you would integrate with your payment gateway to process the refund
        // For example: PaymentGateway::refund($this->payment_id, $this->total_price);
        
        $this->update([
            'status' => 'cancelled',
            'payment_status' => 'refunded',
            'refunded_amount' => $this->total_price
        ]);

        return true;
    }
}
