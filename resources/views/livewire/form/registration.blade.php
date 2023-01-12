<div>
    <form wire:submit.prevent="submit">
        <div class="modal-body">
            <div>
                <label class="form-label">Username</label>
                <input type="text" class="form-control" wire:model.defer="username" required autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">Name</label>
                <input type="text" class="form-control" wire:model.defer="name" required autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">Phone</label>
                <input type="text" class="form-control" wire:model.defer="phone" required autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">Email</label>
                <input type="email" class="form-control" wire:model.defer="email" required autocomplete="off">
            </div>
            <div class="mt-3">
                <label class="form-label">Package</label>
                <select class="form-select mt-2 sm:mr-2" wire:model.defer="package" aria-label="Default select example">
                    <option selected hidden>-- Select Package --</option>
                    @foreach (\App\Models\Package::all() as $row)
                        <option value="{{ $row->value }}">{{ number_format($row->value) }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mt-3">
                <label>Team</label>
                <div class="flex flex-col sm:flex-row mt-2 mr-5">
                    <div class="form-check mr-2">
                        <input id="radio-switch-1" class="form-check-input" type="radio" name="team"
                            wire:model.defer="team" value="l">
                        <label class="form-check-label" for="radio-switch-1">Left</label>
                    </div>
                    <div class="form-check mr-2 mt-2 sm:mt-0"> <input id="radio-switch-2" class="form-check-input"
                            type="radio" name="team" wire:model.defer="team" value="r">
                        <label class="form-check-label" for="radio-switch-2">Right</label>
                    </div>
                </div>
            </div>
            <div class="alert alert-secondary show mt-5" role="alert">
                <div>
                    <label class="form-label">PIN</label>
                    <input type="text" class="form-control" wire:model.defer="pin" required autocomplete="off">
                </div>
            </div>
            <x-alert />
            <x-info />
        </div>
        <div class="modal-footer">
            <div class="intro-x text-center xl:text-left">
                <button type="submit" class="btn btn-primary w-full xl:w-32 xl:mr-3 align-top">Submit</button>
            </div>
        </div>
    </form>
</div>
