@extends('adminlte::page')

@section('title','Edit Discount')

@section('content_header')
    <h1>Edit Discount #{{ $discount->id }}</h1>
@stop

@section('content')
<form method="POST" action="{{ route('discounts.update',$discount->id) }}">
    @csrf @method('PUT')
    <div class="form-group">
        <label>Type</label>
        <select name="type" class="form-control" required>
            <option value="flat" {{ $discount->type=='flat' ? 'selected' : '' }}>Flat %</option>
            <option value="extra_members" {{ $discount->type=='extra_members' ? 'selected' : '' }}>Extra Members</option>
        </select>
    </div>

    <div class="form-group">
        <label>Value</label>
        <input type="number" step="0.01" name="value" class="form-control" value="{{ $discount->value }}" required>
    </div>

    <div class="form-group">
        <label>Landing Page (optional)</label>
        <input type="text" name="landing_page_id" class="form-control" value="{{ $discount->landing_page_id }}">
    </div>

    <button type="submit" class="btn btn-success">Update</button>
</form>
@stop
