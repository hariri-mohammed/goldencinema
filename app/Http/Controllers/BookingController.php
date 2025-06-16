<?php

namespace App\Http\Controllers;

use App\Models\MovieShow;
use App\Models\Booking;
use App\Models\Ticket;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

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

    public function store(Request $request)
    {
        \Log::info('BookingController@store: Request received.');
        \Log::info('Selected Seats Raw: ' . json_encode($request->selected_seats));

        $request->validate([
            'movie_show_id' => 'required|exists:movie_shows,id',
            'selected_seats' => 'required|string|min:1',
        ]);

        try {
            DB::beginTransaction();
            \Log::info('BookingController@store: Database transaction started.');

            $movieShow = MovieShow::findOrFail($request->movie_show_id);
            \Log::info('BookingController@store: MovieShow found with ID ' . $movieShow->id);

            $client = Auth::guard('client')->user();
            if (!$client) {
                throw new \Exception('Client not authenticated.');
            }
            \Log::info('BookingController@store: Client authenticated with ID ' . $client->id);

            $bookedSeats = Ticket::whereHas('booking', function ($query) use ($movieShow) {
                $query->where('movie_show_id', $movieShow->id);
            })->pluck('seat_id')->toArray();
            \Log::info('BookingController@store: Booked seats for this show: ' . json_encode($bookedSeats));

            $requestedSeats = json_decode($request->selected_seats, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception("Invalid JSON for selected seats.");
            }
            \Log::info('BookingController@store: Parsed requested seats: ' . json_encode($requestedSeats));

            if (array_intersect($requestedSeats, $bookedSeats)) {
                throw new \Exception('One or more selected seats are already booked.');
            }
            \Log::info('BookingController@store: No intersection with booked seats.');

            $totalPrice = 0;
            $seats = Seat::whereIn('id', $requestedSeats)->get();
            \Log::info('BookingController@store: Retrieved seat objects.');

            foreach ($seats as $seat) {
                $price = $movieShow->price;
                if ($seat->type === 'vip') {
                    $price = $movieShow->price * 1.2; // Use movieShow->price as base
                }
                $totalPrice += $price;
            }
            \Log::info('BookingController@store: Calculated total price: ' . $totalPrice);

            $booking = Booking::create([
                'movie_show_id' => $movieShow->id,
                'client_id' => $client->id,
                'number_of_tickets' => count($requestedSeats),
                'total_price' => $totalPrice,
                'booking_date' => now(),
                'status' => 'pending'
            ]);
            \Log::info('BookingController@store: Booking created with ID ' . $booking->id);

            foreach ($seats as $seat) {
                $price = $movieShow->price;
                if ($seat->type === 'vip') {
                    $price = $movieShow->price * 1.2; // Use movieShow->price as base
                }

                Ticket::create([
                    'booking_id' => $booking->id,
                    'seat_id' => $seat->id,
                    'price' => $price,
                    'status' => 'booked'
                ]);
                \Log::info('BookingController@store: Ticket created for seat ID ' . $seat->id);
            }
            \Log::info('BookingController@store: All tickets created.');

            $movieShow->update([
                'available_seats' => $movieShow->available_seats - count($requestedSeats)
            ]);
            \Log::info('BookingController@store: MovieShow available seats updated.');

            DB::commit();
            \Log::info('BookingController@store: Database transaction committed.');

            return redirect()->route('client.bookings.show', $booking)
                ->with('success', 'Booking completed successfully!');
        } catch (\Exception $e) {
            DB::rollBack();
            \Log::error("BookingController@store error: " . $e->getMessage() . ", Stack Trace: " . $e->getTraceAsString());
            return back()->with('error', $e->getMessage());
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
        $bookings = Auth::guard('client')->user()
            ->bookings()
            ->with(['movieShow.movie', 'movieShow.theater', 'movieShow.screen'])
            ->latest()
            ->paginate(10);

        return view('client.bookings.index', compact('bookings'));
    }

    public function processPayment(Booking $booking)
    {
        if ($booking->client_id !== Auth::guard('client')->id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'This booking cannot be paid.');
        }

        try {
            $booking->update([
                'status' => 'confirmed',
                'payment_id' => 'PAY-' . uniqid()
            ]);

            return redirect()->route('client.bookings.show', $booking)
                ->with('success', 'Payment completed successfully!');
        } catch (\Exception $e) {
            return back()->with('error', 'Payment failed: ' . $e->getMessage());
        }
    }

    public function cancel(Booking $booking)
    {
        if ($booking->client_id !== Auth::guard('client')->id()) {
            abort(403);
        }

        if ($booking->status !== 'pending') {
            return back()->with('error', 'This booking cannot be cancelled.');
        }

        try {
            DB::beginTransaction();

            $booking->update(['status' => 'cancelled']);
            $booking->tickets()->update(['status' => 'cancelled']);

            $movieShow = $booking->movieShow;
            $movieShow->update([
                'available_seats' => $movieShow->available_seats + $booking->number_of_tickets
            ]);

            DB::commit();

            return redirect()->route('client.bookings.index')
                ->with('success', 'Booking cancelled successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to cancel booking: ' . $e->getMessage());
        }
    }

    public function show(MovieShow $movieShow)
    {
        \Log::info('Attempting to load booking page for movie_show_id (show method): ' . $movieShow->id);
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

        \Log::info('MovieShow details in show method: ' . json_encode($movieShow->toArray()));

        return view('booking', compact('movieShow', 'seatsByRow', 'bookedSeatIds'));
    }
}
