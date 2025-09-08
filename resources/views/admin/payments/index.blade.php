@extends('adminlte::page')

@section('title','Payments')

@section('content_header')
    <h1>Payments</h1>
@stop

@section('content')
<div class="card">
    <div class="card-body">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Registration</th>
                    <th>Landing Page</th>
                    <th>Amount</th>
                    <th>Status</th>
                    <th>Txn ID</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            @foreach($payments as $p)
                <tr>
                    <td>{{ $p->id }}</td>
                    <td>{{ $p->registration->name ?? '-' }}</td>
                    <td>{{ $p->registration->landingPage->title ?? '-' }}</td>
                    <td>{{ $p->amount }}</td>
                    <td>
                        <span class="badge badge-{{ $p->status=='success' ? 'success' : ($p->status=='failed' ? 'danger' : 'secondary') }}">
                            {{ ucfirst($p->status) }}
                        </span>
                    </td>
                    <td>{{ $p->transaction_id }}</td>
                    <td>{{ $p->created_at->format('d M Y') }}</td>
                    <td><a href="{{ route('payments.show',$p->id) }}" class="btn btn-sm btn-info">View</a></td>
                </tr>
            @endforeach
            </tbody>
        </table>
        {{ $payments->links() }}
    </div>
</div>
@stop
