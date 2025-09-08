@extends('layouts.app')
@section('title', $lp->title)

@section('content')
<div class="container py-2 text-center">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">I am a Member</h5>
                    <p class="card-text">Please login to register</p>
                    <a href="{{ route('landing.member.login', ['slug' => $lp->slug]) }}"
                       class="btn btn-primary">Login</a>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    <h5 class="card-title">I am a Guest</h5>
                    <p class="card-text">Please fill out the registration form</p>
                    <a href="{{ route('landing.register', ['slug' => $lp->slug, 'type' => 'guest']) }}"
                       class="btn btn-secondary">Register</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
