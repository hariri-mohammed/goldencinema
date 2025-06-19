<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\MovieShow;
use App\Models\Seat;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Models\PendingPayment;
use App\Models\Ticket;

class PaymentController extends Controller
{
    public function showPaymentForm(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return redirect('/')->with('error', 'Invalid payment link.');
        }

        $pending = PendingPayment::where('token', $token)->first();
        if (!$pending) {
            return redirect('/')->with('error', 'Invalid or expired payment link.');
        }

        $movieShow = MovieShow::with(['movie', 'theater', 'screen'])->find($pending->movie_show_id);
        if (!$movieShow) {
            $pending->delete();
            return redirect('/')->with('error', 'Show is not available.');
        }

        $seatIds = json_decode($pending->seat_ids, true);
        $selectedSeatsDetails = Seat::whereIn('id', $seatIds)->get();

        return view('client.payments.create', [
            'pending' => $pending,
            'movieShow' => $movieShow,
            'selectedSeatsDetails' => $selectedSeatsDetails,
            'token' => $token,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|digits_between:13,16',
            'card_holder_name' => 'required|string|max:255',
            'expiration_month' => 'required|integer|min:1|max:12',
            'expiration_year' => 'required|integer|min:' . date('Y') . '|max:' . (date('Y') + 10),
            'cvv' => 'required|string|digits_between:3,4',
            'token' => 'required|string',
            'confirm_payment' => 'required|accepted',
        ]);

        $pending = PendingPayment::where('token', $request->token)->first();
        if (!$pending) {
            return redirect('/')->with('error', 'Invalid or expired payment link.');
        }

        $movieShow = MovieShow::find($pending->movie_show_id);
        if (!$movieShow) {
            $pending->delete();
            return redirect('/')->with('error', 'Show is not available.');
        }

        // Simulate payment gateway response
        $isPaymentSuccessful = false;
        if ($request->card_number === '4111222233334444' && $request->cvv === '123') {
            $isPaymentSuccessful = true;
        }

        if ($isPaymentSuccessful) {
            try {
                DB::beginTransaction();

                $seatIds = json_decode($pending->seat_ids, true);
                // Check if seats are still available
                $currentBookedSeatIds = Ticket::whereHas('booking', function($query) use ($movieShow) {
                    $query->where('movie_show_id', $movieShow->id)
                          ->whereIn('status', ['confirmed']);
                })->pluck('seat_id')->toArray();

                $selectedSeatsStillAvailable = true;
                foreach ($seatIds as $seatId) {
                    if (in_array($seatId, $currentBookedSeatIds)) {
                        $selectedSeatsStillAvailable = false;
                        break;
                    }
                }

                if (!$selectedSeatsStillAvailable) {
                    throw new \Exception('One or more of the selected seats have just been booked. Please try again.');
                }

                $selectedSeats = Seat::whereIn('id', $seatIds)
                                     ->where('screen_id', $movieShow->screen_id)
                                     ->get();

                if ($selectedSeats->count() !== count($seatIds)) {
                    throw new \Exception('One or more seats are invalid or do not belong to this screen.');
                }

                // Create booking
                $booking = Booking::create([
                    'client_id' => Auth::guard('client')->id(),
                    'movie_show_id' => $movieShow->id,
                    'number_of_tickets' => count($seatIds),
                    'total_price' => $pending->total_price,
                    'booking_date' => now(),
                    'status' => 'confirmed',
                    'payment_id' => 'PAY-' . uniqid(),
                ]);

                // Create tickets
                foreach ($selectedSeats as $seat) {
                    $price = $seat->type === 'vip' ? $movieShow->price * 1.2 : $movieShow->price;
                    $booking->tickets()->create([
                        'seat_id' => $seat->id,
                        'price' => $price,
                        'status' => 'confirmed',
                    ]);
                }

                DB::commit();
                $pending->delete(); // Remove pending payment after success

                return redirect()->route('client.bookings.index')
                    ->with('payment_success', 'Payment completed successfully!');

            } catch (\Exception $e) {
                DB::rollBack();
                return back()->withInput()->with('error', 'Payment processing failed: ' . $e->getMessage());
            }
        } else {
            return back()->withInput()->with('error', 'Invalid card details or payment failed.');
        }
    }

    public function create(Request $request)
    {
        $token = $request->query('token');
        $pending = \App\Models\PendingPayment::where('token', $token)->firstOrFail();
        $movieShow = \App\Models\MovieShow::with(['movie', 'theater', 'screen'])
            ->findOrFail($pending->movie_show_id);

        $seatIds = json_decode($pending->seat_ids, true) ?? [];
        $selectedSeatsDetails = \App\Models\Seat::whereIn('id', $seatIds)->get();

        return view('client.payments.create', compact('pending', 'movieShow', 'selectedSeatsDetails', 'token'));
    }
}
