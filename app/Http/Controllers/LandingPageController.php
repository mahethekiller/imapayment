<?php
namespace App\Http\Controllers;

use App\Models\LandingPage;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function show($slug)
    {
        $lp = LandingPage::where('slug', $slug)->with('discountRules')->firstOrFail();
        return view("landing.$slug", compact('lp'));
    }

    public function register(Request $request, $slug)
    {
        $lp = LandingPage::where('slug', $slug)->with('discountRules')->firstOrFail();

        // Get type from query param (member/guest), default to guest
        $type = $request->query('type', 'guest');

        return view('landing.register', compact('lp', 'type'));
    }

    public function chooseType($slug)
    {
        $lp = LandingPage::where('slug', $slug)->firstOrFail();
        return view('landing.choose-type', compact('lp'));
    }

    public function registerForm(Request $request, $slug)
    {
        $lp = LandingPage::where('slug', $slug)->with('discountRules')->firstOrFail();

        $type = $request->query('type', 'guest'); // member or guest
        return view('landing.register', compact('lp', 'type'));
    }

}
