<?php

namespace App\Http\Livewire\Form;

use App\Models\Bonus;
use App\Models\User;
use App\Models\Withdrawal as ModelsWithdrawal;
use App\Rules\DayRule;
use App\Rules\HourRule;
use App\Rules\PinRule;
use App\Rules\WalletRule;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Withdrawal extends Component
{
    public $amount, $destination = 'balance', $pin, $bonusTotal, $minWd, $maxWd, $benefit, $wallet, $hour, $today;

    public function mount()
    {
        $this->today = Carbon::now()->dayOfWeek;
        $this->hour = date('His');
        $this->bonusTotal = auth()->user()->bonus->whereNull('invalid')->sum('amount');
        $this->minWd = auth()->user()->package->minimum_withdrawal;
        $this->maxWd = auth()->user()->package->maximum_withdrawal;
        $this->benefit = auth()->user()->package->benefit + auth()->user()->bonus->whereNull('invalid')->where('amount', '<', 0)->sum('amount');
    }

    public function withdrawal()
    {
        // if ($this->destination == 'balance') {
        //     $this->validate([
        //         'amount' => [
        //             'required',
        //             'numeric',
        //             'min:' . $this->minWd,
        //             'max:' . ($this->bonusTotal > $this->maxWd ? ($this->maxWd > $this->benefit ? $this->benefit : $this->maxWd) : $this->bonusTotal)],
        //         'destination' => 'required',
        //         'hour' => new HourRule(),
        //         'today' => new DayRule(),
        //         'pin' => ['required', 'numeric', new PinRule()],
        //     ]);
        // } else {
        $this->validate([
            'amount' => [
                'required',
                'numeric',
                'min:' . $this->minWd,
                'max:' . ($this->bonusTotal > $this->maxWd ? ($this->maxWd > $this->benefit ? $this->benefit : $this->maxWd) : $this->bonusTotal)],
            // 'destination' => 'required',
            'hour' => new HourRule(),
            'today' => new DayRule(),
            'wallet' => new WalletRule(),
            'pin' => ['required', 'numeric', new PinRule()],
        ]);
        // }

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
                    // if ($this->destination == 'wallet') {
                    $withdrawal->to_wallet = auth()->user()->wallet;
                    // } else {
                    //     $withdrawal->to_wallet = 'balance';
                    // }
                    $withdrawal->amount = $this->amount - $fee;
                    $withdrawal->fee = $fee;
                    $withdrawal->save();

                    $bonus = new Bonus();
                    $bonus->description = 'Withdrawal to wallet';
                    $bonus->amount = -$this->amount;
                    $bonus->withdrawal_id = $withdrawal->id;
                    $bonus->user_id = auth()->id();
                    $bonus->save();

                    // if ($this->destination == 'balance') {
                    //     ModelsWithdrawal::where('id', $withdrawal->id)->update([
                    //         'processed_at' => now(),
                    //         'txid' => 'balance',
                    //     ]);

                    //     $balance = new Balance();
                    //     $balance->description = 'Withdrawal to balance';
                    //     $balance->amount = $this->amount - $fee;
                    //     $balance->withdrawal_id = $withdrawal->id;
                    //     $balance->user_id = auth()->id();
                    //     $balance->save();
                    // }

                    if (auth()->user()->package->benefit +
                        auth()->user()->bonus->whereNull('invalid')->where('amount', '<', 0)->sum('amount') <
                        auth()->user()->package->minimum_withdrawal) {
                        User::where('id', auth()->id())->update([
                            'activated_at' => null,
                        ]);
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
