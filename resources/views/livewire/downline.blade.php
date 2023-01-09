<div>
    <x-info />
    <div class="intro-y grid grid-cols-12 gap-6 mt-5">
        <div class="col-span-12 lg:col-span-4 intro-y">
            <div class="intro-x flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Downline
                </h2>
            </div>
            <div class="report-box zoom-in">
                <div class="box p-5">
                    <div class="flex">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" class="feather feather-users report-box__icon text-theme-21">
                            <path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path>
                            <circle cx="9" cy="7" r="4"></circle>
                            <path d="M23 21v-2a4 4 0 0 0-3-3.87"></path>
                            <path d="M16 3.13a4 4 0 0 1 0 7.75"></path>
                        </svg>
                        <div class="ml-auto">
                            @if (auth()->user()->package->benefit +
                                auth()->user()->bonus->where('amount', '<', 0)->sum('amount') >
                                auth()->user()->package->minimum_withdrawal)
                                <a href="javascript:;" data-toggle="modal" data-target="#modal-registration"
                                    class="btn btn-success w-24">Registration</a>
                            @endif
                        </div>
                    </div>
                    <div class="text-base text-gray-600 mt-1">Turnover</div>
                    <div class="text-1xl font-bold leading-8 mt-6">
                        Left :
                        {{ number_format((int) $network->valid_left - (int) $network->invalidLeft->sum('amount')) }}
                        <br>
                        Right :
                        {{ number_format((int) $network->valid_right - (int) $network->invalidRight->sum('amount')) }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-span-12 lg:col-span-8 intro-y">
            <div class="intro-x flex items-center h-10">
                <h2 class="text-lg font-medium truncate mr-5">
                    Network
                </h2>
            </div>
            <div class="intro-y sm:gap-6 gap-y-6 box px-5 py-8 ">
                <input type="text" class="form-control" wire:model.lazy="username" autocomplete="off"
                    placeholder="Search Username">
                <table class="table">
                    <tr>
                        @if ($network)
                            <td colspan="4" class="text-center border-b dark:border-dark-5" style="width: 100%">
                                <img src="/dist/images/logo.png" class="w-10" alt=""
                                    style="display: block;margin-left: auto;margin-right: auto;">
                                {{ $network->username }} - <small>{{ $network->name }}</small>
                                <br>
                                {{ number_format((int) $network->valid_left - (int) $network->invalidLeft->sum('amount')) }}
                                |
                                {{ number_format((int) $network->valid_right - (int) $network->invalidRight->sum('amount')) }}
                            </td>
                        @else
                            <td>
                                &nbsp;<br>
                                &nbsp;<br>
                                &nbsp;
                            </td>
                        @endif
                    </tr>
                    <tr>
                        <td colspan="2" class="text-center border-b dark:border-dark-5" style="width: 50%">
                            @php
                                $downline1Left = $network->downline->filter(function ($item) {
                                    return false !== stristr(substr($item->network, -1), 'l');
                                });
                            @endphp
                            @if ($downline1Left->count() > 0)
                                <img src="/dist/images/logo.png" class="w-10" alt=""
                                    style="display: block;margin-left: auto;margin-right: auto;">
                                {{ $downline1Left->first()->username }} -
                                <small>{{ $downline1Left->first()->name }}</small>
                                <br>
                                {{ number_format((int) $downline1Left->first()->valid_left - (int) $downline1Left->first()->invalidLeft->sum('amount')) }}
                                |
                                {{ number_format((int) $downline1Left->first()->valid_right - (int) $downline1Left->first()->invalidRight->sum('amount')) }}
                            @else
                                &nbsp;<br>
                                &nbsp;<br>
                                &nbsp;
                            @endif
                        </td>
                        <td colspan="2" class="text-center border-b dark:border-dark-5" style="width: 50%">
                            @php
                                $downline1Right = $network->downline->filter(function ($item) {
                                    return false !== stristr(substr($item->network, -1), 'r');
                                });
                            @endphp
                            @if ($downline1Right->count() > 0)
                                <img src="/dist/images/logo.png" class="w-10" alt=""
                                    style="display: block;margin-left: auto;margin-right: auto;">
                                {{ $downline1Right->first()->username }} -
                                <small>{{ $downline1Right->first()->name }}</small>
                                <br>
                                {{ number_format((int) $downline1Right->first()->valid_left - (int) $downline1Right->first()->invalidLeft->sum('amount')) }}
                                |
                                {{ number_format((int) $downline1Right->first()->valid_right - (int) $downline1Right->first()->invalidRight->sum('amount')) }}
                            @else
                                &nbsp;<br>
                                &nbsp;<br>
                                &nbsp;
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <td class="text-center border-b dark:border-dark-5" style="width: 25%">
                            @if ($downline1Left->first())
                                @php
                                    $downline2Left = $downline1Left->first()->downline->filter(function ($item) {
                                        return false !== stristr(substr($item->network, -1), 'l');
                                    });
                                @endphp
                                @if ($downline2Left->count() > 0)
                                    <img src="/dist/images/logo.png" class="w-10" alt=""
                                        style="display: block;margin-left: auto;margin-right: auto;">
                                    {{ $downline2Left->first()->username }} -
                                    <small>{{ $downline2Left->first()->name }}</small>
                                    <br>
                                    {{ number_format((int) $downline2Left->first()->valid_left - (int) $downline2Left->first()->invalidLeft->sum('amount')) }}
                                    |
                                    {{ number_format((int) $downline2Left->first()->valid_right - (int) $downline2Left->first()->invalidRight->sum('amount')) }}
                                    <br>
                                    @if ($downline2Left->first()->downline->count() > 0)
                                        <a href="/downline?key={{ $downline2Left->first()->id }}"
                                            class="btn btn-sm btn-secondary">Next</a>
                                    @endif
                                @endif
                            @else
                                &nbsp;<br>
                                &nbsp;<br>
                                &nbsp;
                            @endif
                        </td>
                        <td class="text-center border-b dark:border-dark-5" style="width: 25%">
                            @if ($downline1Left->first())
                                @php
                                    $downline2Right = $downline1Left->first()->downline->filter(function ($item) {
                                        return false !== stristr(substr($item->network, -1), 'r');
                                    });
                                @endphp
                                @if ($downline2Right->count() > 0)
                                    <img src="/dist/images/logo.png" class="w-10" alt=""
                                        style="display: block;margin-left: auto;margin-right: auto;">
                                    {{ $downline2Right->first()->username }} -
                                    <small>{{ $downline2Right->first()->name }}</small>
                                    <br>
                                    {{ number_format((int) $downline2Right->first()->valid_left - (int) $downline2Right->first()->invalidLeft->sum('amount')) }}
                                    |
                                    {{ number_format((int) $downline2Right->first()->valid_right - (int) $downline2Right->first()->invalidRight->sum('amount')) }}
                                    <br>
                                    @if ($downline2Right->first()->downline->count() > 0)
                                        <a href="/downline?key={{ $downline2Right->first()->id }}"
                                            class="btn btn-sm btn-secondary">Next</a>
                                    @endif
                                @endif
                            @else
                                &nbsp;<br>
                                &nbsp;<br>
                                &nbsp;
                            @endif
                        </td>
                        <td class="text-center border-b dark:border-dark-5" style="width: 25%">
                            @if ($downline1Right->first())
                                @php
                                    $downline12Left = $downline1Right->first()->downline->filter(function ($item) {
                                        return false !== stristr(substr($item->network, -1), 'l');
                                    });
                                @endphp
                                @if ($downline12Left->count() > 0)
                                    <img src="/dist/images/logo.png" class="w-10" alt=""
                                        style="display: block;margin-left: auto;margin-right: auto;">
                                    {{ $downline12Left->first()->username }} -
                                    <small>{{ $downline12Left->first()->name }}</small>
                                    <br>
                                    {{ number_format((int) $downline12Left->first()->valid_left - (int) $downline12Left->first()->invalidLeft->sum('amount')) }}
                                    |
                                    {{ number_format((int) $downline12Left->first()->valid_right - (int) $downline12Left->first()->invalidRight->sum('amount')) }}
                                    <br>
                                    @if ($downline12Left->first()->downline->count() > 0)
                                        <a href="/downline?key={{ $downline12Left->first()->id }}"
                                            class="btn btn-sm btn-secondary">Next</a>
                                    @endif
                                @endif
                            @else
                                &nbsp;<br>
                                &nbsp;<br>
                                &nbsp;
                            @endif
                        </td>
                        <td class="text-center border-b dark:border-dark-5" style="width: 25%">
                            @if ($downline1Right->first())
                                @php
                                    $downline12Right = $downline1Right->first()->downline->filter(function ($item) {
                                        return false !== stristr(substr($item->network, -1), 'r');
                                    });
                                @endphp
                                @if ($downline12Right->count() > 0)
                                    <img src="/dist/images/logo.png" class="w-10" alt=""
                                        style="display: block;margin-left: auto;margin-right: auto;">
                                    {{ $downline12Right->first()->username }} -
                                    <small>{{ $downline12Right->first()->name }}</small>
                                    <br>
                                    {{ number_format((int) $downline12Right->first()->valid_left - (int) $downline12Right->first()->invalidLeft->sum('amount')) }}
                                    |
                                    {{ number_format((int) $downline12Right->first()->valid_right - (int) $downline12Right->first()->invalidRight->sum('amount')) }}
                                    <br>
                                    @if ($downline12Right->first()->downline->count() > 0)
                                        <a href="/downline?key={{ $downline12Right->first()->id }}"
                                            class="btn btn-sm btn-secondary">Next</a>
                                    @endif
                                @endif
                            @else
                                &nbsp;<br>
                                &nbsp;<br>
                                &nbsp;
                            @endif
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
    <x-modal title='Registration'>
        @livewire('form.registration')
    </x-modal>
</div>
