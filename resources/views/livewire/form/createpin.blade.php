<div>
    <form wire:submit.prevent="submit" class="pt-5">
        <div class="alert alert-secondary show">
            <h4>Create PIN</h4>
            <table class="table">
                <tr>
                    <td>
                        <input type="number" step='1' class="form-control" wire:model.defer="pin" maxlength="6"
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
