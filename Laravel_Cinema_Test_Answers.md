# إجابات نموذجية - اختبار Laravel 🎯

## الجزء الأول: الأسئلة النظرية

### 1. مفاهيم Laravel الأساسية

#### أ) الفروق:

**`@extends` vs `@include`:**
- `@extends`: يستخدم للـ layout inheritance - صفحة ترث من layout أساسي
- `@include`: يستخدم لتضمين ملف blade في مكان معين

**`Route::get()` vs `Route::post()`:**
- `Route::get()`: للطلبات التي تقرأ البيانات فقط
- `Route::post()`: للطلبات التي ترسل بيانات (نماذج، API)

**`Auth::guard('client')` vs `Auth::guard('admin')`:**
- `Auth::guard('client')`: نظام مصادقة منفصل للعملاء
- `Auth::guard('admin')`: نظام مصادقة منفصل للمديرين

#### ب) الأهداف:

**Middleware:**
- فلترة الطلبات قبل الوصول للـ controller
- التحقق من المصادقة والصلاحيات
- إضافة headers أو تعديل الاستجابة

**Service Provider:**
- تسجيل services في container
- إعداد configurations
- تسجيل bindings

**Eloquent Relationships:**
- ربط الجداول بعلاقات منطقية
- تسهيل استعلام البيانات المرتبطة
- تحسين الأداء عبر eager loading

### 2. قاعدة البيانات

#### أ) العلاقات:

```php
// Movie Model
public function categories()
{
    return $this->belongsToMany(Category::class);
}

public function movieShows()
{
    return $this->hasMany(MovieShow::class);
}

// Booking Model
public function client()
{
    return $this->belongsTo(Client::class);
}

public function movieShow()
{
    return $this->belongsTo(MovieShow::class);
}
```

#### ب) Query Builder:

```php
// الأفلام النشطة مع فئاتها
Movie::with('categories')
    ->where('status', 'active')
    ->get();

// الحجوزات في آخر 7 أيام
Booking::where('created_at', '>=', now()->subDays(7))
    ->with(['client', 'movieShow.movie'])
    ->get();

// المسارح مع أكثر من شاشة
Theater::withCount('screens')
    ->having('screens_count', '>', 1)
    ->get();
```

### 3. الأمان والتحقق

#### أ) الحماية:

**CSRF Protection:**
```php
// في النموذج
@csrf

// في middleware
VerifyCsrfToken::class
```

**Validation:**
```php
// في Request Class
public function rules()
{
    return [
        'email' => 'required|email|unique:clients',
        'password' => 'required|min:8|confirmed'
    ];
}
```

**Access Control:**
```php
// في Routes
Route::middleware(['auth:admin'])->group(function () {
    // admin routes
});

// في Controller
if (!auth()->user()->can('manage_movies')) {
    abort(403);
}
```

#### ب) أفضل الممارسات:

**كلمات المرور:**
```php
// Hashing
Hash::make($password);

// Verification
Hash::check($password, $hashedPassword);
```

**إدارة الجلسات:**
```php
// في config/session.php
'lifetime' => 120, // دقائق
'expire_on_close' => true,
'secure' => true
```

**API Protection:**
```php
// Rate limiting
Route::middleware('throttle:60,1')->group(function () {
    // API routes
});

// API tokens
'guards' => [
    'api' => [
        'driver' => 'sanctum',
    ],
]
```

---

## الجزء الثاني: البرمجة العملية

### 1. ReportController

```php
<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Movie;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;

class ReportController extends Controller
{
    public function dailySales()
    {
        $dailySales = Booking::selectRaw('DATE(created_at) as date, COUNT(*) as bookings, SUM(total_price) as revenue')
            ->where('created_at', '>=', now()->subDays(30))
            ->groupBy('date')
            ->orderBy('date', 'desc')
            ->get();

        return view('admin.reports.daily-sales', compact('dailySales'));
    }

    public function popularMovies()
    {
        $popularMovies = Movie::withCount(['bookings as total_bookings'])
            ->orderBy('total_bookings', 'desc')
            ->limit(10)
            ->get();

        return view('admin.reports.popular-movies', compact('popularMovies'));
    }

    public function exportToExcel()
    {
        $bookings = Booking::with(['client', 'movieShow.movie'])
            ->where('created_at', '>=', now()->subDays(30))
            ->get();

        return Excel::download(new BookingsExport($bookings), 'bookings.xlsx');
    }
}
```

### 2. Migration للـ Reviews

```php
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReviewsTable extends Migration
{
    public function up()
    {
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('movie_id')->constrained()->onDelete('cascade');
            $table->foreignId('client_id')->constrained()->onDelete('cascade');
            $table->integer('rating')->comment('1-5 stars');
            $table->text('comment')->nullable();
            $table->timestamps();
            
            // منع تقييم مزدوج من نفس المستخدم لنفس الفيلم
            $table->unique(['movie_id', 'client_id']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reviews');
    }
}
```

### 3. Models وعلاقاتها

```php
// Movie Model
public function reviews()
{
    return $this->hasMany(Review::class);
}

public function averageRating()
{
    return $this->reviews()->avg('rating');
}

// Review Model
class Review extends Model
{
    protected $fillable = ['movie_id', 'client_id', 'rating', 'comment'];

    public function movie()
    {
        return $this->belongsTo(Movie::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}

// Client Model
public function reviews()
{
    return $this->hasMany(Review::class);
}
```

### 4. Routes

```php
// في routes/admin/admin.php
Route::middleware(['auth:admin'])->group(function () {
    Route::get('/reports/daily-sales', [ReportController::class, 'dailySales'])->name('reports.daily-sales');
    Route::get('/reports/popular-movies', [ReportController::class, 'popularMovies'])->name('reports.popular-movies');
    Route::get('/reports/export', [ReportController::class, 'exportToExcel'])->name('reports.export');
});

// في routes/client/client.php
Route::middleware(['auth:client'])->group(function () {
    Route::post('/movies/{movie}/reviews', [ReviewController::class, 'store'])->name('reviews.store');
    Route::delete('/reviews/{review}', [ReviewController::class, 'destroy'])->name('reviews.destroy');
});
```

### 5. Views

#### أ) صفحة تقرير المبيعات:

```blade
@extends('layouts.admin')

@section('content')
<div class="container mx-auto px-4 py-8">
    <div class="bg-white rounded-lg shadow-lg p-6">
        <h1 class="text-2xl font-bold mb-6">تقرير المبيعات اليومية</h1>
        
        <!-- فلترة التاريخ -->
        <div class="mb-6">
            <form method="GET" class="flex gap-4">
                <input type="date" name="start_date" value="{{ request('start_date') }}" class="border rounded px-3 py-2">
                <input type="date" name="end_date" value="{{ request('end_date') }}" class="border rounded px-3 py-2">
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">فلترة</button>
            </form>
        </div>

        <!-- الرسم البياني -->
        <div class="mb-6">
            <canvas id="salesChart" width="400" height="200"></canvas>
        </div>

        <!-- جدول البيانات -->
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead>
                    <tr>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">التاريخ</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">عدد الحجوزات</th>
                        <th class="px-6 py-3 border-b-2 border-gray-300 text-left">الإيرادات</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($dailySales as $sale)
                    <tr>
                        <td class="px-6 py-4 border-b border-gray-200">{{ $sale->date }}</td>
                        <td class="px-6 py-4 border-b border-gray-200">{{ $sale->bookings }}</td>
                        <td class="px-6 py-4 border-b border-gray-200">${{ number_format($sale->revenue, 2) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- زر التصدير -->
        <div class="mt-6">
            <a href="{{ route('admin.reports.export') }}" class="bg-green-500 text-white px-4 py-2 rounded">
                تصدير إلى Excel
            </a>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx = document.getElementById('salesChart').getContext('2d');
const chart = new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode($dailySales->pluck('date')) !!},
        datasets: [{
            label: 'الإيرادات اليومية',
            data: {!! json_encode($dailySales->pluck('revenue')) !!},
            borderColor: 'rgb(75, 192, 192)',
            tension: 0.1
        }]
    },
    options: {
        responsive: true,
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
@endsection
```

#### ب) نموذج التقييم:

```blade
<div class="bg-white rounded-lg shadow-lg p-6">
    <h3 class="text-lg font-semibold mb-4">أضف تقييمك</h3>
    
    <form action="{{ route('client.reviews.store', $movie) }}" method="POST" id="reviewForm">
        @csrf
        
        <!-- نجوم التقييم -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700 mb-2">التقييم</label>
            <div class="flex gap-2" id="ratingStars">
                @for($i = 1; $i <= 5; $i++)
                <button type="button" class="star-btn text-2xl text-gray-300 hover:text-yellow-400" data-rating="{{ $i }}">
                    ★
                </button>
                @endfor
            </div>
            <input type="hidden" name="rating" id="ratingInput" required>
        </div>

        <!-- التعليق -->
        <div class="mb-4">
            <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">التعليق</label>
            <textarea name="comment" id="comment" rows="4" 
                class="w-full border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-blue-500"
                placeholder="اكتب تعليقك هنا..."></textarea>
        </div>

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            إرسال التقييم
        </button>
    </form>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const stars = document.querySelectorAll('.star-btn');
    const ratingInput = document.getElementById('ratingInput');
    
    stars.forEach(star => {
        star.addEventListener('click', function() {
            const rating = this.dataset.rating;
            ratingInput.value = rating;
            
            // تحديث مظهر النجوم
            stars.forEach((s, index) => {
                if (index < rating) {
                    s.classList.remove('text-gray-300');
                    s.classList.add('text-yellow-400');
                } else {
                    s.classList.remove('text-yellow-400');
                    s.classList.add('text-gray-300');
                }
            });
        });
    });
});
</script>
```

### 6. JavaScript

#### أ) تفاعلية التقييم (مكتمل أعلاه)

#### ب) الرسوم البيانية:

```javascript
// في صفحة التقرير
function createPopularMoviesChart(data) {
    const ctx = document.getElementById('popularMoviesChart').getContext('2d');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: data.labels,
            datasets: [{
                label: 'عدد الحجوزات',
                data: data.values,
                backgroundColor: 'rgba(54, 162, 235, 0.2)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
}

// AJAX لإرسال التقييم
function submitReview(formData) {
    fetch(formData.getAttribute('action'), {
        method: 'POST',
        body: formData,
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            alert('تم إرسال تقييمك بنجاح!');
            location.reload();
        } else {
            alert('حدث خطأ: ' + data.message);
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ في الاتصال');
    });
}
```

### 7. Validation Rules

```php
<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ReviewRequest extends FormRequest
{
    public function authorize()
    {
        return auth()->guard('client')->check();
    }

    public function rules()
    {
        return [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'nullable|string|max:1000'
        ];
    }

    public function messages()
    {
        return [
            'rating.required' => 'يجب اختيار تقييم',
            'rating.between' => 'التقييم يجب أن يكون بين 1 و 5',
            'comment.max' => 'التعليق يجب أن لا يتجاوز 1000 حرف'
        ];
    }
}
```

---

## الجزء الثالث: حل المشاكل

### 1. تحسين الأداء

```php
// Caching
public function getPopularMovies()
{
    return Cache::remember('popular_movies', 3600, function () {
        return Movie::withCount('bookings')
            ->orderBy('bookings_count', 'desc')
            ->limit(10)
            ->get();
    });
}

// Optimize Queries
public function getBookingsWithRelations()
{
    return Booking::with(['client', 'movieShow.movie', 'tickets'])
        ->select('id', 'client_id', 'movie_show_id', 'total_price', 'created_at')
        ->get();
}

// Pagination
public function getBookingsPaginated()
{
    return Booking::with(['client', 'movieShow.movie'])
        ->orderBy('created_at', 'desc')
        ->paginate(20);
}
```

### 2. حل مشكلة الحجز المزدوج

```php
public function store(Request $request)
{
    return DB::transaction(function () use ($request) {
        // التحقق من توفر المقاعد
        $bookedSeats = Booking::where('movie_show_id', $request->movie_show_id)
            ->whereIn('seat_id', $request->seats)
            ->lockForUpdate()
            ->exists();
            
        if ($bookedSeats) {
            throw new Exception('بعض المقاعد محجوزة مسبقاً');
        }
        
        // إنشاء الحجز
        $booking = Booking::create([
            'client_id' => auth()->id(),
            'movie_show_id' => $request->movie_show_id,
            'total_price' => $request->total_price
        ]);
        
        // إنشاء التذاكر
        foreach ($request->seats as $seatId) {
            Ticket::create([
                'booking_id' => $booking->id,
                'seat_id' => $seatId
            ]);
        }
        
        return $booking;
    });
}
```

### 3. تأكيد البريد الإلكتروني

```php
// Email Template
class BookingConfirmation extends Mailable
{
    public function __construct(public Booking $booking)
    {
    }

    public function build()
    {
        return $this->markdown('emails.booking-confirmation')
            ->subject('تأكيد حجز التذاكر')
            ->with([
                'booking' => $this->booking,
                'cancelUrl' => route('client.bookings.cancel', $this->booking)
            ]);
    }
}

// في BookingController
public function store(Request $request)
{
    $booking = // ... إنشاء الحجز
    
    // إرسال البريد الإلكتروني
    Mail::to($booking->client->email)
        ->send(new BookingConfirmation($booking));
        
    return response()->json(['success' => true]);
}
```

---

## نصائح إضافية للتقييم:

1. **راجع الكود** قبل التسليم
2. **اختبر الوظائف** بشكل أساسي
3. **اكتب تعليقات** للكود المعقد
4. **تأكد من الأمان** في جميع النقاط
5. **فكر في الأداء** عند كتابة الاستعلامات

**حظاً موفقاً! 🚀** 