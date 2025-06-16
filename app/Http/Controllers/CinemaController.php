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
        $query = Movie::with(['status', 'categories', 'movieShows']);

        // Apply search if search term is provided
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where('name', 'like', "%{$searchTerm}%");
        }

        $movies = $query->orderBy('release_date', 'desc')
            ->get()
            ->map(function ($movie) {
                $movie->release_date = \Carbon\Carbon::parse($movie->release_date);
                return $movie;
            });

        $categories = Category::all();
        $statuses = Status::all();

        return view('movies.index', compact('movies', 'categories', 'statuses'));
    }

    //دالة تحويل الوقت من دقائق لساعات
    private function convertMinutesToHoursAndMinutes($minutes)
    {
        $hours = floor($minutes / 60);
        $remainingMinutes = $minutes % 60;
        return "{$hours}h {$remainingMinutes}m";
    }


    public function show($id, Request $request)
    {
        $movie = Movie::with(['status', 'categories', 'movieShows' => function ($query) {
            $query->where('status', 'active')
                  ->where('show_time', '>=', now())
                  ->with(['theater', 'screen']);
        }])->findOrFail($id);

        $relatedMovies = $movie->relatedMovies();

        $groupedShows = [];
        $now = \Carbon\Carbon::now();

        foreach ($movie->movieShows as $show) {
            $showDateTime = \Carbon\Carbon::parse($show->show_time);
            
            // Only include future shows
            if ($showDateTime->isFuture()) {
                $date = $showDateTime->format('Y-m-d');
                // Calculate end time: start time + movie runtime + 10 minutes buffer
                $calculatedEndTime = $showDateTime->copy()->addMinutes($movie->runtime + 10)->format('g:i A');
                $displayStartTime = $showDateTime->format('g:i A');
                
                $location = $show->theater->location;
                $city = $show->theater->city ?? 'Unknown City';
                $theater = $show->theater;

                if (!isset($groupedShows[$date][$city][$location])) {
                    $groupedShows[$date][$city][$location] = [
                        'theater' => $theater,
                        'times' => []
                    ];
                }
                $groupedShows[$date][$city][$location]['times'][] = [
                    'id' => $show->id,
                    'start' => $displayStartTime,
                    'end' => $calculatedEndTime,
                    'hall_number' => $show->screen->hall_number ?? 'N/A',
                ];
            }
        }

        // Sort the dates
        ksort($groupedShows);

        // تحويل وقت العرض باستخدام الدالة
        $runtimeFormatted = $this->convertMinutesToHoursAndMinutes($movie->runtime);

        return view('movies.show', compact('movie', 'relatedMovies', 'groupedShows', 'runtimeFormatted'));
    }
}
