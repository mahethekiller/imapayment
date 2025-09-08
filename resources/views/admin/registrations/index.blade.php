@extends('adminlte::page')

@section('title','Registrations')

@section('content_header')
    <h1>Registrations</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Landing Page</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Company</th>
                    <th>City</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($registrations as $reg)
                <tr>
                    <td>{{ $reg->id }}</td>
                    <td>{{ $reg->landingPage->title ?? '-' }}</td>
                    <td>{{ $reg->name }}</td>
                    <td>{{ $reg->email }}</td>
                    <td>{{ $reg->company }}</td>
                    <td>{{ $reg->city }}</td>
                    <td>{{ $reg->created_at->format('d M Y') }}</td>
                    <td>
                        <a href="{{ route('admin.registrations.show',$reg->id) }}" class="btn btn-sm btn-info">View</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $registrations->links() }}
    </div>
</div>
@stop
