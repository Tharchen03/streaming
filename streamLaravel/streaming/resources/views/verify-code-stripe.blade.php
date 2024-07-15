@extends('layout.main')
<main class="LoginMain">
    <div class="loginWidget">
        <div class="form-container">
            <p class="title">Please enter the code sent to your mail.</p>
            @if(session('success'))
                <p>{{ session('success') }}</p>
            @endif
            <form class="form" method="POST" action="{{ route('stripe.verify') }}">
                @csrf
                <label class="labelAuth" for="code">Verify code to get access</label>
                <div class="input-verify">
                    <ion-icon style="visibility:initial;" name="key-outline"></ion-icon>
                    <input type="text" id="code" tabindex="1" class="input-V" name="code" placeholder="Enter verification code">
                </div>
                @error('code')
                    <span class="invalid-feedback" role="alert">
                        {{ $message }}
                    </span>
                @enderror
                <div class="button-row">
                    <button class="form-btn btn-next" type="submit">Verify</button>
                </div>
            </form>
        </div>
    </div>
</main>
