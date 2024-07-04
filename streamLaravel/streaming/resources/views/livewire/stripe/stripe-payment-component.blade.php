{{-- <div class="p-2 mt-4" id="rma-container">
    @if ($isLoadingNotifier)
        <main class="LoginMain">
            <div class="loginWidget">
                <div class="form-container">
                    <p class="title">Loading.....</p>
                </div>
            </div>
        </main>
    @else
        @if ($bfsMsgType == 'AR' || ($bfsMsgType == 'AE' && $aeResponse['bfs_responseDesc'] != 'Success'))
            @if ($aeResponse != null && $aeResponse['bfs_responseDesc'] != 'Success')
                <p>{{ getResponseDescription($aeResponse['bfs_responseCode']) }}</p>
            @endif
            <main class="LoginMain">
                <div class="loginWidget">
                    <div class="form-container">
                        <p class="title">Please Provide Your Bank Credential</p>
                        <div class="p-2 mt-4">
                            @include('livewire.rma.account-selection')
                        </div>
                    </div>
                </div>
            </main>
        @elseif($bfsMsgType == 'DR')
            <main class="LoginMain">
                <div class="loginWidget">
                    <div class="form-container">
                        <p class="title">Payment Status</p>
                    </div>
                </div>
            </main>
        @else
            <main class="LoginMain">
                <div class="otpWidget">
                    <div class="otp-form-container">
                        <p class="title">Verify your OTP</p>
                        <div class="p-2 mt-4" id="otp-container">
                            @include('livewire.rma.otp')
                        </div>
                    </div>
                </div>
            </main>
        @endif
    @endif
</div> --}}

<main class="LoginMain">
    <div class="loginWidget">
        <div class="form-container">
            <p class="title">Loading.....</p>
            @include('livewire.stripe.otp')
        </div>
    </div>
</main>
