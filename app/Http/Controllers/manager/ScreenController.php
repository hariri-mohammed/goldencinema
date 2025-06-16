<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Screen;
use App\Models\Theater;
use Illuminate\Http\Request;

class ScreenController extends Controller
{
    public function index($theaterId)
    {
        $theater = Theater::findOrFail($theaterId);
        $screens = $theater->screens;
        return view('manager.screens.index', compact('theater', 'screens'));
    }

    public function create($theaterId)
    {
        $theater = Theater::findOrFail($theaterId);
        return view('manager.screens.create', compact('theater'));
    }

    public function store(Request $request, $theaterId)
    {
        $request->validate([
            'screen_name' => 'required|string|max:255',
            'screen_number' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        $theater = Theater::findOrFail($theaterId);
        $theater->screens()->create($request->all());

        return redirect()->route('manager.theaters.screens.index', $theaterId)
            ->with('success', 'Screen added successfully');
    }

    public function edit($theaterId, $screenId)
    {
        $theater = Theater::findOrFail($theaterId);
        $screen = Screen::findOrFail($screenId);
        return view('manager.screens.edit', compact('theater', 'screen'));
    }

    public function update(Request $request, $theaterId, $screenId)
    {
        $request->validate([
            'screen_name' => 'required|string|max:255',
            'screen_number' => 'required|integer|min:1',
            'status' => 'required|in:active,maintenance,inactive',
        ]);

        $screen = Screen::findOrFail($screenId);
        $screen->update($request->all());

        return redirect()->route('manager.theaters.screens.index', $theaterId)
            ->with('success', 'Screen updated successfully');
    }

    public function destroy($theaterId, $screenId)
    {
        $screen = Screen::findOrFail($screenId);

        // التحقق من عدم وجود عروض نشطة
        if ($screen->activeShowsCount > 0) {
            return back()->with('error', 'Cannot delete screen with active shows');
        }

        $screen->delete();

        return redirect()->route('manager.theaters.screens.index', $theaterId)
            ->with('success', 'Screen deleted successfully');
    }
}
