@extends('adminlte::page')

@section('title','Registration Detail')

@section('content_header')
    <h1>Registration #{{ $registration->id }}</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <h5>Basic Info</h5>
        <p><strong>Name:</strong> {{ $registration->name }}</p>
        <p><strong>Email:</strong> {{ $registration->email }}</p>
        <p><strong>Company:</strong> {{ $registration->company }}</p>
        <p><strong>City:</strong> {{ $registration->city }}</p>
        <p><strong>Country:</strong> {{ $registration->country }}</p>
        <p><strong>Address:</strong> {{ $registration->address }}</p>
        <p><strong>Company GST:</strong> {{ $registration->company_gst }}</p>
        <p><strong>Preferred City:</strong> {{ $registration->preferred_city }}</p>
        <p><strong>Landing Page:</strong> {{ $registration->landingPage->title ?? '-' }}</p>

        <hr>
        <h5>Extra Members</h5>
        @if($registration->extraMembers->count())
            <ul>
            @foreach($registration->extraMembers as $member)
                <li>{{ $member->name }} ({{ $member->email }} / {{ $member->phone }})</li>
            @endforeach
            </ul>
        @else
            <p>No extra members</p>
        @endif
    </div>
</div>
@stop
