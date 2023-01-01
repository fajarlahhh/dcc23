<div>
    <form wire:submit.prevent="submit" class="pt-5">
        <div class="alert alert-secondary show">
            <h4>Create Wallet</h4>
            <table class="table">
                <tr>
                    <td>
                        <input type="text" minlength="10" class="form-control" wire:model.defer="wallet" 
                            autocomplete="off">
                    </td>
                    <td>
                        <input type="submit" class="btn btn-success" value="Submit">
                    </td>
                </tr>
            </table>
        </div>
    </form>
</div>
