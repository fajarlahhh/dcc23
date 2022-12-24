<?php

namespace App\Http\Livewire\Form;

use App\Models\Balance;
use App\Models\Bonus;
use App\Models\Withdrawal as ModelsWithdrawal;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Withdrawal extends Component
{
    public $withdrawalAmount, $withdrawalDestination = 'balance', $pin;

    public function withdrawal()
    {
        $this->validate([
            'withdrawalAmount' => 'required|numeric|min:15',
            'withdrawalDestination' => 'required',
        ]);

        try {
            if (auth()->user()->pin != $this->pin) {
                session()->flash('message', 'danger|Invalid PIN');
            } else {
                $wd = true;
                if (auth()->user()->bonus->sum('amount') < auth()->user()->package->minimum_withdrawal) {
                    session()->flash('message', 'danger|WD Amount less than Min. WD');
                    $wd = false;
                }
                if (auth()->user()->withdrawal->filter(function ($item) {
                    return false !== stristr($item->created_at, date('Y-m-d'));
                })->count() > 0) {
                    session()->flash('message', 'danger|WD can only be done once a day');
                    $wd = false;
                }
                if (auth()->user()->package->benefit < $this->withdrawalAmount) {
                    session()->flash('message', 'danger|WD Amount more than remaining benefit');
                    $wd = false;
                }
                if ($this->withdrawalAmount < auth()->user()->package->minimum_withdrawal) {
                    session()->flash('message', 'danger|WD Amount must be greater than ' . auth()->user()->package->minimum_withdrawal);
                    $wd = false;
                }

                if ($wd == true) {
                    DB::transaction(function () {
                        $fee = auth()->user()->package->fee_withdrawal;

                        $withdrawal = new ModelsWithdrawal();
                        $withdrawal->to_wallet = auth()->user()->wallet;
                        $withdrawal->amount = $this->withdrawalAmount - $fee;
                        $withdrawal->fee = $fee;
                        $withdrawal->save();

                        $bonus = new Bonus();
                        $bonus->description = 'Withdrawal to ' . $this->withdrawalDestination;
                        $bonus->amount = -$this->withdrawalAmount;
                        $bonus->withdrawal_id = $withdrawal->id;
                        $bonus->user_id = auth()->id();
                        $bonus->save();

                        if ($this->withdrawalDestination == 'balance') {
                            ModelsWithdrawal::where('id', $withdrawal->id)->update([
                                'processed_at' => now(),
                                'txid' => 'balance',
                            ]);

                            $balance = new Balance();
                            $balance->description = 'Withdrawal to balance';
                            $balance->amount = $this->withdrawalAmount - $fee;
                            $balance->withdrawal_id = $withdrawal->id;
                            $balance->user_id = auth()->id();
                            $balance->save();
                        }
                    });
                    return $this->redirect('/bonus');
                }
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
