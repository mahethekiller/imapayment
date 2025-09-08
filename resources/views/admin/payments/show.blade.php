@extends('adminlte::page')

@section('title','Payment Detail')

@section('content_header')
    <h1>Payment #{{ $payment->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <p><strong>Registration:</strong> {{ $payment->registration->name ?? '-' }}</p>
        <p><strong>Landing Page:</strong> {{ $payment->registration->landingPage->title ?? '-' }}</p>
        <p><strong>Amount:</strong> {{ $payment->amount }}</p>
        <p><strong>Status:</strong> {{ ucfirst($payment->status) }}</p>
        <p><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
        <p><strong>Gateway Response:</strong> {{ $payment->gateway_response }}</p>
        <p><strong>Date:</strong> {{ $payment->created_at->format('d M Y H:i') }}</p>
    </div>
</div>
@stop
