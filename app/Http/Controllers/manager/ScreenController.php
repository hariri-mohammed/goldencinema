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
        $screen = Screen::withCount('movieShows')->findOrFail($screenId);

        // أولاً، تحقق من وجود أي عروض مستقبلية. هذا يمنع أي إجراء.
        $hasFutureShows = $screen->movieShows()->where('show_time', '>=', now())->exists();
        if ($hasFutureShows) {
            return back()->with('error', 'Cannot delete or deactivate this screen as it has upcoming shows. Please handle these shows first.');
        }

        // إذا كانت الشاشة لها سجل عروض (سابقة فقط)، قم بتعطيلها بدلاً من حذفها.
        if ($screen->movie_shows_count > 0) {
            $screen->update(['status' => 'inactive']);
            return redirect()->route('manager.theaters.screens.index', $theaterId)
                ->with('success', 'Screen has been DEACTIVATED instead of deleted because it has a history of past shows.');
        }

        // إذا وصلت الشفرة إلى هنا، فهذا يعني أن الشاشة لم تُستخدم أبدًا. الحذف هنا آمن.
        $screen->delete();

        return redirect()->route('manager.theaters.screens.index', $theaterId)
            ->with('success', 'Screen deleted successfully as it was never used.');
    }
}
