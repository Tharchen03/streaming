<form class="form" id="otp-form">
    @csrf
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
        <button class="form-btn btn-cancel" wire:click="cancelPaymentRequest" type="button">Cancel</button>
        <button class="form-btn btn-next" wire:click="verifyOTP" type="button">Next</button>
    </div>
</form>

{{-- <form class="form" wire:submit.prevent="verifyOTP" id="otp-form">
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
    @if ($drResponse && isset($drResponse['bfs_responseCode']) && $drResponse['bfs_responseCode'] === '-2')
        <span class="error-message">{{ $drResponse['bfs_responseDesc'] }}</span>
    @endif
    <div class="button-row">
        <button class="form-btn btn-cancel" wire:click="cancelPaymentRequest" type="button">Cancel</button>
        <button class="form-btn btn-next" type="submit">Next</button>
    </div>
</form> --}}
