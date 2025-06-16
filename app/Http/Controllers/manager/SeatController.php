<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use App\Models\Seat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class SeatController extends Controller
{
    public function index($theaterId, $screenId)
    {
        $screen = Screen::findOrFail($screenId);
        $seats = $screen->seats()->orderBy('row')->orderBy('number')->get();
        return view('manager.seats.index', compact('screen', 'seats'));
    }

    public function create($theaterId, $screenId)
    {
        $screen = Screen::findOrFail($screenId);
        return view('manager.seats.create', compact('screen'));
    }

    public function store(Request $request, $theaterId, $screenId)
    {
        \Log::info('Received request data:', $request->all());

        $request->validate([
            'rows' => 'required|integer|min:1',
            'seats_per_row' => 'required|integer|min:1',
            'row_start' => 'required|string|size:1|regex:/^[A-Za-z]$/',
            'aisle_count' => 'required|integer|min:0',
            'aisle_start' => 'array',
            'aisle_width' => 'array',
            'aisle_start.*' => 'required_with:aisle_count|integer|min:1',
            'aisle_width.*' => 'required_with:aisle_count|integer|min:1'
        ]);

        try {
            DB::beginTransaction();

            $screen = Screen::findOrFail($screenId);
            $rowCount = $request->rows;
            $seatsPerRow = $request->seats_per_row;
            $rowStart = strtoupper($request->row_start);

            // Get aisle configurations
            $aisles = [];
            for ($i = 0; $i < $request->aisle_count; $i++) {
                if (isset($request->aisle_start[$i]) && isset($request->aisle_width[$i])) {
                    $aisles[] = [
                        'start' => (int)$request->aisle_start[$i],
                        'width' => (int)$request->aisle_width[$i]
                    ];
                }
            }

            // Sort aisles by start position
            usort($aisles, function ($a, $b) {
                return $a['start'] - $b['start'];
            });

            // Create seats for each row
            for ($rowIndex = 0; $rowIndex < $rowCount; $rowIndex++) {
                $currentRow = chr(ord($rowStart) + $rowIndex);

                for ($position = 1; $position <= $seatsPerRow; $position++) {
                    // Check if current position is an aisle
                    $isAisle = false;
                    foreach ($aisles as $aisle) {
                        if ($position >= $aisle['start'] && $position < ($aisle['start'] + $aisle['width'])) {
                            $isAisle = true;
                            break;
                        }
                    }

                    // Create seat or aisle
                    $seatData = [
                        'screen_id' => $screenId,
                        'row' => $currentRow,
                        'number' => $position,
                        'type' => $isAisle ? 'aisle' : 'standard',
                        'status' => $isAisle ? 'inactive' : 'active'
                    ];

                    \Log::info('Creating seat/aisle:', $seatData);
                    Seat::create($seatData);
                }
            }

            DB::commit();
            \Log::info('Successfully created all seats and aisles');

            return response()->json([
                'success' => true,
                'message' => 'Seats and aisles generated successfully',
                'redirect' => route('manager.theaters.screens.seats.index', [$theaterId, $screenId])
            ]);
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error creating seats:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Failed to generate seats: ' . $e->getMessage()
            ], 500);
        }
    }

    public function edit($theaterId, $screenId, $seatId)
    {
        $seat = Seat::findOrFail($seatId);
        return view('manager.seats.edit', compact('seat'));
    }

    public function update(Request $request, $theaterId, $screenId, $seatId)
    {
        $request->validate([
            'type' => 'sometimes|required|in:standard,vip,wheelchair',
            'status' => 'sometimes|required|in:active,maintenance,inactive',
        ]);

        try {
            $seat = Seat::findOrFail($seatId);
            $updates = [];

            if ($request->has('type')) {
                $updates['type'] = $request->type;
            }

            if ($request->has('status')) {
                $updates['status'] = $request->status;
            }

            $seat->update($updates);

            return response()->json([
                'success' => true,
                'message' => 'Seat updated successfully'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Failed to update seat'
            ], 500);
        }
    }

    public function bulkUpdate(Request $request, $theaterId, $screenId)
    {
        $request->validate([
            'seats' => 'required|array',
            'seats.*.id' => 'required|exists:seats,id',
            'seats.*.type' => 'required|in:standard,vip,wheelchair',
            'seats.*.status' => 'required|in:active,maintenance,inactive',
        ]);

        foreach ($request->seats as $seatData) {
            Seat::where('id', $seatData['id'])->update([
                'type' => $seatData['type'],
                'status' => $seatData['status']
            ]);
        }

        return response()->json(['message' => 'Seats updated successfully']);
    }

    public function deleteAll($theaterId, $screenId)
    {
        try {
            DB::beginTransaction();

            // التحقق من وجود الشاشة
            $screen = Screen::findOrFail($screenId);

            // التحقق من وجود حجوزات مرتبطة بالمقاعد
            $hasBookings = DB::table('booking_seats')
                ->join('seats', 'booking_seats.seat_id', '=', 'seats.id')
                ->where('seats.screen_id', $screenId)
                ->exists();

            if ($hasBookings) {
                return redirect()
                    ->back()
                    ->with('error', 'Cannot delete seats. There are existing bookings associated with these seats.');
            }

            // حذف جميع المقاعد المرتبطة بالشاشة
            $deletedCount = Seat::where('screen_id', $screenId)->delete();

            DB::commit();

            return redirect()
                ->route('manager.theaters.screens.seats.index', [$theaterId, $screenId])
                ->with('success', "Successfully deleted {$deletedCount} seats.");
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error deleting seats: ' . $e->getMessage());

            return redirect()
                ->back()
                ->with('error', 'Failed to delete seats. ' . $e->getMessage());
        }
    }
}
