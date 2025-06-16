<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClientProfileController extends Controller
{
    public function update(Request $request)
    {
        $user = auth()->guard('client')->user();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('clients')->ignore($user->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('clients')->ignore($user->id)],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'phone_number' => ['required', 'string', 'max:20'],
            'current_password' => ['nullable', 'required_with:new_password', 'current_password:client'],
            'new_password' => ['nullable', 'min:8', 'confirmed'],
        ]);

        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->username = $request->username;
        $user->email = $request->email;
        $user->date_of_birth = $request->date_of_birth;
        $user->gender = $request->gender;
        $user->phone_number = $request->phone_number;

        if ($request->filled('new_password')) {
            $user->password = Hash::make($request->new_password);
        }

        $user->save();

        return back()->with('success', 'Profile updated successfully.');
    }
} 