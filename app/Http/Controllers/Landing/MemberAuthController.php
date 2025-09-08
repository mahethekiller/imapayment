<?php

namespace App\Http\Controllers\Landing;

use App\Http\Controllers\Controller;
use App\Models\LandingPage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MemberAuthController extends Controller
{
    public function showLoginForm($slug)
    {
        $lp = LandingPage::where('slug', $slug)->firstOrFail();
        return view('landing.member-login', compact('lp', 'slug'));
    }

    public function login(Request $request, $slug)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        // Only allow users with role 'member'
        if (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password,
        ])) {
            $user = Auth::user();
            if (!$user->hasRole('member')) {
                Auth::logout();
                return redirect()->back()->withErrors(['email' => 'Only members can login here.']);
            }

            $request->session()->regenerate();
            return redirect()->route('landing.register', ['slug' => $slug, 'type' => 'member']);
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
    }
}
