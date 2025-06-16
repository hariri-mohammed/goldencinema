<?php

namespace App\Http\Controllers\manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Movie;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('manager.categories.index', compact('categories'));
    }

    public function create()
    {
        return view('manager.categories.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'category_name' => 'required|max:255',
        ]);

        // التحقق من وجود الفئة مسبقاً
        $existingCategory = Category::where('name', $request->input('category_name'))->first();
        if ($existingCategory) {
            return redirect()->back()->withErrors(['category_name' => 'catogory Name Is Duplicate Please Change It!'])->withInput();
        }

        Category::create(['name' => $request->input('category_name')]);

        return redirect()->back()->with('success', 'creation process was completed successfully');
    }

    public function edit(Category $category)
    {
        return view('manager.categories.edit', compact('category'));
    }

    public function update(Request $request, Category $category)
    {
        $request->validate(['category_name' => 'required|max:255',]);

        // التحقق من وجود الفئة المعدلة مسبقاً
        $existingCategory = Category::where('name', $request->input('category_name'))->first();
        if ($existingCategory && $existingCategory->id != $category->id) {
            return redirect()->back()->withErrors(['category_name' => 'catogory Name Is Duplicate Please Change It!'])->withInput();
        }

        $category->update(['name' => $request->input('category_name')]);

        return redirect()->back()->with('success', 'The Category Edit process was completed successfully');
    }

    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'The deletion process was completed successfully.');
    }

    public function showMovies(Category $category)
    {
        $movies = $category->movies()->with('status')->get(); // Assume Category has a movies relationship
        return view('manager.categories.movies', compact('category', 'movies'));
    }
}
