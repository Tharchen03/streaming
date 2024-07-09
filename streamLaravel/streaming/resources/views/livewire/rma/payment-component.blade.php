<div class="p-2 mt-4" id="rma-container">
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
                    @if ($drResponse && isset($drResponse['bfs_responseCode']) && $drResponse['bfs_responseCode'] === '-2')
                        <div class="form-container">
                            <p class="title">Payment Status: Failed!</p>
                            <span class="error-message">{{ $drResponse['bfs_responseDesc'] }} </span><a
                                href="{{ route('rma-payment') }}" class="btn-cancel">Try again</a>
                        </div>
                    @else
                    <div class="form-container">
                        <p class="title">Payment Status:done</p>
                        <p class="title">please verify the code that has been sent to ur mail</p>
                        @include('livewire.rma.verify-code')

                    </div>
                    @endif

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
</div>
