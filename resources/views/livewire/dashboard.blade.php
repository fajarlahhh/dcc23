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
                <div
                    class="w-full sm:w-100 leading-relaxed text-white text-opacity-70 dark:text-gray-600 dark:text-opacity-100 mt-3">
                    <strong>{{ strtoupper(auth()->user()->package->name) }}</strong> -
                    {{ number_format(auth()->user()->package->benefit) }}
                    USDT

                    <div class="progress h-4 w-full bg-gray-200 rounded-full dark:bg-gray-700">
                        <div class="progress-bar text-xs bg-theme-17 font-medium text-blue-100 text-center p-0.5 leading-none rounded-full"
                            style="width: {{ ((auth()->user()->package->benefit +auth()->user()->bonus->where('amount', '<', 0)->sum('amount')) /auth()->user()->package->benefit) *100 }}%">
                            {{ number_format(auth()->user()->package->benefit +auth()->user()->bonus->where('amount', '<', 0)->sum('amount')) }}
                        </div>
                    </div>
                </div>
                <a href="/bonus" class="btn w-100 bg-white dark:bg-dark-2 dark:text-white mt-6 sm:mt-10">Current Bonus
                    :
                    {{ number_format(auth()->user()->bonus->sum('amount')) }}</a>
                <a href="/balance" class="btn w-100 bg-white dark:bg-dark-2 dark:text-white mt-6 sm:mt-10">Balance :
                    {{ number_format(auth()->user()->balance->sum('amount')) }}</a>
            </div>
        </div>
    </div>
    <div class="report-box-2 intro-y mt-5   ">
        <div class="box sm:flex">
            <div class="px-8 py-12 flex flex-col justify-center flex-1">
                <div class="input-group mt-2 width-full">
                    <div class="input-group-text">
                        Left Referral
                    </div>
                    <input type="text" class="form-control" placeholder="Price" disabled
                        value="{{ url('/registration/' . auth()->user()->username . '/l') }}">
                    <button onclick="copyUrl('{{ url('/registration/' . auth()->user()->username . '/l') }}')"
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
                        value="{{ url('/registration/' . auth()->user()->username . '/r') }}">
                    <button onclick="copyUrl('{{ url('/registration/' . auth()->user()->username . '/r') }}')"
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
