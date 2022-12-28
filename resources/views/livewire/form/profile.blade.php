<div>
    <form wire:submit.prevent="submit">
        <div class="modal-body">
            <div>
                <label class="form-label">Username</label>
                <input type="text" class="form-control" value="{{ auth()->user()->username }}" disabled
                    autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" wire:model.defer="name" required autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">Email</label>
                <input type="text" class="form-control" wire:model.defer="email" required autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" wire:model.defer="phone" required autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">Upline</label>
                <input type="text" class="form-control"
                    value="{{ auth()->user()->upline ? auth()->user()->upline->name : '' }}" disabled
                    autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">USDT Wallet <small>BEP-20</small></label>
                <input type="text" class="form-control" wire:model.defer="wallet" required autocomplete="off">
            </div>
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
                <button type="submit" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Update</button>
            </div>
        </div>
    </form>
</div>
