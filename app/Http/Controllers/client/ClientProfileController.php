<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class ClientProfileController extends Controller
{
    public function update(Request $request)
    {
        $client = Auth::guard('client')->user();

        $request->validate([
            'first_name' => ['required', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'username' => ['required', 'string', 'max:255', Rule::unique('clients')->ignore($client->id)],
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('clients')->ignore($client->id)],
            'date_of_birth' => ['required', 'date'],
            'gender' => ['required', 'in:male,female'],
            'phone_number' => ['required', 'string', 'max:20'],
            'current_password' => ['nullable', 'string'],
            'new_password' => ['nullable', 'string', 'min:8', 'confirmed'],
        ]);

        // Update basic information
        $client->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'date_of_birth' => $request->date_of_birth,
            'gender' => $request->gender,
            'phone_number' => $request->phone_number,
        ]);

        // Update password if provided
        if ($request->filled('new_password')) {
            if (!Hash::check($request->current_password, $client->password)) {
                return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
            }
            
            $client->update([
                'password' => Hash::make($request->new_password),
            ]);
        }

        return back()->with('profile_success', 'Profile updated successfully!');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'string'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $client = Auth::guard('client')->user();

        if (!Hash::check($request->current_password, $client->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match your current password.']);
        }

        $client->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password updated successfully!');
    }

    public function destroy(Request $request)
    {
        $request->validate([
            'password' => ['required', 'string'],
        ]);

        $client = Auth::guard('client')->user();

        if (!Hash::check($request->password, $client->password)) {
            return back()->withErrors(['password' => 'The provided password does not match your current password.']);
        }

        Auth::guard('client')->logout();

        $client->delete();

        return redirect('/')->with('success', 'Your account has been deleted successfully.');
    }
}
