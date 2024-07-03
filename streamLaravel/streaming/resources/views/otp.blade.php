@extends('layout.main')


<main class="LoginMain">
    <div class="loginWidget">
        <div class="form-container">
            <p class="title">Please Provide Your Credential</p>
            <div class="p-2 mt-4">
                {{-- @include('livewire.rma.OTP') --}}
                <form class="form" id="otp-form">
                    <div class="input-container" id="otp-inputs">
                        <input type="text" class="otp-input" maxlength="1" wire:model.lazy="otp_1" />
        <input type="text" class="otp-input" maxlength="1" wire:model.lazy="otp_2" />
        <input type="text" class="otp-input" maxlength="1" wire:model.lazy="otp_3" />
        <input type="text" class="otp-input" maxlength="1" wire:model.lazy="otp_4" />
        <input type="text" class="otp-input" maxlength="1" wire:model.lazy="otp_5" />
        <input type="text" class="otp-input" maxlength="1" wire:model.lazy="otp_6" />
                    </div>
                    <a href="#" class="otp-link">
                        <span class="otp-link-label">Resend otp?</span>
                    </a>
                    <div class="button-row">
                        <button type="submit" class="form-btn btn-next">Next</button>
                        <button type="button" class="form-btn btn-cancel">Cancel</button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    </div>
</main>
