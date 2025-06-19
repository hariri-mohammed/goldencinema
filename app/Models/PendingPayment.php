<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PendingPayment extends Model
{
    use HasFactory;

    protected $fillable = [
        'token',
        'movie_show_id',
        'seat_ids',
        'total_price',
    ];

    protected $casts = [
        'seat_ids' => 'array',
    ];
}
