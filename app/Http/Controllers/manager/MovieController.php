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
        $statuses = Status::all(); //  الحصول على جميع الحالات
        return view('manager.movie.create', compact('categories', 'statuses'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:movies,name',
            'language' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'release_date' => 'required|date',
            'runtime' => 'required|integer|min:0',
            'rating' => 'required|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:6144',
            'stars' => 'required|string',
            'categories' => 'required|array',
            'summary' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
        ]);

        // Prepare the data for the 'movies' table by removing non-column data.
        $movieData = collect($validatedData)->except(['categories', 'image'])->toArray();

        // Handle the image upload. We don't need an 'if' because the validator guarantees the file exists.
        $imageFile = $request->file('image');
        $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
        $imageFile->move(public_path('img/movie'), $imageName);
        
        // Add the generated image name to the data array.
        $movieData['image'] = $imageName;

        // Create the movie with the final, clean data.
        $movie = Movie::create($movieData);

        // Attach the categories separately.
        $movie->categories()->attach($validatedData['categories']);

        return redirect()->route('movie.index')->with('success', 'Movie created successfully.');
    }

    public function show(Movie $movie)
    {
        return view('manager.movie.show', compact('movie'));
    }

    public function edit(Movie $movie)
    {
        $categories = Category::all(); // الحصول على جميع الفئات
        $statuses = Status::all();   // الحصول على جميع الحالات
        return view('manager.movie.edit', compact('movie', 'categories', 'statuses'));
    }

    public function update(Request $request, Movie $movie)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:movies,name,'.$movie->id,
            'language' => 'required|string|max:255',
            'country' => 'required|string|max:255',
            'release_date' => 'required|date',
            'runtime' => 'required|integer|min:0',
            'rating' => 'required|string',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,svg|max:6144',
            'stars' => 'required|string',
            'categories' => 'required|array',
            'summary' => 'required|string',
            'status_id' => 'required|exists:statuses,id',
        ]);

        // Prepare the data for the 'movies' table by removing non-column data.
        $movieData = collect($validatedData)->except(['categories', 'image'])->toArray();

        // Handle optional image upload
        if ($request->hasFile('image')) {
            // Delete old image if it exists
            if ($movie->image && file_exists(public_path('img/movie/' . $movie->image))) {
                unlink(public_path('img/movie/' . $movie->image));
            }

            $imageFile = $request->file('image');
            $imageName = time() . '.' . $imageFile->getClientOriginalExtension();
            $imageFile->move(public_path('img/movie'), $imageName);
            
            // Add the new image name to the data array for updating.
            $movieData['image'] = $imageName;
        }

        // Update the movie with the clean data.
        $movie->update($movieData);

        // Sync the categories separately.
        $movie->categories()->sync($validatedData['categories']);

        return redirect()->route('movie.index')->with('success', 'Movie updated successfully.');
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
