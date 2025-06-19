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

    public function edit($theaterId, $screenId)
    {
        $screen = Screen::findOrFail($screenId);
        $seatData = [
            'rows' => 0,
            'seats_per_row' => 0,
            'row_start' => 'A',
            'aisle_count' => 0,
            'aisle_start' => [],
            'aisle_width' => []
        ];

        $existingSeats = $screen->seats()->orderBy('row')->orderBy('number')->get();

        if ($existingSeats->isNotEmpty()) {
            $minRowChar = $existingSeats->min('row');
            $maxRowChar = $existingSeats->max('row');
            
            $seatData['row_start'] = $minRowChar;
            $seatData['rows'] = ord($maxRowChar) - ord($minRowChar) + 1;
            
            $seatsInRows = $existingSeats->where('type', '!=', 'aisle')->groupBy('row')->map(function ($rowSeats) {
                return $rowSeats->max('number');
            });
            $seatData['seats_per_row'] = $seatsInRows->max();
            
            $aisles = [];
            $sampleRowSeats = $existingSeats->groupBy('row')->first();
            if ($sampleRowSeats) {
                $currentAisleStart = null;
                $currentAisleWidth = 0;
                foreach ($sampleRowSeats->sortBy('number') as $seat) {
                    if ($seat->type === 'aisle') {
                        if ($currentAisleStart === null) {
                            $currentAisleStart = $seat->number;
                        }
                        $currentAisleWidth++;
                    } else {
                        if ($currentAisleStart !== null) {
                            $aisles[] = ['start' => $currentAisleStart, 'width' => $currentAisleWidth];
                            $currentAisleStart = null;
                            $currentAisleWidth = 0;
                        }
                    }
                }
                if ($currentAisleStart !== null) {
                    $aisles[] = ['start' => $currentAisleStart, 'width' => $currentAisleWidth];
                }
            }
            
            $seatData['aisle_count'] = count($aisles);
            $seatData['aisle_start'] = array_column($aisles, 'start');
            $seatData['aisle_width'] = array_column($aisles, 'width');
        }

        $seat = (object) $seatData;

        return view('manager.seats.edit', compact('screen', 'seat'));
    }

    public function update(Request $request, $theaterId, $screenId)
    {
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
            
            Seat::where('screen_id', $screenId)->delete();

            $rowCount = $request->rows;
            $seatsPerRow = $request->seats_per_row;
            $rowStart = strtoupper($request->row_start);

            $aisles = [];
            for ($i = 0; $i < $request->aisle_count; $i++) {
                if (isset($request->aisle_start[$i]) && isset($request->aisle_width[$i])) {
                    $aisles[] = [
                        'start' => (int)$request->aisle_start[$i],
                        'width' => (int)$request->aisle_width[$i]
                    ];
                }
            }

            usort($aisles, function ($a, $b) {
                return $a['start'] - $b['start'];
            });

            for ($rowIndex = 0; $rowIndex < $rowCount; $rowIndex++) {
                $currentRow = chr(ord($rowStart) + $rowIndex);

                for ($position = 1; $position <= $seatsPerRow; $position++) {
                    $isAisle = false;
                    foreach ($aisles as $aisle) {
                        if ($position >= $aisle['start'] && $position < ($aisle['start'] + $aisle['width'])) {
                            $isAisle = true;
                            break;
                        }
                    }

                    $seatData = [
                        'screen_id' => $screenId,
                        'row' => $currentRow,
                        'number' => $position,
                        'type' => $isAisle ? 'aisle' : 'standard',
                        'status' => $isAisle ? 'inactive' : 'active'
                    ];

                    Seat::create($seatData);
                }
            }

            DB::commit();

            return redirect()
                ->route('manager.theaters.screens.seats.index', [$theaterId, $screenId])
                ->with('success', 'Seats updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            \Log::error('Error updating seats:', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return redirect()
                ->back()
                ->with('error', 'Failed to update seats: ' . $e->getMessage())
                ->withInput();
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

    public function updateSingle(Request $request, $theaterId, $screenId, $seatId)
    {
        $seat = \App\Models\Seat::where('screen_id', $screenId)->where('id', $seatId)->firstOrFail();
        $data = $request->only(['type', 'status']);
        $rules = [];
        if ($request->has('type')) $rules['type'] = 'in:standard,vip,wheelchair,aisle';
        if ($request->has('status')) $rules['status'] = 'in:active,maintenance,inactive';
        $request->validate($rules);

        $seat->update($data);

        return response()->json(['success' => true, 'seat' => $seat]);
    }
}
