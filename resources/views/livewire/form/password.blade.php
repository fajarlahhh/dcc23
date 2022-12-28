<div>
    <form wire:submit.prevent="submit">
        <div class="modal-body">
            <div>
                <label class="form-label">Old Password</label>
                <input type="password" class="form-control" wire:model.defer="oldPassword" required autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">New Password</label>
                <input type="password" class="form-control" wire:model.defer="newPassword" required autocomplete="off">
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
