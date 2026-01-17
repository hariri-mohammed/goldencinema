<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\Category;
use App\Models\Status;
use App\Models\Theater;
use Carbon\Carbon;

class CinemaController extends Controller
{
    public function index(Request $request)
    {
        $query = Movie::with(['status', 'categories']);

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $movies = $query->orderBy('release_date', 'desc')->get();

        $categories = Category::all();
        $statuses = Status::all();

        return view('movies.index', compact('movies', 'categories', 'statuses'));
    }

    public function show($id)
    {
        $movie = Movie::with([
            'status',
            'categories',
            'movieShows' => fn($q) => $q->where('status', 'active')
                ->where('show_time', '>=', now())
                ->with(['theater', 'screen'])
                ->orderBy('show_time')
        ])->findOrFail($id);

        $relatedMovies = $movie->relatedMovies();

        // Group shows by date, then city, then location using Laravel Collections
        $groupedShows = $movie->movieShows->groupBy(function ($show) {
            return Carbon::parse($show->show_time)->format('Y-m-d');
        })->map(function ($showsByDate) use ($movie) {
            return $showsByDate->groupBy('theater.location')->map(function ($showsByLocation) use ($movie) {
                return [
                    'theater' => $showsByLocation->first()->theater,
                    'times' => $showsByLocation->map(function ($show) use ($movie) {
                        $showDateTime = Carbon::parse($show->show_time);
                        return [
                            'id' => $show->id,
                            'start' => $showDateTime->format('g:i A'),
                            'end' => $showDateTime->copy()->addMinutes($movie->runtime + 10)->format('g:i A'),
                            'hall_number' => $show->screen->hall_number ?? 'N/A',
                        ];
                    }),
                ];
            });
        });


        return view('movies.show', compact('movie', 'relatedMovies', 'groupedShows'));
    }
}
