<div>
    <div class="grid grid-cols-12 gap-6 mt-5">
        <div class="intro-y col-span-12 lg:col-span-12">
            <div class="intro-y box">
                <div class="flex flex-col sm:flex-row items-center p-5 border-b border-gray-200 dark:border-dark-5">
                    <h2 class="font-medium text-base mr-auto">
                        Bonus History
                    </h2>
                    <div class="w-full sm:w-auto flex items-center sm:ml-auto mt-3 sm:mt-0">
                        <select class="form-select mt-2 sm:mr-2" aria-label="Default select example" wire:model="tipe">
                            <option value="daily">Daily Bonus</option>
                            <option value="pairing">Pairing Bonus</option>
                            <option value="sponsor">Sponsor Bonus</option>
                        </select>
                        <select class="form-select mt-2 sm:mr-2" aria-label="Default select example" wire:model="month">
                            @for ($i = 1; $i <= 12; $i++)
                                <option value="{{ sprintf('%02s', $i) }}">
                                    {{ DateTime::createFromFormat('!m', $i)->format('F') }}</option>
                            @endfor
                        </select>
                        <select class="form-select mt-2 sm:mr-2" aria-label="Default select example" wire:model="year">
                            @for ($i = 2023; $i <= date('Y'); $i++)
                                <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                </div>
                <div class="p-5 overflow-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Datetime</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Description</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Amount</th>
                                <th class="border border-b-2 dark:border-dark-5 whitespace-nowrap">Valid</th </tr>
                        </thead>
                        <tbody>
                            @foreach ($data as $row)
                                <tr>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->created_at }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ $row->description }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap">
                                        {{ number_format($row->amount) }}</td>
                                    <td class="border border-b-2 dark:border-dark-5 whitespace-nowrap text-center">
                                        {{ $row->invalid == 1 ? 'N' : 'Y' }}
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
