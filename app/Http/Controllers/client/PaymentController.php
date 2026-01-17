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
    /**
     * عرض صفحة الدفع بناءً على حجز مؤقت.
     */
    public function create(Request $request)
    {
        $token = $request->query('token');
        if (!$token) {
            return redirect('/')->with('error', 'Invalid payment link.');
        }

        $pending = PendingPayment::where('token', $token)->first();
        if (!$pending) {
            return redirect('/')->with('error', 'Invalid or expired payment session.');
        }

        $movieShow = MovieShow::with(['movie', 'theater', 'screen'])->find($pending->movie_show_id);
        if (!$movieShow) {
            $pending->delete(); // تنظيف الجلسة المؤقتة
            return redirect('/')->with('error', 'This movie show is no longer available.');
        }

        $seatIds = json_decode($pending->seat_ids, true) ?? [];
        $selectedSeatsDetails = Seat::whereIn('id', $seatIds)->get();

        return view('client.payments.create', compact('pending', 'movieShow', 'selectedSeatsDetails', 'token'));
    }

    /**
     * معالجة الدفع وإنشاء الحجز النهائي.
     */
    public function store(Request $request)
    {
        $this->validatePaymentRequest($request);

        $pending = PendingPayment::where('token', $request->token)->first();
        if (!$pending) {
            return redirect('/')->with('error', 'Your payment session has expired. Please try again.');
        }

        // 1. محاكاة عملية الدفع (في مشروع حقيقي، سيتم استدعاء بوابة الدفع هنا)
        if (!$this->isPaymentSuccessful($request)) {
            return back()->withInput()->with('error', 'Invalid card details or payment failed.');
        }

        try {
            DB::beginTransaction();

            $movieShow = MovieShow::findOrFail($pending->movie_show_id);
            $seatIds = json_decode($pending->seat_ids, true);

            // 2. التحقق من أن المقاعد لم تُحجز بواسطة شخص آخر أثناء عملية الدفع
            $alreadyBooked = Ticket::whereIn('seat_id', $seatIds)
                ->whereHas('booking', fn($q) => $q->where('movie_show_id', $movieShow->id)->where('status', 'confirmed'))
                ->exists();

            if ($alreadyBooked) {
                throw new \Exception('One or more selected seats have just been booked. Please try again.');
            }

            // 3. إنشاء الحجز الرئيسي
            $booking = Booking::create([
                'client_id' => Auth::guard('client')->id(),
                'movie_show_id' => $movieShow->id,
                'number_of_tickets' => count($seatIds),
                'total_price' => $pending->total_price,
                'booking_date' => now(),
                'status' => 'confirmed',
                'payment_id' => 'PAY-' . uniqid(), // معرف وهمي لعملية الدفع
            ]);

            // 4. إنشاء تذكرة لكل مقعد
            $ticketsData = [];
            $selectedSeats = Seat::whereIn('id', $seatIds)->get();
            foreach ($selectedSeats as $seat) {
                $ticketsData[] = [
                    'booking_id' => $booking->id,
                    'seat_id' => $seat->id,
                    'price' => $seat->type === 'vip' ? $movieShow->price * 1.2 : $movieShow->price,
                    'status' => 'confirmed',
                    'created_at' => now(),
                    'updated_at' => now(),
                ];
            }
            Ticket::insert($ticketsData);

            // 5. حذف الحجز المؤقت وإتمام العملية
            $pending->delete();
            DB::commit();

            return redirect()->route('client.bookings.index')
                ->with('success', 'Payment completed successfully! Your booking is confirmed.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()->with('error', 'Payment processing failed: ' . $e->getMessage());
        }
    }

    /**
     * التحقق من صحة بيانات بطاقة الدفع.
     */
    private function validatePaymentRequest(Request $request)
    {
        $request->validate([
            'card_number' => 'required|string|digits_between:13,16',
            'card_holder_name' => 'required|string|max:255',
            'expiration_month' => 'required|integer|min:1|max:12',
            'expiration_year' => 'required|integer|min:' . date('Y') . '|max:' . (date('Y') + 10),
            'cvv' => 'required|string|digits_between:3,4',
            'token' => 'required|string|exists:pending_payments,token',
            'confirm_payment' => 'required|accepted',
        ]);
    }


    private function isPaymentSuccessful(Request $request): bool
    {
        // هذه بطاقة وهمية للنجاح
        return $request->card_number === '4111222233334444' && $request->cvv === '123';
    }
}
