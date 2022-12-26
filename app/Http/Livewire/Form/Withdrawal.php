<?php

namespace App\Http\Livewire\Form;

use App\Models\Balance;
use App\Models\Bonus;
use App\Models\Withdrawal as ModelsWithdrawal;
use App\Rules\PinRule;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Withdrawal extends Component
{
    public $amount, $destination = 'balance', $pin, $bonusTotal, $minWd, $maxWd, $benefit;

    public function mount()
    {
        $this->bonusTotal = auth()->user()->bonus->sum('amount');
        $this->minWd = auth()->user()->package->minimum_withdrawal;
        $this->maxWd = auth()->user()->package->maximum_withdrawal;
        $this->benefit = auth()->user()->package->benefit;
    }

    public function withdrawal()
    {
        $this->validate([
            'amount' => [
                'required',
                'numeric',
                'min:' . $this->minWd,
                'max:' . ($this->bonusTotal > $this->maxWd ? ($this->maxWd > $this->benefit ? $this->benefit : $this->maxWd) : $this->bonusTotal)],
            'destination' => 'required',
            'pin' => ['required', 'numeric', new PinRule()],
        ]);

        try {
            $wd = true;
            if (auth()->user()->withdrawal->filter(function ($item) {
                return false !== stristr($item->created_at, date('Y-m-d'));
            })->count() > 0) {
                session()->flash('message', 'danger|WD can only be done once a day');
                $wd = false;
            }

            if ($wd == true) {
                DB::transaction(function () {
                    $fee = auth()->user()->package->fee_withdrawal;

                    $withdrawal = new ModelsWithdrawal();
                    $withdrawal->to_wallet = auth()->user()->wallet;
                    $withdrawal->amount = $this->amount - $fee;
                    $withdrawal->fee = $fee;
                    $withdrawal->save();

                    $bonus = new Bonus();
                    $bonus->description = 'Withdrawal to ' . $this->destination;
                    $bonus->amount = -$this->amount;
                    $bonus->withdrawal_id = $withdrawal->id;
                    $bonus->user_id = auth()->id();
                    $bonus->save();

                    if ($this->destination == 'balance') {
                        ModelsWithdrawal::where('id', $withdrawal->id)->update([
                            'processed_at' => now(),
                            'txid' => 'balance',
                        ]);

                        $balance = new Balance();
                        $balance->description = 'Withdrawal to balance';
                        $balance->amount = $this->amount - $fee;
                        $balance->withdrawal_id = $withdrawal->id;
                        $balance->user_id = auth()->id();
                        $balance->save();
                    }
                });
                return $this->redirect('/bonus');
            }
        } catch (\Exception$e) {
            session()->flash('message', 'danger|' . $e->getMessage());
            return;
        }
    }

    public function render()
    {
        return view('livewire.form.withdrawal');
    }
}
