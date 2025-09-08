@extends('adminlte::page')

@section('title', isset($landingPage) ? 'Edit Landing Page' : 'Create Landing Page')

@section('content_header')
    <h1>{{ isset($landingPage) ? 'Edit' : 'Create' }} Landing Page</h1>
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

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    <form method="POST" enctype="multipart/form-data"
        action="{{ isset($landingPage) ? route('landing-pages.update', $landingPage->id) : route('landing-pages.store') }}">
        @csrf
        @if (isset($landingPage))
            @method('PUT')
        @endif

        <div class="form-group">
            <label>Title</label>
            <input type="text" name="title" class="form-control" value="{{ old('title', $landingPage->title ?? '') }}"
                required>
        </div>

        <div class="form-group">
            <label>Member Price</label>
            <input type="number" step="0.01" name="member_price" class="form-control"
                value="{{ old('member_price', $landingPage->member_price ?? '') }}" required>
        </div>

        <div class="form-group">
            <label>Non-Member Price</label>
            <input type="number" step="0.01" name="non_member_price" class="form-control"
                value="{{ old('non_member_price', $landingPage->non_member_price ?? '') }}" required>
        </div>
        <div class="form-group">
            <label>Extra Member Price</label>
            <input type="number" step="0.01" name="extra_member_price" class="form-control"
                value="{{ old('extra_member_price', $landingPage->extra_member_price ?? 0) }}"
                placeholder="Price per extra member">
        </div>


        <div class="form-group">
            <label>GST Percentage</label>
            <input type="number" step="0.01" name="gst_percent" class="form-control"
                value="{{ old('gst_percent', $landingPage->gst_percent ?? '') }}" required>
        </div>
        <div class="form-group">
            <label>Slug (URL)</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $landingPage->slug ?? '') }}"
                placeholder="slug">
        </div>

        <div class="form-group">
            <label>Upload PDF (optional)</label>
            <input type="file" name="pdf_path" class="form-control">
            @if (isset($landingPage) && $landingPage->pdf_path)
                <p>Current: <a href="{{ asset('storage/' . $landingPage->pdf_path) }}" target="_blank">View</a></p>
            @endif
        </div>

        <div class="form-check">
            <input type="checkbox" name="workshop_mode" class="form-check-input" value="1"
                {{ old('workshop_mode', $landingPage->workshop_mode ?? false) ? 'checked' : '' }}>
            <label class="form-check-label">Workshop Mode</label>
        </div>

        <div class="form-check">
            <input type="checkbox" name="can_have_extra_members" class="form-check-input" id="can_have_extra_members"
                value="1"
                {{ old('can_have_extra_members', $landingPage->can_have_extra_members ?? false) ? 'checked' : '' }}>
            <label for="can_have_extra_members" class="form-check-label">Allow Extra Members</label>
        </div>


        <div class="form-group">
            <label>Banner Image (optional)</label>
            <input type="file" name="banner_path" class="form-control">
            @if (isset($landingPage) && $landingPage->banner_path)
                <p>Current: <a href="{{ asset('storage/' . $landingPage->banner_path) }}" target="_blank">View</a></p>
            @endif
        </div>


        <hr>
        <h4>Extra Members Discount</h4>
        <div id="discount-rules">
            @if (isset($landingPage) && $landingPage->discountRules)
                @foreach ($landingPage->discountRules as $rule)
                    @if ($rule->type == 'extra_members')
                        <div class="discount-rule mb-2">
                            <input type="number" name="discount_rules[threshold][]" value="{{ $rule->threshold }}"
                                placeholder="No. of Extra Members" required>
                            <input type="number" step="0.01" name="discount_rules[value][]" value="{{ $rule->value }}"
                                placeholder="Discount %" required>
                            <button type="button" class="btn btn-danger remove-rule">Remove</button>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>
        <button type="button" id="addDiscountRule" class="btn btn-secondary btn-sm mt-2">Add Discount Rule</button>

        <script>
            document.getElementById('addDiscountRule').addEventListener('click', function() {
                const wrapper = document.createElement('div');
                wrapper.className = 'discount-rule mb-2';
                wrapper.innerHTML = `
        <input type="number" name="discount_rules[threshold][]" placeholder="No. of Extra Members" required>
        <input type="number" step="0.01" name="discount_rules[value][]" placeholder="Discount %" required>
        <button type="button" class="btn btn-danger remove-rule">Remove</button>
    `;
                wrapper.querySelector('.remove-rule').addEventListener('click', () => wrapper.remove());
                document.getElementById('discount-rules').appendChild(wrapper);
            });
        </script>




        <button type="submit" class="btn btn-success mt-3">
            {{ isset($landingPage) ? 'Update' : 'Create' }}
        </button>
    </form>
@stop
