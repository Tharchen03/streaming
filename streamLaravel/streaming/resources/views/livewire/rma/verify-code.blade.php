
<form class="form">
    @csrf
    <label class="labelAuth" for="code">verify code to get access</label>
    <div class="input-container">
        <ion-icon style="visibility:initial;" name="key-outline"></ion-icon>
        <input type="text" id="code" tabindex="1" class="input @error('code') is-invalid @enderror"
            wire:model.lazy='code' name='code' value="{{ old('code') }}" placeholder="Enter full name">
    </div>
    @error('code')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror

    <div class="button-row">
        <button class="form-btn btn-cancel" wire:click="cancelPaymentRequest" type="button">Cancel</button>
        <button class="form-btn btn-next" wire:click="verifyCode" type="button">Next</button>
    </div>
</form>
