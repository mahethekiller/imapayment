<?php
namespace App\Http\Controllers;

use App\Models\ExtraMember;
use App\Models\LandingPage;
use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RegistrationsExport;

class RegistrationController extends Controller
{
    public function store(Request $request, $slug)
    {
        $lp = LandingPage::where('slug', $slug)->with('discountRules')->firstOrFail();

        $validated = $request->validate([
            'name'                 => 'required|string|max:255',
            'email'                => 'required|email',
            'mobile'               => 'nullable|string',
            'company'              => 'nullable|string',
            'country'              => 'nullable|string',
            'city'                 => 'nullable|string',
            'address'              => 'nullable|string',
            'company_gst'          => 'nullable|string',
            'preferred_city'       => 'nullable|string',
            'extra_members'        => 'array',
            'extra_members.*.name' => 'required_with:extra_members|string',
            'type'                 => 'required|in:member,guest', // member=logged in, guest=non-member
        ]);

        $isMember     = $validated['type'] === 'member' && auth()->check();
        $extraMembers = $validated['extra_members'] ?? [];

        $calc = $this->calculate($lp, $isMember, count($extraMembers), $lp->discountRules);

        // save registration
        $reg = Registration::create([
            'landing_page_id'     => $lp->id,
            'user_id'             => $isMember ? auth()->id() : null,
            'name'                => $validated['name'],
            'email'               => $validated['email'],
            'login_email'         => $isMember ? auth()->user()->email : null,
            'mobile'              => $validated['mobile'] ?? null,
            'company'             => $validated['company'] ?? null,
            'country'             => $validated['country'] ?? null,
            'city'                => $validated['city'] ?? null,
            'address'             => $validated['address'] ?? null,
            'company_gst'         => $validated['company_gst'] ?? null,
            'preferred_city'      => $validated['preferred_city'] ?? null,
            'extra_members_count' => count($extraMembers),
            'base_amount'         => $calc['base'],
            'gst_amount'          => $calc['gst'],
            'discount_amount'     => $calc['discount'],
            'final_amount'        => $calc['final'],
            'status'              => 'pending',
            'meta'                => [],
        ]);

        // store extra members
        foreach ($extraMembers as $em) {
            ExtraMember::create([
                'registration_id' => $reg->id,
                'name'            => $em['name'],
                'email'           => $em['email'] ?? null,
                'phone'           => $em['phone'] ?? null,
            ]);
        }

        // create payment record (pending)
        $payment = Payment::create([
            'registration_id' => $reg->id,
            'provider'        => 'payu',
            'amount'          => $calc['final'],
            'status'          => 'pending',
        ]);

        $reg->update(['payment_id' => $payment->id]);

        // Redirect to PayU (we'll return a view that auto-posts to PayU with hash)
        return view('payments.payu-redirect', [
            'registration' => $reg,
            'payment'      => $payment,
            'landingPage'  => $lp,
            'payu'         => [
                'key'    => config('services.payu.key'),
                'salt'   => config('services.payu.salt'),
                'action' => config('services.payu.endpoint'), // sandbox/live
                'surl'   => route('payment.payu.callback'),
                'furl'   => route('payment.payu.callback'),
            ],
        ]);
    }

    public static function calculate(LandingPage $landingPage, bool $isMember, int $extraMembersCount, Collection $discountRules)
    {
        $base = $isMember ? $landingPage->member_price : $landingPage->non_member_price;

        // If extra members are charged per extra? (Assumption: base price is per registration; extra members use same base or zero)
        // For simplicity we assume base is per registration and extra members are included as 'extra_count' fee = 0 by default.
        // You can extend to charge per extra member.

        $gstAmount           = round($base * ($landingPage->gst_percent / 100), 2);
        $totalBeforeDiscount = $base + $gstAmount;

        // Apply discount rules (we check for active rules)
        $discountAmount = 0;
        foreach ($discountRules as $rule) {
            if (! $rule->active) {
                continue;
            }

            if ($rule->type === 'flat_percent') {
                $discountAmount += round($totalBeforeDiscount * ($rule->value / 100), 2);
            } elseif ($rule->type === 'extra_member_threshold' && $extraMembersCount > ($rule->threshold ?? 0)) {
                $discountAmount += round($totalBeforeDiscount * ($rule->value / 100), 2);
            }
        }
        $final = max(0, $totalBeforeDiscount - $discountAmount);
        return [
            'base'     => $base,
            'gst'      => $gstAmount,
            'discount' => $discountAmount,
            'final'    => round($final, 2),
        ];
    }

    public function export($landingPageId)
    {
        return \Maatwebsite\Excel\Excel::download(new RegistrationsExport($landingPageId), 'registrations.xlsx');
    }

    public function summary(Request $request, $slug)
    {
        $lp = LandingPage::where('slug', $slug)->firstOrFail();
        $validated = $request->validate([
            'name'                        => 'required|string|max:255',
            'email'                       => 'required|email',
            'mobile'                      => 'required|digits_between:10,12',
            'company'                     => 'nullable|string|max:255',
            'country'                     => 'required|string|max:100',
            'city'                        => 'required|string|max:100',
            'address'                     => 'required|string|max:500',
            'company_gst'                 => 'nullable|string|max:50',
            'preferred_city'              => 'nullable|string|max:100',

            // If extra members are added
            'extra_members'               => 'nullable|array',
            'extra_members.*.name'        => 'required_with:extra_members|string|max:255',
            'extra_members.*.email'       => 'required_with:extra_members|email',
            'extra_members.*.designation' => 'nullable|string|max:100',
        ]);

        // Get old input or session data from previous form
        $data = $request->session()->get('registration_data', $request->all());

        return view('landing.summary', compact('lp', 'data'));
    }

    public function startPayment(Request $request, $slug)
    {
        // Here you can handle saving registration & extra members, then redirect to payment gateway
    }

}
