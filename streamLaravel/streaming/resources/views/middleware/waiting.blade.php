@extends('layout.main')

<main>
    <div class="content">
        <h1>The video will be available from {{ \Carbon\Carbon::parse($availabilityStart)->format('d/m/Y h:i A') }} to {{ \Carbon\Carbon::parse($availabilityEnd)->format('d/m/Y h:i A') }}</h1>
    </div>
</main>
