@extends('adminlte::page')

@section('title','Discount Rules')

@section('content_header')
    <h1>Discount Rules</h1>
@stop

@section('content')
<a href="{{ route('discounts.create') }}" class="btn btn-primary mb-3">Add Discount</a>

<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Type</th>
                    <th>Value</th>
                    <th>Landing Page</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($discounts as $d)
                <tr>
                    <td>{{ $d->id }}</td>
                    <td>{{ ucfirst($d->type) }}</td>
                    <td>{{ $d->value }} {{ $d->type == 'flat' ? '%' : '(extra members)' }}</td>
                    <td>{{ $d->landingPage->title ?? 'Global' }}</td>
                    <td>
                        <a href="{{ route('discounts.edit',$d->id) }}" class="btn btn-sm btn-warning">Edit</a>
                        <form action="{{ route('discounts.destroy',$d->id) }}" method="POST" style="display:inline;">
                            @csrf @method('DELETE')
                            <button onclick="return confirm('Delete this?')" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $discounts->links() }}
    </div>
</div>
@stop
