<div>
    <x-info />
    <x-alert />
    <div class="intro-y flex items-center mt-8">
        <h2 class="text-lg font-medium mr-auto">
            Dashboard
        </h2>
    </div>
    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-12 mt-6">
            <div class="ads-box box p-8 relative overflow-hidden bg-theme-17 intro-y">
                <div class="ads-box__title w-full sm:w-72 text-white text-xl -mt-3">Package</div>
                <div class="w-full sm:w-100 leading-relaxed text-white text-opacity-70  dark:text-opacity-100 mt-3">
                    <strong>{{ strtoupper(auth()->user()->package->name) }}</strong> -
                    {{ number_format(auth()->user()->package->value) }}
                    USDT

                    <div class="progress h-6 w-full bg-gray-200 rounded-full dark:bg-gray-700 mt-3">
                        <div class="progress-bar text-xs bg-theme-17 font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                            style="width: {{ ((auth()->user()->package->benefit +auth()->user()->bonus->whereNull('invalid')->where('amount', '<', 0)->sum('amount')) /auth()->user()->package->benefit) *100 }}%">

                        </div>
                    </div>
                    <div class="text-center">Available
                        :
                        {{ number_format(auth()->user()->package->benefit +auth()->user()->bonus->whereNull('invalid')->where('amount', '<', 0)->sum('amount'),2) }}
                        / {{ number_format(auth()->user()->package->benefit) }}</div>
                </div>
                <a href="/bonus" class="btn w-100 btn-success dark:text-dark mt-6 sm:mt-10">Current Bonus
                    :
                    {{ number_format(auth()->user()->bonus->whereNull('invalid')->sum('amount'),2) }}</a>
                <a href="/balance" class="btn w-100 btn-warning dark:text-dark mt-6 sm:mt-10">Balance :
                    {{ number_format(auth()->user()->balance->sum('amount'),2) }}</a>
                <a href="/downline" class="btn w-100 btn-twitter dark:text-dark mt-6 sm:mt-10">Downline :
                    {{ \App\Models\User::where('network', 'like', (auth()->user()->network ?: auth()->id()) . 'l%')->count() + \App\Models\User::where('network', 'like', (auth()->user()->network ?: auth()->id()) . 'r%')->count() }}</a>
            </div>
        </div>
    </div>
    <div class="report-box-2 intro-y mt-5">
        <div class="box sm:flex">
            <div class="px-8 py-12 flex flex-col justify-center flex-1">
                <div class="input-group mt-2 width-full">
                    <div class="input-group-text">
                        Left Referral
                    </div>
                    <input type="text" class="form-control" placeholder="Price" disabled
                        value="{{ url('/' . auth()->user()->username . '/l') }}">
                    <button onclick="copyUrl('{{ url('/' . auth()->user()->username . '/l') }}')"
                        class="btn input-group-text">
                        Copy
                    </button>
                </div>
                <div class="ads-box__title w-full sm:w-72 text-white text-xl mt-3">Turnover :
                    {{ number_format((int) $network->valid_left - (int) $network->invalidLeft->sum('amount')) }}</div>
            </div>
            <div
                class="px-8 py-12 flex flex-col justify-center flex-1 border-t sm:border-t-0 sm:border-l border-gray-300 dark:border-dark-5 border-dashed">
                <div class="input-group mt-2 width-full">
                    <div class="input-group-text">
                        Right Referral
                    </div>
                    <input type="text" class="form-control" placeholder="Price" disabled
                        value="{{ url('/' . auth()->user()->username . '/r') }}">
                    <button onclick="copyUrl('{{ url('/' . auth()->user()->username . '/r') }}')"
                        class="btn input-group-text">
                        Copy
                    </button>
                </div>
                <div class="ads-box__title w-full sm:w-72 text-white text-xl mt-3">Turnover :
                    {{ number_format((int) $network->valid_right - (int) $network->invalidRight->sum('amount')) }}
                </div>
            </div>
        </div>
    </div>
    <div class="mt-5 intro-y">
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
                        {{ number_format($row->amount) }}</div>
                </div>
            </div>
        @endforeach
    </div>
    @push('scripts')
        <script>
            function copyUrl(text) {
                copyToClipboard(text);
                alert('Text copied');
            }

            function copyToClipboard(text) {
                var sampleTextarea = document.createElement("textarea");
                document.body.appendChild(sampleTextarea);
                sampleTextarea.value = text; //save main text in it
                sampleTextarea.select(); //select textarea contenrs
                document.execCommand("copy");
                document.body.removeChild(sampleTextarea);
            }
        </script>
    @endpush
</div>
