<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Seat extends Model
{
    use HasFactory;

    protected $fillable = [
        'screen_id',
        'row',
        'number',
        'type',
        'status'
    ];

    // إضافة القيم المسموح بها لحقل type
    public const TYPES = [
        'standard',
        'vip',
        'wheelchair',
        'aisle'
    ];

    // إضافة القيم المسموح بها لحقل status
    public const STATUSES = [
        'active',
        'maintenance',
        'inactive'
    ];

    public function screen()
    {
        return $this->belongsTo(Screen::class);
    }

    /**
     * Get the tickets for the seat.
     */
    public function tickets(): HasMany
    {
        return $this->hasMany(Ticket::class);
    }

    // للحصول على رقم المقعد كاملاً (مثلاً A1, B2)
    public function getSeatNumberAttribute()
    {
        return $this->row . $this->number;
    }

    // دالة للتحقق ما إذا كان المقعد ممراً
    public function isAisle()
    {
        return $this->type === 'aisle';
    }

    // دالة للتحقق ما إذا كان المقعد قابلاً للحجز
    public function isBookable()
    {
        return !$this->isAisle() && $this->status === 'active';
    }
}
