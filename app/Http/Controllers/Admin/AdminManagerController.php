<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Manager;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminManagerController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $managers = Manager::all();
        return view('admin.managers.index', compact('managers'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.managers.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:managers',
            'email' => 'required|string|email|max:255|unique:managers',
            'password' => 'required|string|min:8|confirmed',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
        ]);

        Manager::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone_number' => $request->phone_number,
            'date_of_birth' => $request->date_of_birth,
        ]);

        return redirect()->route('admin.managers.index')->with('success', 'Manager created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $manager = Manager::findOrFail($id);
        return view('admin.managers.show', compact('manager'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $manager = Manager::findOrFail($id);
        return view('admin.managers.edit', compact('manager'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $manager = Manager::findOrFail($id);

        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => ['required', 'string', 'max:255', Rule::unique('managers')->ignore($manager->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('managers')->ignore($manager->id)],
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
        ]);

        $manager->update($request->all());

        return redirect()->route('admin.managers.index')->with('success', 'Manager updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $manager = Manager::findOrFail($id);
        $manager->delete();

        return redirect()->route('admin.managers.index')->with('success', 'Manager deleted successfully.');
    }
}
