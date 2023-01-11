<div>
    <x-info />
    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-4 intro-y">
            <div class="intro-x flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Bonus
                </h2>
            </div>
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-gift report-box__icon text-theme-21">
                            <polyline points="20 12 20 22 4 22 4 12"></polyline>
                            <rect x="2" y="7" width="20" height="5"></rect>
                            <line x1="12" y1="22" x2="12" y2="7"></line>
                            <path d="M12 7H7.5a2.5 2.5 0 0 1 0-5C11 2 12 7 12 7z"></path>
                            <path d="M12 7h4.5a2.5 2.5 0 0 0 0-5C13 2 12 7 12 7z"></path>
                        </svg>
                        <div class="ml-auto">
                            @if (auth()->user()->package->benefit +
                                auth()->user()->bonus->whereNull('invalid')->where('amount', '<', 0)->sum('amount') >
                                auth()->user()->package->minimum_withdrawal)
                                @if (auth()->user()->bonus->whereNull('invalid')->sum('amount') >= auth()->user()->package->minimum_withdrawal &&
                                    auth()->user()->withdrawal->filter(function ($item) {
                                            return false !== stristr($item->created_at, date('Y-m-d'));
                                        })->count() == 0)
                                    <a href="javascript:;" data-toggle="modal" data-target="#modal-withdrawal"
                                        class="btn btn-success w-24">Withdrawal</a>
                                @endif
                            @endif
                        </div>
                    </div>
                    <div class="text-3xl font-bold leading-8 mt-6">
                        {{ number_format(auth()->user()->bonus->whereNull('invalid')->sum('amount'),2) }}</div>
                    <div class="text-base text-gray-600 mt-1">Available Bonus</div>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-4 intro-y">
            <div class="intro-x flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Bonus History
                </h2>
            </div>
            @foreach (auth()->user()->bonus->take(10) as $row)
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
                            {{ number_format($row->amount, 2) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="col-span-12 lg:col-span-4 intro-y">
            <div class="intro-x flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Withdrawal History
                </h2>
            </div>
            @foreach (auth()->user()->withdrawal->take(10) as $row)
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
                            <div class="font-medium">To :
                                @if ($row->to_wallet == 'balance')
                                    Balance
                                @else
                                    {{ substr($row->to_wallet, 0, 4) . '....' . substr($row->to_wallet, -4) }}
                                @endif
                            </div>
                            <div class="text-gray-600 text-xs mt-0.5">
                                {{ \Carbon\Carbon::parse($row->created_at)->diffForHumans() }}</div>
                        </div>
                        <div class="{{ $row->processed_at ? 'text-theme-10' : 'text-theme-22' }}">
                            {{ number_format($row->amount, 2) }}</div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div id="modal-withdrawal" class="modal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h2 class="font-medium text-base mr-auto">Withdrawal</h2>
                </div>
                @livewire('form.withdrawal')
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            Livewire.on('done', modal => {
                $('#' + modal).modal('hide');
            })
        </script>
    @endpush
</div>
