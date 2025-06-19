<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Booking;
use App\Models\Movie;
use App\Models\MovieShow;
use App\Models\Seat;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $clientsCount = Client::count();
        $today = now()->toDateString();
        $month = now()->month;
        $year = now()->year;
        $bookingsToday = Booking::whereDate('booking_date', $today)->count();
        $bookingsMonth = Booking::whereMonth('booking_date', $month)->whereYear('booking_date', $year)->count();
        $moviesCount = Movie::count();
        $showsToday = MovieShow::whereDate('show_time', $today)->count();
        $showsWeek = MovieShow::whereBetween('show_time', [now()->startOfWeek(), now()->endOfWeek()])->count();
        $topMovies = Movie::withCount(['movieShows as bookings_count' => function($q) {
            $q->join('bookings', 'movie_shows.id', '=', 'bookings.movie_show_id');
        }])->orderByDesc('bookings_count')->take(5)->get();
        $seatsTotal = Seat::count();
        $seatsBooked = DB::table('tickets')->count();
        $seatsAvailable = $seatsTotal - $seatsBooked;
        return view('admin.dashboard', compact(
            'clientsCount',
            'bookingsToday',
            'bookingsMonth',
            'moviesCount',
            'showsToday',
            'showsWeek',
            'topMovies',
            'seatsTotal',
            'seatsBooked',
            'seatsAvailable'
        ));
    }
} 