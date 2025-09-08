@php
    $txnid = 'TXN'.time().Str::random(6);
    $amount = number_format($payment->amount, 2, '.', '');
    $productinfo = "Landing: {$landingPage->title}";
    $firstname = $registration->name;
    $email = $registration->email;
    $key = $payu['key'];
    $salt = $payu['salt'];

    // Sequence for hash (PayU standard for redirect):
    $hashString = $key.'|'.$txnid.'|'.$amount.'|'.$productinfo.'|'.$firstname.'|'.$email.'|||||||||||'.$salt;
    $hash = strtolower(hash('sha512', $hashString));
@endphp

<form id="payu_form" method="post" action="{{ $payu['action'] }}">
    <input type="hidden" name="key" value="{{ $key }}"/>
    <input type="hidden" name="txnid" value="{{ $txnid }}"/>
    <input type="hidden" name="amount" value="{{ $amount }}"/>
    <input type="hidden" name="productinfo" value="{{ $productinfo }}"/>
    <input type="hidden" name="firstname" value="{{ $firstname }}"/>
    <input type="hidden" name="email" value="{{ $email }}"/>
    <input type="hidden" name="surl" value="{{ $payu['surl'] }}"/>
    <input type="hidden" name="furl" value="{{ $payu['furl'] }}"/>
    <input type="hidden" name="hash" value="{{ $hash }}"/>
    <input type="hidden" name="udf1" value="{{ $registration->id }}"/>
    <button type="submit">Proceed to Pay</button>
</form>

<script>document.getElementById('payu_form').submit();</script>
