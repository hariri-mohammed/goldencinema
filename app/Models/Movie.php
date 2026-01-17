<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Movie extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'language',
        'country',
        'release_date',
        'runtime',
        'rating',
        'image',
        'stars',
        'summary',
        'status_id',
    ];


    // العلاقات الأخرى...


    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'release_date' => 'date',
    ];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category');
    }

    public function movieShows()
    {
        return $this->hasMany(MovieShow::class);
    }
    public function relatedMovies()
    {
        // استخدام نفس الكود الذي يناسب الكنترولر الخاص بك
        $relatedMovies = Movie::whereHas('categories', function ($query) {
            $query->whereIn('category_id', $this->categories->pluck('id'));
        })
            ->where('id', '!=', $this->id)
            ->with(['categories', 'status'])
            ->limit(6)
            ->get();

        return $relatedMovies;
    }
    public function trailer()
    {
        return $this->hasOne(Trailer::class);
    }

    /**
     * Get the movie's runtime formatted as 'Xh Ym'.
     *
     * @return \Illuminate\Database\Eloquent\Casts\Attribute
     */
    protected function formattedRuntime(): Attribute
    {
        return Attribute::make(
            get: function ($value, $attributes) {
                if (empty($attributes['runtime'])) {
                    return 'N/A';
                }
                $minutes = $attributes['runtime'];
                $hours = floor($minutes / 60);
                $remainingMinutes = $minutes % 60;
                return "{$hours}h {$remainingMinutes}m";
            },
        );
    }
}
