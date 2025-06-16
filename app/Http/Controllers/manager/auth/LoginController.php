<?php

namespace App\Http\Controllers\manager\auth;


use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\ManagerLoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class LoginController extends Controller
{

    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('manager.auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(ManagerLoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        $request->session()->regenerate();

        return redirect()->intended(route('managerdashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('manager')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/manager/login');
    }
}
