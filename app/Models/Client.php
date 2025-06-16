<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Client extends Authenticatable
{
    use Notifiable;

    protected $fillable = [
        'first_name',
        'last_name',
        'username',
        'email',
        'password',
        'date_of_birth',
        'gender',
        'phone_number',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // app/Models/Client.php
    protected $casts = [
        'email_verified_at' => 'datetime',
        'date_of_birth' => 'date', // أضف هذا السطر
    ];

    /**
     * Get the bookings for the client.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }
}
