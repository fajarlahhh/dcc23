<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Request Deposit
                    </h2>
                    <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                        @if ($status == 2)
                            <select class="form-select mt-2 sm:mr-2" aria-label="Default select example"
                                wire:model="month">
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ sprintf('%02s', $i) }}">
                                        {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                                @endfor
                            </select>
                            <select class="form-select mt-2 sm:mr-2" aria-label="Default select example"
                                wire:model="year">
                                @for ($i = 2023; $i <= date('Y'); $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                        @endif
                        <select class="form-select mt-2 sm:mr-2" aria-label="Default select example"
                            wire:model="status">
                            <option value="1">Waiting</option>
                            <option value="2">Processed</option>
                        </select>
                    </div>
                </div>
                <div class="p-5 overflow-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Datetime</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Username</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">From Wallet</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">To Wallet</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Amount</th>
                                @if ($status == 1)
                                    <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $key => $row)
                                <tr>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ ++$key }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->created_at }}</td>
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
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-right">
                                        {{ number_format($row->amount) }}
                                    </td>
                                    @if ($status == 1)
                                        <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-center">
                                            @if ($process == $row->id)
                                                <a href="javascript:;" class="btn btn-success" wire:click="done">Yes,
                                                    Process</a>
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setProcess">Cancel</a>
                                            @elseif ($delete == $row->id)
                                                <a href="javascript:;" class="btn btn-success"
                                                    wire:click="doDelete">Yes,
                                                    Delete</a>
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setDelete">Cancel</a>
                                            @else
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setProcess({{ $row->id }})">Process
                                                </a>
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setDelete({{ $row->id }})">Delete
                                                </a>
                                            @endif
                                        </td>
                                    @endif
                                </tr>
                            @endforeach
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="6"
                                    class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-right">Total</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-right">
                                    {{ number_format($data->sum('amount')) }}</th>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
        </div>
        <div class="intro-y col-span-6 lg:col-span-6">
            {{-- {{ $data->links() }} --}}
        </div>
        <div class="intro-y col-span-6 lg:col-span-6 text-right">
            <button type="button" class="btn btn-secondary" disabled>Total Data : {{ $data->count() }}</button>
        </div>
    </div>
</div>
