<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Registration;

class RegistrationController extends Controller
{
    public function index()
    {
        $registrations = Registration::with('landingPage','extraMembers')->latest()->paginate(20);
        return view('admin.registrations.index', compact('registrations'));
    }

    public function show(Registration $registration)
    {
        $registration->load('landingPage','extraMembers');
        return view('admin.registrations.show', compact('registration'));
    }
}
