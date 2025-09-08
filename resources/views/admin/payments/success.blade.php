@extends('layouts.app')

@section('title', 'Payment Successful')

@section('content')
<div class="container py-5 text-center">
    <h2>Payment Successful!</h2>
    <p>Thank you, {{ $registration->name }}. Your registration is confirmed.</p>

    @if($pdf)
        <a href="{{ asset('storage/' . $pdf) }}" class="btn btn-primary btn-lg" download>
            Download PDF
        </a>
    @else
        <p>No PDF available for this registration.</p>
    @endif
</div>
@endsection
