@extends('layout.main')
@if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
        @php
            Session::forget('success');
        @endphp
    </div>
@endif

<main class="LoginMain">
    <div class="loginWidget">
        <div class="form-container">
            <p class="title">stripe.....</p>
            <a href="{{ route('stripe.checkout', ['price' => 10, 'product' => 'streaming']) }}">Make Payment</a>
        </div>
    </div>
</main>

{{-- @if (Session::has('success'))
    <div class="alert alert-success">
        {{ Session::get('success') }}
        @php
            Session::forget('success');
        @endphp
    </div>
@endif

@if (Session::has('error'))
    <div class="alert alert-danger">
        {{ Session::get('error') }}
        @php
            Session::forget('error');
        @endphp
    </div>
@endif

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif --}}
