<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use App\Models\Movie;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Status;


class MovieController extends Controller
{
    public function index()
    {
        $movies = Movie::with('status')->get();
        return view('manager.movie.index', compact('movies'));
    }


    public function create()
    {
        $categories = Category::all(); // الحصول على جميع الفئات
        return view('manager.movie.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'release_date' => 'required|date',
            'runtime' => 'required|integer|min:0',
            'rating' => 'required|numeric|min:0|max:10',
            'img' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6144',
            'stars' => 'required|string',
            'categories' => 'required|array',
            'summary' => 'required|string',
        ]);

        // التحقق من وجود الفيلم مسبقاً
        $existingMovie = Movie::where('name', $request->input('name'))->first();
        if ($existingMovie) {
            return redirect()->back()->withErrors(['name' => 'Movie Name is Duplicate. Please Change It!'])->withInput();
        }

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $validatedData['img'] = file_get_contents($image->getRealPath());
        }

        $movie = Movie::create($request->except('img') + ['img' => $validatedData['img'] ?? null]);

        // حفظ الفئات المرتبطة بالفيلم
        $categories = $request->input('categories');
        $movie->categories()->attach($categories);

        return redirect()->back()->with('success', 'The Movie creation process was completed successfully.');
    }

    public function show(Movie $movie)
    {
        return view('manager.movie.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        $categories = Category::all(); // الحصول على جميع الفئات
        return view('manager.movie.edit', compact('movie', 'categories'));
    }

    public function update(Request $request, Movie $movie)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'language' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'release_date' => 'required|date',
            'runtime' => 'required|integer|min:0',
            'rating' => 'required|numeric|min:0|max:10',
            'img' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:6144',
            'stars' => 'required|string',
            'categories' => 'required|array',
            'summary' => 'required|string',
        ]);

        // التحقق من وجود الفيلم المعدل مسبقاً
        $existingMovie = Movie::where('name', $request->input('name'))->first();
        if ($existingMovie && $existingMovie->id != $movie->id) {
            return redirect()->back()->withErrors(['name' => 'Movie Name is Duplicate. Please Change It!'])->withInput();
        }

        if ($request->hasFile('img')) {
            $image = $request->file('img');
            $validatedData['img'] = file_get_contents($image->getRealPath());
        }

        $movie->update($request->except('img') + ['img' => $validatedData['img'] ?? $movie->img]);

        // تحديث الفئات المرتبطة بالفيلم
        $categories = $request->input('categories');
        $movie->categories()->sync($categories);

        return redirect()->back()->with('success', 'The Movie update process was completed successfully.');
    }

    public function destroy(Movie $movie)
    {
        $movie->delete();
        return redirect()->route('movie.index')->with('success', 'The Movie was deleted successfully.');
    }

    public function statuses()
    {
        $movies = Movie::with('status')->get();
        return view('manager.movie.statuses', compact('movies'));
    }

    public function editStatus(Movie $movie)
    {
        $statuses = Status::all(); // جلب جميع الحالات
        return view('manager.movie.edit-status', compact('movie', 'statuses'));
    }

    public function updateStatus(Request $request, Movie $movie)
    {
        $request->validate([
            'status_id' => 'required|exists:statuses,id',
        ]);

        $movie->status_id = $request->status_id;
        $movie->save();

        return redirect()->route('manager.movie.statuses')->with('success', 'Status updated successfully.');
    }
}
