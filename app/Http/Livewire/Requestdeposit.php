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
            $wd = Deposit::findOrFail($this->process);
            $wd->processed_at = now();
            $wd->save();

            $balance = new Balance();
            $balance->description = "Top up";
            $balance->amount = $wd->amount;
            $balance->user_id = $wd->user_id;
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
            'data' => Deposit::with('user')->when($this->status == 1, fn($q) => $q->whereNull('processed_at'))->when($this->status == 2, fn($q) => $q->where('processed_at', 'like', $this->year . '-' . $this->month . '%'))->get(),
        ]);
    }
}
