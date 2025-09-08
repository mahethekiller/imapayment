@extends('layouts.app')

@section('title', $lp->title)

@section('content')
<div class="container py-5">
    <h1 class="mb-3">{{ $lp->title }}</h1>
    <p class="lead">Welcome to the event landing page. Add any custom HTML here (banner, images, info, etc.).</p>

    <div class="text-center mt-5">
        <a href="{{ route('landing.choose', $lp->slug) }}" class="btn btn-lg btn-primary">
            Register Now
        </a>
    </div>
</div>
@endsection
