<div>
    <form wire:submit.prevent="submit">
        <div class="modal-body p-10">
            <div>
                <label for="regular-form-1" class="form-label">Old Password</label>
                <input id="regular-form-1" type="password" class="form-control" wire:model.defer="oldPassword" required
                    autocomplete="off">
            </div>
            <div class="mt-3">
                <label for="regular-form-1" class="form-label">New Password</label>
                <input id="regular-form-1" type="password" class="form-control" wire:model.defer="newPassword" required
                    autocomplete="off">
            </div>
            <br>
            <x-alert />
        </div>
        <div class="modal-footer p-10">
            <div class="intro-x text-center xl:text-left">
                <button type="submit" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Submit</button>
            </div>
        </div>
    </form>
</div>
