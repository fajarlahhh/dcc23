<?php

namespace App\Http\Livewire;

use App\Models\Deposit;
use App\Models\User;
use App\Traits\MasteruserTrait;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class Balance extends Component
{
    use MasteruserTrait;

    public $depositAmount, $depositWallet, $sendAmount, $sendUsername;

    public function send()
    {
        $this->validate([
            'sendAmount' => 'required|numeric',
            'sendUsername' => 'required|numeric',
        ]);

        try {
            if (User::where('username', $this->sendUsername)->count() > 0) {
                DB::transaction(function () {
                    $sendFrom = new Balance();
                    $sendFrom->description = "Send to " . $this->sendUsername;
                    $sendFrom->amount = -$this->sendAmount;
                    $sendFrom->user_id = auth()->id();
                    $sendFrom->save();

                    $sendFrom = new Balance();
                    $sendFrom->description = "Received from " . auth()->user()->username;
                    $sendFrom->amount = $this->sendAmount;
                    $sendFrom->user_id = User::where('username', $this->sendUsername)->first()->getKey();;
                    $sendFrom->save();
                });
                return $this->redirect('/balance');
            }
        } catch (\Exception$e) {
            session()->flash('message', 'danger|' . $e->getMessage());
            return;
        }
    }

    public function deposit()
    {
        $this->validate([
            'depositAmount' => 'required|numeric',
        ]);

        try {
            if (auth()->user()->waitingTransferDeposit()) {
                $deposit = new Deposit();
                $deposit->to_wallet = $this->masterUser->wallet;
                $deposit->amount = $this->depositAmount;
                $deposit->save();
            }
        } catch (\Exception$e) {
            session()->flash('message', 'danger|' . $e->getMessage());
            return;
        }
    }

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

    public function booted()
    {
        $this->reset(['depositWallet', 'depositAmount', 'sendAmount', 'sendUsername']);
    }

    public function render()
    {
        return view('livewire.balance');
    }
}
