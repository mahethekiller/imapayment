@extends('layouts.app')

@section('title', 'Summary - ' . $lp->title)

@section('content')
<div class="container py-5">
    <h1 class="mb-4 text-center">{{ $lp->title }} - Summary</h1>

    <div class="card p-4 mb-4">
        <h4>Personal Details</h4>
        <div class="row g-3">
            <div class="col-md-6"><strong>Name:</strong> {{ $data['name'] ?? '' }}</div>
            <div class="col-md-6"><strong>Email:</strong> {{ $data['email'] ?? '' }}</div>
            <div class="col-md-6"><strong>Mobile:</strong> {{ $data['mobile'] ?? '' }}</div>
            <div class="col-md-6"><strong>Company:</strong> {{ $data['company'] ?? '' }}</div>
            <div class="col-md-6"><strong>Country:</strong> {{ $data['country'] ?? '' }}</div>
            <div class="col-md-6"><strong>City:</strong> {{ $data['city'] ?? '' }}</div>
            <div class="col-md-6"><strong>Address:</strong> {{ $data['address'] ?? '' }}</div>
            <div class="col-md-6"><strong>Company GST:</strong> {{ $data['company_gst'] ?? '' }}</div>
            <div class="col-md-6"><strong>Preferred City:</strong> {{ $data['preferred_city'] ?? '' }}</div>
        </div>
    </div>

    @if(!$lp->can_have_extra_members && !empty($data['extra_members']))
        <div class="card p-4 mb-4">
            <h4>Extra Members</h4>
            <ul class="list-group">
                @foreach($data['extra_members'] as $em)
                    <li class="list-group-item">
                        {{ $em['name'] ?? 'N/A' }} | {{ $em['email'] ?? '' }} | {{ $em['phone'] ?? '' }}
                    </li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Price Summary --}}
    @php
        $basePrice = ($data['type'] ?? 'guest') === 'member' ? $lp->member_price : $lp->non_member_price;
        $extraCount = isset($data['extra_members']) ? count($data['extra_members']) : 0;
        $extraCost = $extraCount * ($lp->extra_member_price ?? 0);
        $gst = ($basePrice + $extraCost) * ($lp->gst_percent / 100);
        $discount = 0;

        // Apply discounts if needed
        if(!empty($lp->discountRules)) {
            foreach($lp->discountRules as $rule) {
                if(!$rule['active']) continue;
                if($rule['type'] === 'flat_percent') {
                    $discount += ($basePrice + $extraCost + $gst) * ($rule['value']/100);
                } elseif($rule['type'] === 'extra_member_threshold' && $extraCount >= ($rule['threshold'] ?? 0)) {
                    $discount += ($basePrice + $extraCost + $gst) * ($rule['value']/100);
                }
            }
        }

        $total = max(0, $basePrice + $extraCost + $gst - $discount);
    @endphp

    <div class="card p-4 mb-4">
        <h4>Price Summary</h4>
        <p>Base Price: ₹{{ number_format($basePrice, 2) }}</p>
        @if(!$lp->can_have_extra_members)
            <p>Extra Members Cost ({{ $extraCount }}): ₹{{ number_format($extraCost, 2) }}</p>
        @endif
        <p>GST ({{ $lp->gst_percent }}%): ₹{{ number_format($gst, 2) }}</p>
        <p>Discount: ₹{{ number_format($discount, 2) }}</p>
        <p><b>Total: ₹{{ number_format($total, 2) }}</b></p>
    </div>

    <form method="POST" action="{{ route('payment.start', $lp->slug) }}">
        @csrf
        @foreach($data as $key => $value)
            @if(is_array($value))
                @foreach($value as $sub)
                    @foreach($sub as $subKey => $subValue)
                        <input type="hidden" name="{{ $key }}[][{{ $subKey }}]" value="{{ $subValue }}">
                    @endforeach
                @endforeach
            @else
                <input type="hidden" name="{{ $key }}" value="{{ $value }}">
            @endif
        @endforeach
        <button type="submit" class="btn btn-success btn-lg w-100">Pay Now</button>
    </form>
</div>
@endsection
