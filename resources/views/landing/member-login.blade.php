@extends('layouts.app')

@section('title', $lp->title . 'Member Login')

@section('content')
<div class="container py-2">
    <div class="d-flex justify-content-center">
        <div class="card p-4" style="max-width: 600px; width: 600px;">
            <h2 class="card-title text-center">Member Login</h2>
            <p class="card-text text-center">Only registered members can login here.</p>
            <p class="card-text text-center">If not a member, you can continue as a <a href="{{ route('landing.register', ['slug' => $lp->slug, 'type' => 'guest']) }}">non-member</a>.</p>

            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul class="list-unstyled">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form method="POST" action="{{ route('landing.member.login.post', $slug) }}">
                @csrf

                <div class="form-group mb-3">
                    <label class="form-label" for="email">Email</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    @error('email')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="form-group mb-3">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    @error('password')<small class="text-danger">{{ $message }}</small>@enderror
                </div>

                <div class="d-grid gap-2">
                    <button type="submit" class="btn btn-primary">Login</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
