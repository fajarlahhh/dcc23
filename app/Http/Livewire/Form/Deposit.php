<?php

namespace App\Http\Livewire\Form;

use App\Models\Deposit as ModelsDeposit;
use App\Traits\MasteruserTrait;
use Livewire\Component;

class Deposit extends Component
{
    use MasteruserTrait;

    public $amount, $pin;

    public function submit()
    {
        $this->validate([
            'amount' => 'required|numeric',
        ]);

        try {
            if (auth()->user()->pin != $this->pin) {
                session()->flash('message', 'danger|Invalid PIN');
            } else {
                if (auth()->user()->waitingTransferDeposit()) {
                    $deposit = new ModelsDeposit();
                    $deposit->to_wallet = $this->masterUser->wallet;
                    $deposit->amount = $this->amount;
                    $deposit->save();

                    return $this->redirect('/balance');
                } else {
                    session()->flash('message', 'danger|You cannot do this action');
                }
            }
        } catch (\Exception$e) {
            session()->flash('message', 'danger|' . $e->getMessage());
            return;
        }
    }
    public function render()
    {
        return view('livewire.form.deposit');
    }
}
