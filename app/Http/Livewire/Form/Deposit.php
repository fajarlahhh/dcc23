<?php

namespace App\Http\Livewire\Form;

use App\Models\Deposit as ModelsDeposit;
use App\Rules\PinRule;
use App\Rules\WaitingtransferdepositRule;
use App\Traits\MasteruserTrait;
use Livewire\Component;

class Deposit extends Component
{
    use MasteruserTrait;

    public $amount, $pin, $waiting;

    public function submit()
    {
        $this->validate([
            'amount' => 'required|numeric',
            'pin' => ['required', 'numeric', new PinRule()],
            'waiting' => [new WaitingtransferdepositRule()],
        ]);

        try {
            $deposit = new ModelsDeposit();
            $deposit->to_wallet = $this->masterUser->wallet;
            $deposit->amount = $this->amount;
            $deposit->save();

            return $this->redirect('/balance');
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
