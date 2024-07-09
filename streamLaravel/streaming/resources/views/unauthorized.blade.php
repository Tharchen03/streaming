@extends('layout.main')

<main>
    <div class="content">
        <h1>Unauthorized access! Please make your payment first to get access</h1>
        <a href="{{ route('home') }}">Make payment</a>
    </div>
</main>