<?php

namespace App\Http\Controllers\Manager;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Manager;

class ManagerProfileController extends Controller
{
    public function show($id)
    {
        $manager = Manager::findOrFail($id);
        return view('manager.manager-profile', compact('manager'));
    }

    public function edit($id)
    {
        $manager = Manager::findOrFail($id);
        return view('manager.edit-manager-profile', compact('manager'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone_number' => 'required|string|max:20',
            'date_of_birth' => 'required|date',
        ]);

        $manager = Manager::findOrFail($id);
        $manager->update($request->all());

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }
}
