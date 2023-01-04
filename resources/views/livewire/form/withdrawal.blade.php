<div>
    <form wire:submit.prevent="withdrawal">
        <div class="modal-body">
            <div class="alert alert-warning show mb-2" role="alert">
                <ul>
                    <li>Available every weekdays (09.00 - 17.00 UTC+7)</li>
                    <li>Min. WD : {{ auth()->user()->package->minimum_withdrawal }}</li>
                    <li>Max. WD : {{ auth()->user()->package->maximum_withdrawal }}</li>
                    <li>Fee : {{ auth()->user()->package->fee_withdrawal }}</li>
                    <li>1 x 24 hours proccess</li>
                </ul>
            </div>
            <div>
                <label class="form-label">Amount</label>
                <input type="number" class="form-control" min="15"
                    max="{{ auth()->user()->package->maximum_withdrawal }}" wire:model.defer="amount" autocomplete="off"
                    required>
            </div>
            {{-- <div class="mt-3">
                <label>Destination</label>
                <div class="flex flex-col sm:flex-row mt-2 mr-5">
                    <div class="form-check mr-10"> <input id="radio-switch-1" class="form-check-input" type="radio"
                            name="destination" wire:model.defer="destination" value="balance">
                        <label class="form-check-label" for="radio-switch-1">Balance</label>
                    </div>
                    <div class="form-check mr-4 mt-2 sm:mt-0"> <input id="radio-switch-2" class="form-check-input"
                            type="radio" name="destination" wire:model.defer="destination" value="wallet">
                        <label class="form-check-label" for="radio-switch-2">Wallet</label>
                    </div>
                </div>
            </div> --}}
            <div class="alert alert-secondary show mt-5" role="alert">
                <div>
                    <label class="form-label">PIN</label>
                    <input type="text" class="form-control" wire:model.defer="pin" required autocomplete="off">
                </div>
            </div>
            <x-alert />
        </div>
        <div class="modal-footer">
            <div class="intro-x text-center xl:text-left">
                <button type="submit" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Submit</button>
            </div>
        </div>
    </form>
</div>
