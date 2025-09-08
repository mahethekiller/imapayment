@extends('layouts.app')

@section('title', $lp->title . 'Payment Successful')
@section('content')
<div class="container">
    <div class="card text-center">
        <div class="card-body">
            <h2>Payment Success</h2>
            <p>Thank you, {{ $registration->name }}. Your registration is successful.</p>
            @if($pdf)
                <a href="{{ asset('storage/' . $pdf) }}" class="btn btn-primary btn-lg" download>
                    Download PDF
                </a>
                <script>
                    setTimeout(function(){
                        var link = document.createElement('a');
                        link.href = "{{ asset('storage/' . $pdf) }}";
                        link.download = '{{ $pdf }}';
                        link.dispatchEvent(new MouseEvent('click'));
                    }, 1000);
                </script>
            @else
                <p>No PDF available for this registration.</p>
            @endif
        </div>
    </div>

</div>
@endsection
