<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Request WD
                    </h2>
                </div>
                <div class="p-5 overflow-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Username</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">From Wallet</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">To Wallet</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Amount</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ ++$i }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->user->username }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->user->name }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->from_wallet }}
                                    </td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->to_wallet }}
                                    </td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ number_format($row->amount) }}
                                    </td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-center">
                                        @if ($process == $row->id)
                                            <a href="javascript:;" class="btn btn-secondary" wire:click="done">Process</a>
                                            <a href="javascript:;" class="btn btn-secondary" wire:click="setProcess">Cancel</a>
                                        @else
                                            <a href="javascript:;" class="btn btn-secondary"
                                                wire:click="setProcess({{ $row->id }})">Process
                                            </a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-6 lg:col-span-6">
            {{ $data->links() }}
        </div>
        <div class="intro-y col-span-6 lg:col-span-6 text-right">
            <button type="button" class="btn btn-secondary" disabled>Total Data : {{ $data->total() }}</button>
        </div>
    </div>
</div>
