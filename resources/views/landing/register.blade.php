@extends('layouts.app')

@section('title', 'Register - ' . $lp->title)

@section('content')
    <div class="container py-3">
        <h1 class="mb-4 text-center">{{ $lp->title }}</h1>
        @if ($lp->description)
            <p class="text-center">{{ $lp->description }}</p>
        @endif

        <div class="card shadow-sm">
            <div class="card-body">
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form id="regForm" method="POST" action="{{ route('landing.summary', $lp->slug) }}">
                    @csrf
                    <input type="hidden" name="type" id="type" value="{{ $type ?? 'guest' }}">

                    @php $isMember = ($type ?? 'guest') === 'member'; @endphp

                    @if ($isMember && !auth()->check())
                        <div class="alert alert-info text-center">
                            Please <a href="{{ route('landing.member.login', ['slug' => $lp->slug]) }}">login</a> with your
                            member credentials before registration.
                            If not a member, you can continue as a <a
                                href="{{ route('landing.register', ['slug' => $lp->slug, 'type' => 'guest']) }}">non-member</a>.
                        </div>
                    @else
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Name*</label>
                                <input name="name" class="form-control" value="{{ old('name') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Email*</label>
                                <input name="email" type="email" class="form-control" value="{{ old('email') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Mobile*</label>
                                <input name="mobile" id="mobile" class="form-control" value="{{ old('mobile') }}" required>

                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Company</label>
                                <input name="company" class="form-control" value="{{ old('company') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Country*</label>
                                <input name="country" class="form-control" value="{{ old('country') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">City*</label>
                                <input name="city" class="form-control" value="{{ old('city') }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Address*</label>
                                <textarea name="address" class="form-control" required>{{ old('address') }}</textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Company GST</label>
                                <input name="company_gst" class="form-control" value="{{ old('company_gst') }}">
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Preferred City (Optional)</label>
                                <input name="preferred_city" class="form-control" value="{{ old('preferred_city') }}">
                            </div>
                        </div>

                        @if (!$lp->can_have_extra_members)
                            <hr class="my-4">
                            <h4>Extra Members</h4>
                            <div id="extra-members" class="mb-3"></div>
                            <button type="button" class="btn btn-sm btn-secondary mb-4" id="addExtra">Add Extra
                                Member</button>
                        @endif
                        <br>

                        <button type="submit" class="btn btn-primary btn-lg w-100">Continue</button>
                    @endif
                </form>
            </div>
        </div>
    </div>


    <script>
        // $('#mobile').on('keyup', function() {
        //     const mobile = $(this).val().replace(/\D+/g, '');
        //     const valid = mobile.length >= 10 && mobile.length <= 12;
        //     document.getElementById('mobileError').textContent = valid ? '' : 'Mobile number should be 10-12 digits';

        // });
    </script>

    @if (!$lp->can_have_extra_members)
        <script>
            document.getElementById('addExtra').addEventListener('click', function() {
                const wrapper = document.createElement('div');
                wrapper.className = 'extra-member row g-2 mb-2';
                wrapper.innerHTML = `
        <div class="col-md-4">
            <input name="extra_members[][name]" placeholder="Name" class="form-control" required>
        </div>
        <div class="col-md-4">
            <input name="extra_members[][email]" placeholder="Email" class="form-control">
        </div>
        <div class="col-md-3">
            <input name="extra_members[][phone]" placeholder="Phone" class="form-control">
        </div>
        <div class="col-md-1">
            <button type="button" class="btn btn-danger btn-sm remove">×</button>
        </div>
    `;
                wrapper.querySelector('.remove').addEventListener('click', () => wrapper.remove());
                document.getElementById('extra-members').appendChild(wrapper);
            });
        </script>
    @endif
@endsection
