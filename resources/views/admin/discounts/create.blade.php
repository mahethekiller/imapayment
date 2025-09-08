@extends('adminlte::page')

@section('title','Create Discount')

@section('content_header')
    <h1>Create Discount</h1>
@stop

@section('content')

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif


<form method="POST" action="{{ route('discounts.store') }}">
    @csrf
    <div class="form-group">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="flat">Flat %</option>
            <option value="extra_members">Extra Members</option>
        </select>
    </div>

    <div class="form-group">
        <label>Value</label>
        <input type="number" step="0.01" name="value" class="form-control" required>
    </div>

    <div class="form-group">
        <label>Landing Page (optional)</label>
        <input type="text" name="landing_page_id" class="form-control" placeholder="Enter Landing Page ID or leave blank">
    </div>

    <button type="submit" class="btn btn-success">Save</button>
</form>
@stop
