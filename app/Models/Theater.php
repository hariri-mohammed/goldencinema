<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Theater extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'location',
        'city'
    ];

    /**
     * Get the screens for the theater.
     */
    public function screens()
    {
        return $this->hasMany(Screen::class);
    }

    /**
     * Get the movie shows for the theater.
     */
    public function movieShows()
    {
        return $this->hasMany(MovieShow::class);
    }

    /**
     * Get the total number of screens in the theater.
     */
    public function getScreensCountAttribute()
    {
        return $this->screens()->count();
    }

    /**
     * Get the upcoming shows for the theater.
     */
    public function getUpcomingShowsAttribute()
    {
        return $this->movieShows()
            ->where('show_time', '>=', now())
            ->count();
    }

    /**
     * Get the total seats capacity across all screens.
     */
    public function getTotalSeatsAttribute()
    {
        return $this->screens()
            ->withCount('seats')
            ->get()
            ->sum('seats_count');
    }

    /**
     * Boot the model.
     */
    protected static function boot()
    {
        parent::boot();

        // Before deleting a theater, ensure all related data is handled properly
        static::deleting(function ($theater) {
            // You might want to prevent deletion if there are upcoming shows
            if ($theater->getUpcomingShowsAttribute() > 0) {
                throw new \Exception('Cannot delete theater with upcoming shows.');
            }
        });
    }

    /**
     * Scope a query to only include theaters with available screens.
     */
    public function scopeWithAvailableScreens($query)
    {
        return $query->whereHas('screens', function ($q) {
            $q->where('status', 'active');
        });
    }

    /**
     * Check if the theater has any active screens.
     */
    public function hasActiveScreens()
    {
        return $this->screens()->where('status', 'active')->exists();
    }

    /**
     * Get the theater's full address.
     */
    public function getFullAddressAttribute()
    {
        return "{$this->location}, {$this->city}";
    }
}
