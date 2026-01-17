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
    /**
     * عرض صفحة اختيار المقاعد لعرض فيلم معين.
     */
    public function create($movie_show_id)
    {
        try {
            $movieShow = MovieShow::with([
                'movie',
                'theater',
                'screen.seats' => fn($query) => $query->orderBy('row')->orderBy('number'),
            ])->findOrFail($movie_show_id);

            // التأكد من أن العرض متاح للحجز
            if ($movieShow->status !== 'active') {
                return back()->with('error', 'This show is not available for booking.');
            }

            // التحقق من تسجيل دخول العميل
            if (!Auth::guard('client')->check()) {
                return redirect()->route('client.login')
                    ->with('error', 'Please login to book tickets.')
                    ->with('redirect_after_login', route('booking.create', $movieShow->id));
            }

            // جلب المقاعد المحجوزة بطريقة مباشرة وأكثر كفاءة
            $bookedSeatIds = Ticket::whereHas('booking', function ($query) use ($movieShow) {
                $query->where('movie_show_id', $movieShow->id)
                      ->where('status', '!=', 'cancelled');
            })->pluck('seat_id')->toArray();

            $seatsByRow = $movieShow->screen->seats->groupBy('row');

            return view('booking', compact('movieShow', 'seatsByRow', 'bookedSeatIds'));
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to load booking page: ' . $e->getMessage());
        }
    }

    /**
     * تخزين الحجز المبدئي وتوجيه المستخدم للدفع.
     */
    public function store(Request $request, MovieShow $movieShow)
    {
        $request->validate(['seats' => 'required|string']);

        try {
            DB::beginTransaction();

            // 1. فك تشفير بيانات المقاعد المُرسلة من المستخدم
            $seatIds = json_decode($request->seats, true);
            if (!is_array($seatIds) || empty($seatIds)) {
                throw new \Exception('Invalid seat selection.');
            }

            // 2. التأكد من أن المقاعد المختارة ليست محجوزة بالفعل (لمنع الحجز المزدوج)
            $alreadyBooked = Ticket::whereIn('seat_id', $seatIds)
                ->whereHas('booking', fn($q) => $q->where('movie_show_id', $movieShow->id)->where('status', '!=', 'cancelled'))
                ->exists();

            if ($alreadyBooked) {
                throw new \Exception('One or more selected seats are no longer available.');
            }

            // 3. التحقق من أن المقاعد تنتمي للشاشة الصحيحة
            $selectedSeats = Seat::whereIn('id', $seatIds)
                ->where('screen_id', $movieShow->screen_id)
                ->get();

            if ($selectedSeats->count() !== count($seatIds)) {
                throw new \Exception('One or more selected seats are invalid.');
            }

            // 4. حساب السعر الإجمالي
            $totalPrice = $selectedSeats->sum(function($seat) use ($movieShow) {
                return $seat->type === 'vip' ? $movieShow->price * 1.2 : $movieShow->price;
            });

            // 5. إنشاء حجز مؤقت في انتظار الدفع
            $token = Str::random(40);
            PendingPayment::create([
                'token' => $token,
                'movie_show_id' => $movieShow->id,
                'seat_ids' => json_encode($seatIds),
                'total_price' => $totalPrice,
            ]);

            DB::commit();

            // 6. توجيه المستخدم لصفحة الدفع
            return redirect()->to('/client/payments/create?token=' . $token);

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Booking failed: ' . $e->getMessage());
        }
    }

    /**
     * عرض تفاصيل حجز مكتمل.
     */
    public function showBooking(Booking $booking)
    {
        if ($booking->client_id !== Auth::guard('client')->id()) {
            abort(403, 'Unauthorized');
        }

        $booking->load(['movieShow.movie', 'movieShow.theater', 'movieShow.screen', 'tickets.seat', 'client']);
        return view('client.bookings.show', compact('booking'));
    }

    /**
     * عرض قائمة بكل حجوزات العميل.
     */
    public function index()
    {
        if (!Auth::guard('client')->check()) {
            return redirect()->route('client.login')->with('error', 'Please login to view your bookings.');
        }

        $bookings = Auth::guard('client')->user()->bookings()
            ->with(['movieShow.movie', 'movieShow.screen'])
            ->latest()
            ->paginate(10);

        return view('client.bookings.index', compact('bookings'));
    }
}
