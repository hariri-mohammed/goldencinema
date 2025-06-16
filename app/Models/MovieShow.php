<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MovieShow extends Model
{
    use HasFactory;

    protected $fillable = [
        'movie_id',
        'theater_id',
        'screen_id',
        'show_time',
        'status',
        'price'
    ];

    protected $casts = [
        'show_time' => 'datetime',
        'price' => 'decimal:2'
    ];

    // Relationships
    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    /**
     * Get the bookings for the movie show.
     */
    public function bookings(): HasMany
    {
        return $this->hasMany(Booking::class);
    }

    // Time Conflict Check
    public static function hasTimeConflict($screenId, $showTime, $excludeShowId = null)
    {
        $query = self::where('screen_id', $screenId)
            ->where('show_time', $showTime)
            ->where('status', 'active');

        if ($excludeShowId) {
            $query->where('id', '!=', $excludeShowId);
        }

        return $query->exists();
    }

    // Calculate VIP price (20% more than base price)
    public function calculateVipPrice()
    {
        return round($this->base_price * 1.2, 2);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeUpcoming($query)
    {
        return $query->where('show_time', '>=', now()->toDateTimeString())
            ->where('status', 'active')
            ->orderBy('show_time');
    }
}
