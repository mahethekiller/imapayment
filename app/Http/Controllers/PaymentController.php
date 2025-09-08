<?php
namespace App\Http\Controllers;

use App\Models\LandingPage;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function start(Request $request, $slug)
{
    $lp = LandingPage::where('slug', $slug)->firstOrFail();

    // Determine if member
    $isMember = auth()->check() && $request->type === 'member';

    // Save registration info
    $registration = Registration::create([
        'landing_page_id' => $lp->id,
        'name'            => $request->name,
        'email'           => $request->email,
        'mobile'          => $request->mobile ?? null,
        'company'         => $request->company ?? null,
        'city'            => $request->city ?? null,
        'country'         => $request->country ?? null,
        'gst_number'      => $request->company_gst ?? null,
        'status'          => 'pending',
    ]);

    // Extra members (if any)
    $extraMembers = $request->input('extra_members', []);
    foreach ($extraMembers as $em) {
        $registration->extraMembers()->create($em);
    }

    // Base amount
    $amount = $isMember ? $lp->member_price : $lp->non_member_price;

    // Add extra members cost if workshop_mode is false
    if (!$lp->workshop_mode && count($extraMembers) > 0) {
        $extraCostPerMember = $lp->extra_member_price ?? 0; // you can define this field in landing_pages table
        $amount += count($extraMembers) * $extraCostPerMember;
    }

    // Apply discount rules
    $discount = 0;
    foreach ($lp->discountRules as $rule) {
        if (!$rule['active']) continue;

        if ($rule['type'] === 'flat_percent') {
            $discount += $amount * ($rule['value'] / 100);
        } elseif ($rule['type'] === 'extra_member_threshold' && count($extraMembers) >= ($rule['threshold'] ?? 0)) {
            $discount += $amount * ($rule['value'] / 100);
        }
    }
    $amount = max(0, $amount - $discount);

    // Apply GST
    $amount += $amount * ($lp->gst_percent / 100);

    // Store payment record
    $payment = Payment::create([
        'registration_id' => $registration->id,
        'amount'          => $amount,
        'status'          => 'pending',
        'gateway'         => 'payu',
    ]);

    // Prepare PayU data
    $payuData = [
        'key'         => env('PAYU_KEY'),
        'txnid'       => $payment->id,
        'amount'      => $amount,
        'productinfo' => $lp->title,
        'firstname'   => $registration->name,
        'email'       => $registration->email,
        'phone'       => $registration->mobile,
        'surl'        => route('payment.callback'),
        'furl'        => route('payment.callback'),
    ];

    $hashString = env('PAYU_KEY') . '|' . $payuData['txnid'] . '|' . $payuData['amount'] . '|' . $payuData['productinfo'] . '|' . $payuData['firstname'] . '|' . $payuData['email'] . '|||||||||||' . env('PAYU_SALT');
    $payuData['hash'] = strtolower(hash('sha512', $hashString));

    return view('payment.redirect', compact('payuData'));
}


    public function callback(Request $request)
    {
        $payment = Payment::find($request->txnid);

        // dd($request->all());

        if (! $payment) {
            return view('payment.fail', ['message' => 'Payment not found.']);
        }

        if ($request->status === 'success') {
            $payment->update(['status' => 'success',]);
            $payment->registration->update(['status' => 'success']);

            $pdf = $payment->registration->landingPage->pdf_path ?? null;

            return view('payment.success', [
                'registration' => $payment->registration,
                'pdf'          => $pdf,
                'lp' => $payment->registration->landingPage,
            ]);
        } else {
            $payment->update(['status' => 'failed']);
            $payment->registration->update(['status' => 'failed']);

            return view('payment.error', [
                'message' => 'Payment failed. Please try again.',
                'lp' => $payment->registration->landingPage,
            ]);
        }
    }

}
