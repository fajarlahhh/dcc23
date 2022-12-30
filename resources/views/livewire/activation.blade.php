<div>
    <x-info />
    <x-alert />
    @if (auth()->user()->from_wallet)
        <div class="alert alert-success show  text-center mb-2 mt-10" role="alert">
            <h4>
                Your activation information has been submitted, please wait for activation by admin.<br>
                It will take 1 x 24 hours
            </h4>
        </div>
    @else
        <div class="intro-y gap-6 mt-5">
            <h5 class="text-2xl">Waiting For Fund . . .</h5>
            <table class="table mt-3">
                <tr>
                    <td width="50%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-right">
                        Amount (USDT BEP-20)
                    </td>
                    <td width="50%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                        <strong>{{ number_format(auth()->user()->package->value) }}</strong>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-center">
                        <small>(The amount of USDT to be transferred must match the
                            amount)</small>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-center">
                        Please send
                        <strong>{{ number_format(auth()->user()->package->value) }}</strong>
                        USDT
                        <small>BEP-20</small> to address
                        <strong><small>{{ auth()->user()->to_wallet }}</small></strong>
                        <br>
                        <div style="display: flex; justify-content: center;" class="mt-3">
                            {!! QrCode::size(200)->generate(auth()->user()->to_wallet) !!}
                        </div><br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="border border-b-2 dark:border-dark-5 whitespace-nowrapt text-center">
                        <form wire:submit.prevent="submit">
                            <input wire:model.defer="fromWallet" class="form-control" required minlength="10"
                                placeholder="Enter your origin wallet" />
                            <input type="submit" class="btn btn-success mt-3 m-r-20" value="Done">
                            <button type="button" class="btn btn-danger mt-3"
                                wire:click="cancel({{ auth()->id() }})">Cancel</button>
                        </form>
                    </td>
                </tr>
            </table>
            <br>
        </div>
    @endif
</div>
