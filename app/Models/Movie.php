<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
        'img',
        'stars',
        'summary',
    ];


    // العلاقات الأخرى...


    protected $attributes = [
        'status_id' => 2, // Set default to 2
    ];

    // إضافة الحقل release_date إلى المصفوفة dates
    protected $dates = ['release_date'];

    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'movie_category', 'movie_id', 'category_id');
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
}
