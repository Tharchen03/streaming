<form class="form" id="otp-form">
    <div class="input-container" id="otp-inputs">
        @foreach ($otp_inputs as $key => $otp_input)
            <input type="text" class="otp-input" maxlength="1" wire:model="otp_inputs.{{ $key }}" />
        @endforeach
    </div>
    @error('otp_inputs')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror
    <div class="button-row">
        <button class="form-btn btn-next" wire:click="cancelPaymentRequest" type="button">Cancel</button>
        <button class="form-btn btn-cancel" wire:click="verifyOTP" type="button">Next</button>
    </div>
</form>