<form class="form" id="otp-form">
    <div class="input-container" id="otp-inputs">
        <input type="text" class="otp-input" maxlength="1" />
        <input type="text" class="otp-input" maxlength="1" />
        <input type="text" class="otp-input" maxlength="1" />
        <input type="text" class="otp-input" maxlength="1" />
        <input type="text" class="otp-input" maxlength="1" />
        <input type="text" class="otp-input" maxlength="1" />
    </div>
    <a href="#" class="otp-link">
        <span class="otp-link-label">Resend otp?</span>
    </a>
    <div class="button-row">
        <button class="form-btn btn-next" wire:click="cancelPaymentRequest" type="button">Cancel</button>
        <button class="form-btn btn-cancel" wire:click="makePaymentRequest" type="button">Next</button>
    </div>
</form>
</div>

