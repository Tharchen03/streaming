{{-- <main class="loginWidget">
<div class="form-container">
    <div class="card-body p-4">
        <div class="text-center mt-2">
            <h5 class="text-primary">Welcome Back !</h5>
            <p class="text-muted">Please Provide Your Credential</p>
        </div>
        <div class="p-2 mt-4">
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
                <p>otpFORM</p>
                @endif
            @endif
        </div>
    </div>

</div>


</main> --}}

<main class="LoginMain">
    <div class="loginWidget">
        <div class="form-container">
            <p class="title">Please Provide Your Credential</p>
            <div class="p-2 mt-4">
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
                        @include('livewire.rma.account-selection')
                    @endif
                @endif
            </div>
        </div>
    </div>
</main>
