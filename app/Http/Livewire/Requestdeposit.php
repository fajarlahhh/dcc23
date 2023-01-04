<?php

namespace App\Http\Livewire;

use App\Models\Balance;
use App\Models\Deposit;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class Requestdeposit extends Component
{
    use WithPagination;
    public $status = 1, $year, $month, $process;
    protected $queryString = ['status', 'year', 'month'];

    public function setProcess($process = null)
    {
        $this->process = $process;
    }

    public function done()
    {
        DB::transaction(function ($q) {
            $deposit = Deposit::findOrFail($this->process);
            $deposit->processed_at = now();
            $deposit->save();

            $balance = new Balance();
            $balance->description = "Top up";
            $balance->amount = $deposit->amount;
            $balance->user_id = $deposit->user_id;
            $balance->save();
        });
    }

    public function mount()
    {
        $this->year = $this->year ?: date('Y');
        $this->month = $this->month ?: date('m');
    }

    public function render()
    {
        return view('livewire.requestdeposit', [
            // 'i' => ($this->page - 1) * 10,
            'data' => Deposit::with('user')->when($this->status == 1, fn($q) => $q->whereNull('processed_at'))->when($this->status == 2, fn($q) => $q->where('processed_at', 'like', $this->year . '-' . $this->month . '%'))->whereNull('registration')->get(),
        ]);
    }
}
