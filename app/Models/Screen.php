<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Screen extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_name',
        'screen_number',
        'status',
        'theater_id'
    ];

    public function theater()
    {
        return $this->belongsTo(Theater::class);
    }

    public function seats()
    {
        return $this->hasMany(Seat::class);
    }

    public function movieShows()
    {
        return $this->hasMany(MovieShow::class);
    }

    public function getSeatsCountAttribute()
    {
        return $this->seats()->count();
    }

    public function getActiveShowsCountAttribute()
    {
        return $this->movieShows()
            ->where('show_time', '>=', now())
            ->count();
    }
}
