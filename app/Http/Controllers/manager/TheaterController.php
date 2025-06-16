<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Theater;
use Illuminate\Http\Request;

class TheaterController extends Controller
{
    public function index()
    {
        $theaters = Theater::all();
        return view('manager.theaters.index', compact('theaters'));
    }

    public function create()
    {
        return view('manager.theaters.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        Theater::create($request->all());

        return redirect()->route('manager.theaters.index')
            ->with('success', 'Theater added successfully');
    }

    public function edit($id)
    {
        $theater = Theater::findOrFail($id);
        return view('manager.theaters.edit', compact('theater'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'location' => 'required|string|max:255',
            'city' => 'required|string|max:255',
        ]);

        $theater = Theater::findOrFail($id);
        $theater->update($request->all());

        return redirect()->route('manager.theaters.index')
            ->with('success', 'Theater updated successfully');
    }

    public function destroy($id)
    {
        $theater = Theater::findOrFail($id);
        $theater->delete();

        return redirect()->route('manager.theaters.index')
            ->with('success', 'Theater deleted successfully');
    }
}
