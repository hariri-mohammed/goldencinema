<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Movie;
use App\Models\MovieShow;
use App\Models\Theater;
use App\Models\Screen;
use App\Models\Seat;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $totalMovies = Movie::count();
        $totalMovieShows = MovieShow::count();
        $totalTheaters = Theater::count();
        $totalScreens = Screen::count();
        $upcomingShows = MovieShow::where('show_time', '>=', Carbon::now())->count();
        $totalSeats = Seat::count();

        return view('manager.dashboard', compact(
            'totalMovies',
            'totalMovieShows',
            'totalTheaters',
            'totalScreens',
            'upcomingShows',
            'totalSeats'
        ));
    }
}
