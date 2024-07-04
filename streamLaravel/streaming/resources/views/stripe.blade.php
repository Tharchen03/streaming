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