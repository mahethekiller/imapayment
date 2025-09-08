@extends('layouts.app')

@section('title', $lp->title . 'Payment Failed')

@section('content')
<div class="container ">
    <div class="card text-center">
        <div class="card-header">
            <h2>Payment Failed</h2>
        </div>
        <div class="card-body">
            <p>Payment failed for registration.</p>
        </div>
    </div>
</div>
@endsection
