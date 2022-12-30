<div>
    <x-info />
    <x-alert />
    <div class="grid grid-cols-12 gap-6 mt-5">
        @if ($daily)
            <div class="intro-y col-span-12 lg:col-span-12">
                <div class="intro-y box">
                    <form wire:submit.prevent="submit">
                        <div>
                            <table class="table">
                                <tr>
                                    <th>Date</th>
                                    <th>Bonus (%)</th>
                                </tr>
                                @foreach ($daily as $i => $row)
                                    <tr>
                                        <td>
                                            <input type="text" class="form-control"
                                                wire:model.defer="daily.{{ $i }}.date" autocomplete="off"
                                                readonly>
                                        </td>
                                        <td>
                                            <input type="number" step="any" min="0" class="form-control"
                                                wire:model.defer="daily.{{ $i }}.bonus" autocomplete="off">
                                        </td>
                                    </tr>
                                @endforeach
                            </table>
                        </div>
                        <div class="pr-5 pb-5 text-right">
                            <input type="submit" value="Submit" class="btn btn-success">
                        </div>
                    </form>
                </div>
            </div>
        @endif
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Data Daily Bonus
                    </h2>
                </div>
                <div class="p-5 overflow-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Data</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Persen</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $i => $row)
                                <tr>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ ++$i }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->date }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->amount }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-center">
                                        @if ($delete == $row->id)
                                            <a href="javascript:;" class="btn btn-secondary"
                                                wire:click="delete">Delete</a>
                                            <a href="javascript:;" class="btn btn-secondary"
                                                wire:click="setDelete">Cancel</a>
                                        @else
                                            <a href="javascript:;" class="btn btn-secondary"
                                                wire:click="setDelete({{ $row->id }})">Delete</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
