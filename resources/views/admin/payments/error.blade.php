@extends('layouts.app')

@section('title', 'Payment Failed')

@section('content')
<div class="container py-5 text-center">
    <h2>Payment Failed</h2>
    <p>{{ $message ?? 'Something went wrong. Please try again.' }}</p>
    <a href="{{ url()->previous() }}" class="btn btn-secondary mt-3">Go Back</a>
</div>
@endsection
