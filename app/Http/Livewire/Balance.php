<?php

namespace App\Http\Livewire;

use App\Models\Deposit;
use App\Models\User;
use Livewire\Component;

class Balance extends Component
{
    public $depositWallet;

    public function doneDeposit()
    {
        $this->validate([
            'depositWallet' => 'required|min:10',
        ]);

        try {
            $deposit = auth()->user()->waitingTransferDeposit()->first();
            $deposit->from_wallet = $this->depositWallet;
            $deposit->save();

            return $this->redirect('/balance');
        } catch (\Exception$e) {
            session()->flash('message', 'danger|' . $e->getMessage());
            return;
        }
    }

    public function cancelDeposit($id)
    {
        Deposit::find($id)->delete();
        return $this->redirect('/balance');
    }

    public function render()
    {
        return view('livewire.balance');
    }
}
