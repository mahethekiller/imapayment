@extends('adminlte::page')

@section('title', 'Landing Pages')

@section('content_header')
    <h1>Landing Pages</h1>
@stop

@section('content')
    <a href="{{ route('landing-pages.create') }}" class="btn btn-primary mb-3">Create New</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Title</th>
                <th>Member Price</th>
                <th>Non-Member Price</th>
                <th>Workshop Mode</th>
                <th>PDF</th>
                <th>slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($pages as $page)
            <tr>
                <td>{{ $page->title }}</td>
                <td>{{ $page->member_price }}</td>
                <td>{{ $page->non_member_price }}</td>
                <td>{{ $page->workshop_mode ? 'Yes' : 'No' }}</td>
                <td>
                    @if($page->pdf_path)
                        <a href="{{ asset('storage/'.$page->pdf_path) }}" target="_blank">View</a>
                    @endif
                </td>
                <td>{{ $page->slug }}</td>
                <td>
                    <a href="{{ route('landing-pages.edit', $page->id) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('landing-pages.destroy', $page->id) }}" method="POST" style="display:inline;">
                        @csrf @method('DELETE')
                        <button onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">Delete</button>
                    </form>
                    <a href="{{ route('admin.landing.registrations', $page->id) }}" class="btn btn-sm btn-info">Registrations</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $pages->links() }}
@stop
