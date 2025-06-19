<?php

namespace App\Http\Controllers;

use App\Models\MovieShow;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Seat;
use App\Models\PendingPayment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function create($movie_show_id)
    {
        \Log::info('Attempting to load booking page for movie_show_id: ' . $movie_show_id);
        try {
            $movieShow = MovieShow::with([
                'movie',
                'theater',
                'screen.seats' => function ($query) {
                    $query->orderBy('row')->orderBy('number');
                },
                'bookings.tickets.seat'
            ])->findOrFail($movie_show_id);

            \Log::info('MovieShow ID: ' . $movieShow->id);
            \Log::info('MovieShow movie_id: ' . $movieShow->movie_id . ', theater_id: ' . $movieShow->theater_id . ', screen_id: ' . $movieShow->screen_id);

            if ($movieShow->movie) {
                \Log::info('Movie Title: ' . $movieShow->movie->title);
            } else {
                \Log::info('Movie relation is null.');
            }

            if ($movieShow->theater) {
                \Log::info('Theater Name: ' . $movieShow->theater->name);
            } else {
                \Log::info('Theater relation is null.');
            }

            if ($movieShow->screen) {
                \Log::info('Screen Name: ' . $movieShow->screen->name);
            } else {
                \Log::info('Screen relation is null.');
            }

            if ($movieShow->status !== 'active') {
                if (request()->expectsJson()) {
                    return response()->json(['success' => false, 'message' => 'This show is not available for booking.'], 400);
                }
                return back()->with('error', 'This show is not available for booking.');
            }

            if (!Auth::guard('client')->check()) {
                if (request()->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Please login to book tickets.',
                        'showLoginModal' => true
                    ], 401);
                }

                return redirect()->route('client.login')
                    ->with('error', 'Please login to book tickets.')
                    ->with('redirect_after_login', route('booking.create', $movieShow->id));
            }

            $bookedSeatIds = [];
            foreach ($movieShow->bookings as $booking) {
                foreach ($booking->tickets as $ticket) {
                    $bookedSeatIds[] = $ticket->seat_id;
                }
            }

            $seatsByRow = $movieShow->screen->seats->groupBy('row');

            return view('booking', compact('movieShow', 'seatsByRow', 'bookedSeatIds'));
        } catch (\Exception $e) {
            \Log::error("BookingController@create error: " . $e->getMessage());
            if (request()->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Failed to load booking page: ' . $e->getMessage()], 500);
            }
            return back()->with('error', 'Failed to load booking page: ' . $e->getMessage());
        }
    }

    public function store(Request $request, MovieShow $movieShow)
    {
        \Log::info('BookingController@store: Starting store method');
        \Log::info('BookingController@store: Request data', $request->all());
        \Log::info('BookingController@store: MovieShow ID', ['id' => $movieShow->id]);

        $request->validate([
            'seats' => 'required|string'
        ]);

        \Log::info('BookingController@store: Received request->seats', ['seats' => $request->seats]);
        \Log::info('BookingController@store: MovieShow details', [
            'id' => $movieShow->id,
            'screen_id' => $movieShow->screen_id
        ]);

        try {
            DB::beginTransaction();

            // Parse the JSON string of seat IDs
            $seatIds = json_decode($request->seats, true);
            
            if (!is_array($seatIds) || empty($seatIds)) {
                \Log::error('BookingController@store: Invalid seat selection - not an array or empty');
                throw new \Exception('Invalid seat selection.');
            }
            \Log::info('BookingController@store: Decoded seat IDs', ['seat_ids' => $seatIds]);

            // Get all booked seats for this movie show
            $bookedSeatIds = Ticket::whereHas('booking', function($query) use ($movieShow) {
                $query->where('movie_show_id', $movieShow->id)
                      ->where('status', '!=', 'cancelled');
            })->pluck('seat_id')->toArray();

            \Log::info('BookingController@store: Booked seat IDs for this movie show', ['booked_seat_ids' => $bookedSeatIds]);

            // Check if any of the selected seats are already booked
            $alreadyBookedSeats = array_intersect($seatIds, $bookedSeatIds);
            if (!empty($alreadyBookedSeats)) {
                \Log::error('BookingController@store: Some seats are already booked', ['already_booked_seats' => $alreadyBookedSeats]);
                throw new \Exception('One or more selected seats are no longer available.');
            }

            // Get the selected seats that belong to this movie show's screen
            $selectedSeats = Seat::whereIn('id', $seatIds)
                ->where('screen_id', $movieShow->screen_id)
                ->get();

            \Log::info('BookingController@store: Retrieved selected seats', [
                'count' => $selectedSeats->count(),
                'expected_count' => count($seatIds),
                'seat_ids' => $selectedSeats->pluck('id')->toArray()
            ]);

            if ($selectedSeats->count() !== count($seatIds)) {
                \Log::error('BookingController@store: Seat count mismatch');
                throw new \Exception('One or more selected seats are not valid or do not belong to this screen.');
            }

            // Calculate total price
            $totalPrice = $selectedSeats->sum(function($seat) use ($movieShow) {
                return $seat->type === 'vip' ? $movieShow->price * 1.2 : $movieShow->price;
            });

            // Generate a unique token
            $token = Str::random(40);

            // Store booking data in pending_payments table
            $pending = PendingPayment::create([
                'token' => $token,
                'movie_show_id' => $movieShow->id,
                'seat_ids' => json_encode($seatIds),
                'total_price' => $totalPrice,
            ]);

            DB::commit();

            \Log::info('BookingController@store: Redirecting to payment form with token', ['token' => $token]);
            return redirect()->to('/client/payments/create?token=' . $token);

        } catch (\Exception $e) {
            DB::rollBack(); // Ensure rollback even if not creating booking here
            \Log::error("BookingController@store error", [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);
            return back()->with('error', 'فشل في إعداد الحجز: ' . $e->getMessage());
        }
    }

    public function showBooking(Booking $booking)
    {
        if ($booking->client_id !== Auth::guard('client')->id()) {
            abort(403);
        }

        // Eager load the necessary relations for the booking details page
        $booking->load(['movieShow.movie', 'movieShow.theater', 'movieShow.screen', 'tickets.seat', 'client']);

        \Log::info('Booking details in showBooking method: ' . json_encode($booking->toArray()));
        if ($booking->movieShow) {
            \Log::info('MovieShow details in showBooking method: ' . json_encode($booking->movieShow->toArray()));
        } else {
            \Log::info('MovieShow relation is null in showBooking method.');
        }

        return view('client.bookings.show', compact('booking'));
    }

    public function index()
    {
        $client = \Auth::guard('client')->user();
        if (!$client) {
            return redirect()->route('client.login')->with('error', 'Please login to view your bookings.');
        }

        $bookings = $client->bookings()
            ->with(['movieShow.movie', 'movieShow.screen'])
            ->latest()
            ->paginate(10);

        return view('client.bookings.index', compact('bookings'));
    }

    public function show(MovieShow $movieShow)
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login')
                ->with('error', 'Please login to book tickets.')
                ->with('redirect_after_login', route('booking.show', $movieShow));
        }

        if ($movieShow->status !== 'active') {
            return back()->with('error', 'This show is not available for booking.');
        }

        if ($movieShow->show_time <= now()) {
            return back()->with('error', 'This show has already started.');
        }

        $seats = $movieShow->screen->seats()->orderBy('row')->orderBy('number')->get();
        $seatsByRow = $seats->groupBy('row');

        $bookedSeatIds = Ticket::whereHas('booking', function ($query) use ($movieShow) {
            $query->where('movie_show_id', $movieShow->id);
        })->pluck('seat_id')->toArray();

        return view('booking', compact('movieShow', 'seatsByRow', 'bookedSeatIds'));
    }
}
