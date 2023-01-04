<div>
    <x-info />
    @if (!auth()->user()->waitingTransferDeposit)
        <div class="intro-y grid grid-cols-12 gap-6 mt-5">
            <div class="col-span-12 lg:col-span-4 intro-y">
                <div class="intro-x flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Balance
                    </h2>
                </div>
                <div class="report-box zoom-in">
                    <div class="box p-5">
                        <div class="flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round"
                                class="feather feather-dollar-sign report-box__icon text-theme-21">
                                <line x1="12" y1="1" x2="12" y2="23"></line>
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path>
                            </svg>
                            <div class="ml-auto">
                                @if (auth()->user()->package->benefit +
                                    auth()->user()->bonus->where('amount', '<', 0)->sum('amount') >
                                    auth()->user()->package->minimum_withdrawal)
                                    <a href="javascript:;" data-toggle="modal" data-target="#modal-deposit"
                                        class="btn btn-warning w-24">Deposit</a>
                                    <a href="javascript:;" data-toggle="modal" data-target="#modal-sendbalance"
                                        class="btn btn-success w-24">Send</a>
                                @endif
                            </div>
                        </div>
                        <div class="text-3xl font-bold leading-8 mt-6">
                            {{ number_format(auth()->user()->balance->sum('amount')) }}</div>
                        <div class="text-base text-gray-600 mt-1">Available Balance</div>
                    </div>
                </div>
            </div>
            <div class="col-span-12 lg:col-span-4 intro-y">
                <div class="intro-x flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Balance History
                    </h2>
                </div>
                @foreach (auth()->user()->balance->take(10) as $row)
                    <div class="intro-x">
                        <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                            <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                @if ($row->amount > 0)
                                    <div class="report-box__indicator bg-theme-10 tooltip cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-plus block mx-auto">
                                            <line x1="12" y1="5" x2="12" y2="19"></line>
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </div>
                                @else
                                    <div class="report-box__indicator bg-theme-24 tooltip cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-minus block mx-auto">
                                            <line x1="5" y1="12" x2="19" y2="12"></line>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">{{ $row->description }}</div>
                                <div class="text-gray-600 text-xs mt-0.5">
                                    {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</div>
                            </div>
                            <div class="{{ $row->amount > 0 ? 'text-theme-10' : 'text-theme-24' }}">
                                {{ number_format($row->amount) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="col-span-12 lg:col-span-4 intro-y">
                <div class="intro-x flex items-center h-10">
                    <h2 class="text-lg font-medium truncate mr-5">
                        Deposit History
                    </h2>
                </div>
                @foreach (auth()->user()->deposit->take(10) as $row)
                    <div class="intro-x">
                        <div class="box px-5 py-3 mb-3 flex items-center zoom-in">
                            <div class="w-10 h-10 flex-none image-fit rounded-full overflow-hidden">
                                @if ($row->processed_at)
                                    <div class="report-box__indicator bg-theme-10 tooltip cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-star block mx-auto">
                                            <polygon
                                                points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2">
                                            </polygon>
                                        </svg>
                                    </div>
                                @else
                                    <div class="report-box__indicator bg-theme-22 tooltip cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none"
                                            stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round" class="feather feather-clock block mx-auto">
                                            <circle cx="12" cy="12" r="10"></circle>
                                            <polyline points="12 6 12 12 16 14"></polyline>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <div class="ml-4 mr-auto">
                                <div class="font-medium">
                                    {{ substr($row->from_wallet, 0, 4) . '....' . substr($row->from_wallet, -4) }} ->
                                    {{ substr($row->to_wallet, 0, 4) . '....' . substr($row->to_wallet, -4) }}
                                </div>
                                <div class="text-gray-600 text-xs mt-0.5">
                                    {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</div>
                            </div>
                            <div class="{{ $row->processed ? 'text-theme-10' : 'text-theme-22' }}">
                                {{ number_format($row->amount) }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
        @if (auth()->user()->package->benefit +
            auth()->user()->bonus->where('amount', '<', 0)->sum('amount') >
            auth()->user()->package->minimum_withdrawal)
            <x-modal title='Deposit'>
                @livewire('form.deposit')
            </x-modal>
            <x-modal title='Send Balance'>
                @livewire('form.sendbalance')
            </x-modal>
        @endif
    @else
        <div class="intro-y gap-6 mt-5">
            <h5 class="text-2xl">Waiting For Fund . . .</h5>
            <table class="table mt-3">
                <tr>
                    <td width="50%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-right">
                        Amount (USDT BEP-20)
                    </td>
                    <td width="50%" class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                        <strong>{{ number_format(auth()->user()->waitingTransferDeposit()->first()->amount) }}</strong>
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
                        <strong>{{ number_format(auth()->user()->waitingTransferDeposit()->first()->amount) }}</strong>
                        USDT
                        <small>BEP-20</small> to address
                        <strong><small>{{ auth()->user()->waitingTransferDeposit()->first()->to_wallet }}</small></strong>
                        <br>
                        <div style="display: flex; justify-content: center;" class="mt-3">
                            {!! QrCode::size(200)->generate(
                                auth()->user()->waitingTransferDeposit()->first()->to_wallet,
                            ) !!}
                        </div><br>
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="border border-b-2 dark:border-dark-5 whitespace-nowrapt text-center">
                        <form wire:submit.prevent="doneDeposit">
                            <input wire:model.defer="depositWallet" class="form-control" required minlength="10"
                                placeholder="Enter your origin wallet" />
                            <input type="submit" class="btn btn-success mt-3 m-r-20" value="Done">
                            <button type="button" class="btn btn-danger mt-3"
                                wire:click="cancelDeposit({{ auth()->user()->waitingTransferDeposit()->first()->getKey() }})">Cancel</button>
                        </form>
                    </td>
                </tr>
            </table>
            <br>
        </div>
    @endif
</div>
