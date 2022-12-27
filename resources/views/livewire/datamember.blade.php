<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Data Member
                    </h2>
                    <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                        <select class="form-select mt-2 sm:mr-2" aria-label="Default select example" wire:model="exist">
                            <option value="1">Exist</option>
                            <option value="2">Deleted</option>
                        </select>
                    </div>
                </div>
                <div class="p-5 overflow-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">#</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Username</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Name</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Wallet</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Package</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Upline</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Sponsor</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                    @if ($exist == 1)
                                        Active
                                    @else
                                        Inactive
                                    @endif
                                </th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap"></th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ ++$i }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->username }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->name }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ substr($row->wallet, 0, 4) . '....' . substr($row->wallet, -4) }}
                                    </td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->package }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->upline->username }}
                                    </td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->sponsor->username }}
                                    </td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        @if ($exist == 1)
                                            {{ $row->activated_at }}
                                        @else
                                            {{ $row->deleted_at }}
                                        @endif
                                    </td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-center">
                                        @if ($exist == 1)
                                            @if ($reset == $row->id)
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="resetPassword">Reset</a>
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setReset">Batal</a>
                                            @elseif ($delete == $row->id)
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="delete">Delete</a>
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setDelete">Batal</a>
                                            @else
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setReset({{ $row->id }})">Reset
                                                    Pwd</a>
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setDelete({{ $row->id }})">Delete</a>
                                            @endif
                                        @else
                                            @if ($restore == $row->id)
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="restore">Restore</a>
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setRestore">Batal</a>
                                            @else
                                                <a href="javascript:;" class="btn btn-secondary"
                                                    wire:click="setRestore({{ $row->id }})">Restore</a>
                                            @endif
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
