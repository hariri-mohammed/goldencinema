<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Trailer;
use Illuminate\Http\Request;

class TrailerController extends Controller
{
    public function index()
    {
        $movies = Movie::with('trailer')->get();
        return view('manager.trailers.index', compact('movies'));
    }

    public function create($movie_id)
    {
        $movie = Movie::findOrFail($movie_id);
        return view('manager.trailers.create', compact('movie'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'url' => 'required|url',
            'movie_id' => 'required|exists:movies,id'
        ]);

        Trailer::create($request->all());

        return redirect()->route('manager.trailers.index')
            ->with('success', 'تم إضافة التريلر بنجاح');
    }

    public function edit($id)
    {
        $trailer = Trailer::findOrFail($id);
        return view('manager.trailers.edit', compact('trailer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'url' => 'required|url'
        ]);

        $trailer = Trailer::findOrFail($id);
        $trailer->update($request->all());

        return redirect()->route('manager.trailers.index')
            ->with('success', 'تم تحديث التريلر بنجاح');
    }

    public function destroy($id)
    {
        $trailer = Trailer::findOrFail($id);
        $trailer->delete();

        return redirect()->route('manager.trailers.index')
            ->with('success', 'تم حذف التريلر بنجاح');
    }
}
