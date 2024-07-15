{{-- @extends('layout.main')

@section('content')
    <main>
        <div class="content">
            <h1>Your gateway to Watching movies</h1>
            <h2>Choose Your Payment Method</h2>
            <div class="store-buttons">
                <button class="store-btn"
                    onclick="handleButtonClick('{{ route('stripe.checkout', ['price' => 10, 'product' => 'streaming']) }}')">
                    <img src="assets/img/icons/applestore.png" alt="App Store" /> Intl Payment
                </button>
                <button class="store-btn" onclick="handleButtonClick('{{ route('rma-payment') }}')">
                    <img src="assets/img/icons/playstore.png" alt="Play Store" />
                    RMA Payment
                </button>
            </div>
        </div>
        <div class="loaderRectangle" id="loader" style="display: none;" onclick="cancelLoading()">
            <div></div>
            <div></div>
            <div></div>
            <div></div>
            <div></div>
        </div>
    </main>
@endsection --}}

@extends('layout.main')

@section('content')
    <main>
        <div class="content">
            <h1>Stream Your Movies</h1>
            <h2>Choose Your Payment Method</h2>
            <div class="store-buttons">
                <button class="store-btn" onclick="window.location.href='{{ route('stripe.checkout', ['price' => 10, 'product' => 'streaming']) }}'">
                    <img src="{{ asset('assets/img/icons/applestore.png') }}" alt="App Store" /> Intl Payment
                </button>
                <button class="store-btn" onclick="window.location.href='{{ route('rma-payment') }}'">
                    <img src="{{ asset('assets/img/icons/playstore.png') }}" alt="Play Store" />
                    RMA Payment
                </button>
            </div>
        </div>
    </main>
@endsection

