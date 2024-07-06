@extends('layout.main')
{{-- @if (Session::has('success'))
    <div class="alert alert-success" style="color: ">
        {{ Session::get('success') }}
        @php
            Session::forget('success');
        @endphp
    </div>
@endif --}}
@if ($message = Session::get('success'))
<script type="text/javascript">
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: '{{ $message }}'
    })
</script>
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
  }); --}}
  
