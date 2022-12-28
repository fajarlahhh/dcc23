<div>
    <form wire:submit.prevent="send">
        <div class="modal-body">
            <div>
                <label for="regular-form-1" class="form-label">Amount</label>
                <input id="regular-form-1" type="number" class="form-control" wire:model.defer="amount" required
                    autocomplete="off">
            </div>
            <div class="mt-3">
                <label for="regular-form-1" class="form-label">Username</label>
                <input id="regular-form-1" type="text" class="form-control" wire:model.defer="username" required
                    autocomplete="off">
            </div>
            <div class="alert alert-secondary show mt-5" role="alert">
                <div>
                    <label for="regular-form-1" class="form-label">PIN</label>
                    <input id="regular-form-1" type="text" class="form-control" wire:model.defer="pin" required
                        autocomplete="off">
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