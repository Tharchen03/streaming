
<main class="LoginMain">
    <div class="loginWidget">
        <div class="form-container">
            <p class="title">Please Provide Your Credential</p>
            <div class="p-2 mt-4" id="rma-container">
                @if ($isLoadingNotifier)
                    <p>loading.....</p>
                @else
                    @if ($bfsMsgType == 'AR' || ($bfsMsgType == 'AE' && $aeResponse['bfs_responseDesc'] != 'Success') )
                        @if ($aeResponse != null && $aeResponse['bfs_responseDesc'] != 'Success')
                            <p>{{getResponseDescription($aeResponse['bfs_responseCode'])}}</p>
                        @endif
                        @include('livewire.rma.account-selection')
                    @elseif($bfsMsgType == 'DR')
                        <p>paymentStatus</p>
                    @else
                        @include('livewire.rma.otp')
                    @endif
                @endif
            </div>
        </div>
    </div>
</main>
