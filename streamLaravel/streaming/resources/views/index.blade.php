@extends('layout.main')

<main>
    <div class="content">
        <h1>Your gateway to Watching movies</h1>
        <h2>Choose Your Payment Method</h2>
        <a href=""></a>
        <div class="store-buttons">
            <button class="store-btn" onclick="window.location.href='{{ route('stripe-payment') }}'">
                <img src="assets/img/icons/applestore.png" alt="App Store" /> Intl Payment
            </button>
            <button class="store-btn"  onclick="window.location.href='{{ route('rma-payment') }}'" >
                <img src="assets/img/icons/playstore.png" alt="Play Store" />
                    RMA Payment
            </button>
        </div>
    </div>
</main>
