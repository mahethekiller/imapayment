<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;

class PaymentController extends Controller
{
    public function index()
    {
        $payments = Payment::with('registration.landingPage')->latest()->paginate(20);
        return view('admin.payments.index', compact('payments'));
    }

    public function show(Payment $payment)
    {
        $payment->load('registration.landingPage');
        return view('admin.payments.show', compact('payment'));
    }
}
