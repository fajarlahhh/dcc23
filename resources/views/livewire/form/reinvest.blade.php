<div>
    @if (\App\Models\Deposit::where('user_id', auth()->id())->where('registration', 2)->whereNull('processed_at')->count() > 0)
        <div class="intro-y alert alert-warning show mt-5">
            Your reinvest process is in progress and takes 1 x 24 hours
        </div>
    @else
        <div class="intro-y alert alert-danger show mt-5">
            Your account need to reinvest. <a href="javascript:;" data-toggle="modal" class="btn btn-sm btn-warning"
                data-target="#modal-reinvest">Click
                Here</a> to do reinvest.
        </div>
        <x-modal title='Reinvest'>
            <div class="intro-y gap-6 mt-5">
                <table class="table">
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
                            <br>
                            <strong><small>{{ \App\Models\User::find(1)->wallet }}</small></strong>
                            <br>
                            <div style="display: flex; justify-content: center;" class="mt-3">
                                {!! QrCode::size(200)->generate(\App\Models\User::find(1)->wallet) !!}
                            </div><br>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2" class="border border-b-2 dark:border-dark-5 whitespace-nowrapt text-center">
                            <form wire:submit.prevent="submit">
                                <input wire:model.defer="fromWallet" class="form-control" required minlength="10"
                                    placeholder="Enter your origin wallet" />
                                <input type="submit" class="btn btn-success mt-3 m-r-20" value="Submit">
                                <button type="button" class="btn btn-danger mt-3"
                                    wire:click="cancel({{ auth()->id() }})">Cancel</button>
                            </form>
                        </td>
                    </tr>
                </table>
                <br>
            </div>
        </x-modal>
    @endif

</div>
