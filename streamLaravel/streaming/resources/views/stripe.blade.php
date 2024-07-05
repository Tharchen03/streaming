@extends('layout.main')
@if (Session::has('success'))
    <div class="alert alert-success">
        
        <script>
            Swal.fire({
                position: 'bottom-end',
                icon: 'success',
                title: '{{ Session::get('success') }}',
                showConfirmButton: false,
                timer: 2500
            });
        </script>
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

{{-- Swal.fire({
    position: "top-end",
    icon: "success",
    title: "Your work has been saved",
    showConfirmButton: false,
    timer: 1500
  });
   --}}