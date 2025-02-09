<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use App\Models\User;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();

        // $active_user = User::find(Auth::user()->id);
        // $active_user->is_active = '1';
        // $active_user->id = Auth::id();
        // $active_user->save();

        $request->session()->regenerate();

        // return redirect()->intended(RouteServiceProvider::HOME);

        // Redirect based on the user's role
        $user = $request->user();

        switch ($user->role) {
            case 'Administrator':
                return redirect('admindashboard');
                break;
            case 'Office':
                return redirect('officedashboard');
                break;
            case 'Student':
                return redirect('dashboard');
                break;
        }
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        // $active_user = User::find(Auth::user()->id);
        // $active_user->is_active = '0';
        // $active_user->id = Auth::id();
        // $active_user->save();

        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
