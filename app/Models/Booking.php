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
}
