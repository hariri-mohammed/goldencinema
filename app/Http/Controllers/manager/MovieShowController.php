<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\MovieShow;
use App\Models\Screen;
use App\Models\Theater;
use Illuminate\Http\Request;
use Carbon\Carbon;

class MovieShowController extends Controller
{
    public function index(Request $request)
    {
        $query = MovieShow::with(['movie', 'theater', 'screen']);

        // Apply filters
        if ($request->filled('movie')) {
            $query->where('movie_id', $request->movie);
        }
        if ($request->filled('theater')) {
            $query->where('theater_id', $request->theater);
        }
        if ($request->filled('date')) {
            $query->whereDate('show_time', $request->date);
        }

        $shows = $query->latest()->paginate(10);
        $movies = movie::all();
        $theaters = Theater::all();
        $screens = collect();

        if ($request->has('theater_id') && $request->theater_id) {
            $screens = Screen::where('theater_id', $request->theater_id)->get();
        }

        return view('manager.movie_shows.index', compact('shows', 'movies', 'theaters', 'screens'));
    }

    public function create(Request $request)
    {
        $movies =   movie::all();
        $theaters = Theater::all();
        $screens = collect();

        if ($request->has('theater_id') && $request->theater_id) {
            $screens = Screen::where('theater_id', $request->theater_id)->get();
        }

        return view('manager.movie_shows.create', compact('movies', 'theaters', 'screens'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'screen_id' => 'required|exists:screens,id',
            'show_time' => 'required|date|after:now',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric|min:0'
        ]);

        MovieShow::create($validated);

        return redirect()->route('manager.movie-shows.index')
            ->with('success', 'Movie show created successfully.');
    }

    public function show(MovieShow $movieShow)
    {
        return view('manager.movie_shows.show', ['show' => $movieShow]);
    }

    public function edit($id)
    {
        $show = MovieShow::findOrFail($id);
        $movies = Movie::orderBy('name')->get(); // جلب كل الأفلام
        $theaters = Theater::all();
        $screens = Screen::where('theater_id', $show->theater_id)->get();

        return view('manager.movie_shows.edit', compact('show', 'movies', 'theaters', 'screens'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'movie_id' => 'required|exists:movies,id',
            'theater_id' => 'required|exists:theaters,id',
            'screen_id' => 'required|exists:screens,id',
            'show_time' => 'required|date|after:now',
            'status' => 'required|in:active,inactive',
            'price' => 'required|numeric|min:0'
        ]);

        $movieShow = MovieShow::findOrFail($id);
        $movieShow->update($validated);

        return redirect()->route('manager.movie-shows.index')
            ->with('success', 'Movie show updated successfully.');
    }

    public function destroy(MovieShow $movieShow)
    {
        $movieShow->delete();

        return redirect()->route('manager.movie-shows.index')
            ->with('success', 'Movie show deleted successfully.');
    }

    public function getScreens($theaterId)
    {
        try {
            $screens = Screen::where('theater_id', $theaterId)
                ->with('seats')
                ->get()
                ->map(function ($screen) {
                    return [
                        'id' => $screen->id,
                        'name' => $screen->screen_name,
                        'total_seats' => $screen->seats->count()
                    ];
                });

            return response()->json($screens);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
