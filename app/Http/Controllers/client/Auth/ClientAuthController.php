<?php

namespace App\Http\Controllers\Client\auth;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class ClientAuthController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::guard('client')->attempt($credentials)) {
            return redirect()->intended(route('movies.index'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout()
    {
        Auth::guard('client')->logout();
        return redirect()->intended(route('movies.index'));
    }

    public function showRegisterForm()
    {
        return view('auth.client_register');
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:clients',
            'email' => 'required|string|email|max:255|unique:clients',
            'password' => 'required|string|min:8|confirmed',
            'date_of_birth' => 'required|date',
            'gender' => 'required|string|in:male,female',
            'phone_number' => 'nullable|string|max:20',
            'terms' => 'required|accepted',
        ], [
            'terms.required' => 'You must accept the Terms of Service and Privacy Policy.',
            'terms.accepted' => 'You must accept the Terms of Service and Privacy Policy.',
            'gender.in' => 'Please select a valid gender.',
        ]);

        if ($validator->fails()) {
            return back()->withErrors($validator)->withInput();
        }

        try {
            $client = new Client();
            $client->first_name = $request->first_name;
            $client->last_name = $request->last_name;
            $client->username = $request->username;
            $client->email = $request->email;
            $client->password = Hash::make($request->password);
            $client->date_of_birth = $request->date_of_birth;
            $client->gender = $request->gender;
            $client->phone_number = $request->phone_number;
            $client->save();

            Auth::guard('client')->login($client);

            return redirect()->intended(route('movies.index'));
        } catch (\Exception $e) {
            return back()->withErrors(['message' => 'Registration failed. Please try again.'])->withInput();
        }
    }
}
