
<form class="form">
    @csrf
    <label class="labelAuth" for="fullname">Full name</label>
    <div class="input-container">
        <ion-icon style="visibility:initial;" name="person-outline"></ion-icon>
        <input type="text" id="fullname" tabindex="1" class="input @error('fullname') is-invalid @enderror"
            wire:model.lazy='fullname' name='fullname' value="{{ old('fullname') }}" placeholder="Enter full name">
    </div>
    {{-- @error('fullname')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror --}}

    <label class="labelAuth" for="email">Email
        <small>&raquo;To receive
            ticket
        </small></label>
    <div class="input-container">
        <ion-icon style="visibility:initial;" name="mail-outline"></ion-icon>
        <input type="email" id="email" tabindex="1" class="input @error('email') is-invalid @enderror"
            wire:model.lazy='email' name='email' value="{{ old('email') }}" placeholder="Enter email">
    </div>
    {{-- @error('email')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror --}}
    <label class="labelAuth" for="bank">Bank</label>
    <div class="input-container">
        <ion-icon style="visibility:initial;" name="wallet-outline"></ion-icon>
        <select id="bank" tabindex="1" class="select @error('bank') is-invalid @enderror" wire:model.lazy='bank'
            name='bank' value="{{ old('bank') }}" placeholder="Select account type">
            <option value=null>Select bank</option>
            {{-- @foreach ($bankList as $bank)
                <option value="{{ $bank['code'] }}">{{ $bank['name'] }}</option>
            @endforeach --}}
        </select>

    </div>
    {{-- @error('bank')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror --}}

    <label class="labelAuth" for="account_number">Account number</label>
    <div class="input-container">
        <ion-icon style="visibility:initial;" name="person-circle-outline"></ion-icon>
        <input type="account_number" id="account_number" tabindex="1"
            class="input @error('account_number') is-invalid @enderror" wire:model.lazy='account_number'
            name='account_number' value="{{ old('account_number') }}" placeholder="Enter account number">
    </div>
    {{-- @error('account_number')
        <span class="invalid-feedback" role="alert">
            {{ $message }}
        </span>
    @enderror --}}

    <div class="button-row">
        <button class="form-btn btn-cancel" wire:click="cancelPaymentRequest" type="button">Cancel</button>
        <button class="form-btn btn-next" wire:click="makePaymentRequest" type="button">Next</button>
    </div>
</form>
